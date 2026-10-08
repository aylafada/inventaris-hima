<?php

/*
|--------------------------------------------------------------------------
| session_db.php - Session disimpan di database (PostgreSQL/Supabase)
|--------------------------------------------------------------------------
| MASALAH: di Vercel, PHP berjalan sebagai function serverless. Session
| bawaan PHP disimpan sebagai FILE di /tmp milik satu instance, sehingga
| request berikutnya yang dilayani instance lain tidak menemukan session
| dan pengguna dilempar kembali ke halaman login.
|
| SOLUSI: simpan session di tabel `sessions` yang dipakai bersama semua
| instance. Ini juga memperkuat keamanan: dengan use_strict_mode, ID session
| yang tidak dikenal server ditolak (menambah perlindungan session fixation).
*/

class DbSessionHandler implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{
    private PDO $pdo;
    private int $ttl;

    public function __construct(PDO $pdo, int $ttl = 7200)
    {
        $this->pdo = $pdo;
        $this->ttl = $ttl;      // masa aktif sejak aktivitas terakhir (detik)
    }

    /* Buat tabel jika belum ada (cadangan; sebaiknya jalankan data/sessions.sql) */
    private function ensureTable(): void
    {
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS sessions (
                id            VARCHAR(128) PRIMARY KEY,
                data          TEXT NOT NULL,
                last_activity BIGINT NOT NULL
            )
        ');
        $this->pdo->exec('CREATE INDEX IF NOT EXISTS sessions_last_activity_idx ON sessions (last_activity)');
        // Tabel ini TIDAK boleh bisa dibaca lewat Data API Supabase (anon key bersifat publik)
        $this->pdo->exec('ALTER TABLE sessions ENABLE ROW LEVEL SECURITY');
    }

    /* Jalankan query; jika tabel belum ada (42P01), buat lalu ulangi sekali */
    private function run(string $sql, array $params): PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt;
        } catch (PDOException $e) {
            if ($e->getCode() !== '42P01') {
                throw $e;
            }

            $this->ensureTable();

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt;
        }
    }

    #[\ReturnTypeWillChange]
    public function open($path, $name)
    {
        return true;
    }

    #[\ReturnTypeWillChange]
    public function close()
    {
        return true;
    }

    #[\ReturnTypeWillChange]
    public function read($id)
    {
        try {
            $stmt = $this->run(
                'SELECT data FROM sessions WHERE id = :id AND last_activity > :batas',
                [':id' => $id, ':batas' => time() - $this->ttl]
            );

            $data = $stmt->fetchColumn();

            // data disimpan base64 agar aman dari karakter biner
            return $data === false ? '' : (string) base64_decode($data, true);
        } catch (PDOException $e) {
            error_log('[SESSION READ] ' . $e->getMessage());

            return '';
        }
    }

    #[\ReturnTypeWillChange]
    public function write($id, $data)
    {
        try {
            $this->run('
                INSERT INTO sessions (id, data, last_activity)
                VALUES (:id, :data, :now)
                ON CONFLICT (id) DO UPDATE
                SET data = EXCLUDED.data, last_activity = EXCLUDED.last_activity
            ', [':id' => $id, ':data' => base64_encode($data), ':now' => time()]);

            return true;
        } catch (PDOException $e) {
            error_log('[SESSION WRITE] ' . $e->getMessage());

            return false;
        }
    }

    #[\ReturnTypeWillChange]
    public function destroy($id)
    {
        try {
            $this->run('DELETE FROM sessions WHERE id = :id', [':id' => $id]);

            return true;
        } catch (PDOException $e) {
            error_log('[SESSION DESTROY] ' . $e->getMessage());

            return false;
        }
    }

    #[\ReturnTypeWillChange]
    public function gc($max_lifetime)
    {
        try {
            return $this->run(
                'DELETE FROM sessions WHERE last_activity < :batas',
                [':batas' => time() - $this->ttl]
            )->rowCount();
        } catch (PDOException $e) {
            error_log('[SESSION GC] ' . $e->getMessage());

            return false;
        }
    }

    /* use_strict_mode: hanya terima ID session yang memang ada di server */
    #[\ReturnTypeWillChange]
    public function validateId($id)
    {
        try {
            $stmt = $this->run(
                'SELECT 1 FROM sessions WHERE id = :id AND last_activity > :batas',
                [':id' => $id, ':batas' => time() - $this->ttl]
            );

            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('[SESSION VALIDATE] ' . $e->getMessage());

            return false;
        }
    }

    /* Dipanggil jika data tidak berubah: cukup perbarui waktu aktivitas */
    #[\ReturnTypeWillChange]
    public function updateTimestamp($id, $data)
    {
        try {
            $this->run(
                'UPDATE sessions SET last_activity = :now WHERE id = :id',
                [':id' => $id, ':now' => time()]
            );

            return true;
        } catch (PDOException $e) {
            error_log('[SESSION TOUCH] ' . $e->getMessage());

            return false;
        }
    }
}
