<?php

/**
 * Session handler menggunakan PostgreSQL.
 *
 * Session disimpan di database agar dapat dibaca
 * oleh permintaan berikutnya di Vercel.
 */

class DbSessionHandler implements
    SessionHandlerInterface,
    SessionUpdateTimestampHandlerInterface
{
    private PDO $pdo;

    private int $ttl;

    public function __construct(PDO $pdo, int $ttl = 7200)
    {
        $this->pdo = $pdo;
        $this->ttl = $ttl;
    }

    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT session_data
                FROM sessions
                WHERE session_id = :id
                  AND last_activity >= :cutoff
            ");

            $stmt->execute([
                ':id' => $id,
                ':cutoff' => time() - $this->ttl
            ]);

            $data = $stmt->fetchColumn();

            return $data === false ? '' : $data;

        } catch (PDOException $e) {
            error_log('[SESSION READ] ' . $e->getMessage());

            return false;
        }
    }

    public function write(string $id, string $data): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO sessions (
                    session_id,
                    session_data,
                    last_activity
                )
                VALUES (
                    :id,
                    :data,
                    :activity
                )
                ON CONFLICT (session_id)
                DO UPDATE SET
                    session_data = EXCLUDED.session_data,
                    last_activity = EXCLUDED.last_activity
            ");

            return $stmt->execute([
                ':id' => $id,
                ':data' => $data,
                ':activity' => time()
            ]);

        } catch (PDOException $e) {
            error_log('[SESSION WRITE] ' . $e->getMessage());

            return false;
        }
    }

    public function destroy(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM sessions
                WHERE session_id = :id
            ");

            return $stmt->execute([
                ':id' => $id
            ]);

        } catch (PDOException $e) {
            error_log('[SESSION DESTROY] ' . $e->getMessage());

            return false;
        }
    }

    public function gc(int $max_lifetime): int|false
    {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM sessions
                WHERE last_activity < :cutoff
            ");

            $stmt->execute([
                ':cutoff' => time() - $max_lifetime
            ]);

            return $stmt->rowCount();

        } catch (PDOException $e) {
            error_log('[SESSION GC] ' . $e->getMessage());

            return false;
        }
    }

    public function validateId(string $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 1
                FROM sessions
                WHERE session_id = :id
                  AND last_activity >= :cutoff
                LIMIT 1
            ");

            $stmt->execute([
                ':id' => $id,
                ':cutoff' => time() - $this->ttl
            ]);

            return $stmt->fetchColumn() !== false;

        } catch (PDOException $e) {
            error_log('[SESSION VALIDATE] ' . $e->getMessage());

            return false;
        }
    }

    public function updateTimestamp(
        string $id,
        string $data
    ): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE sessions
                SET last_activity = :activity
                WHERE session_id = :id
            ");

            $stmt->execute([
                ':activity' => time(),
                ':id' => $id
            ]);

            if ($stmt->rowCount() > 0) {
                return true;
            }

            return $this->write($id, $data);

        } catch (PDOException $e) {
            error_log('[SESSION UPDATE] ' . $e->getMessage());

            return false;
        }
    }
}