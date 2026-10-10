<?php

/*
|--------------------------------------------------------------------------
| helpers.php  (BARU - Jobsheet 12)
|--------------------------------------------------------------------------
| e()  : escape output ke HTML  -> mencegah XSS
| Pembantu kecil lain: response error, pembatas method/role, log error DB.
*/

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* Response error sederhana (pesan sudah di-escape) */
function abort_with(string $message, int $status = 400): void
{
    http_response_code($status);

    echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8">'
        . '<title>Terjadi Kesalahan</title></head>'
        . '<body style="font-family:sans-serif;padding:2rem">'
        . '<h2>Terjadi Kesalahan</h2><p>' . e($message) . '</p>'
        . '<p><a href="javascript:history.back()">Kembali</a></p></body></html>';

    exit;
}

function require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        abort_with('Method tidak diperbolehkan.', 405);
    }
}

function require_admin(): void
{
    if (($_SESSION['role'] ?? '') !== 'admin') {
        abort_with('Akses ditolak. Hanya admin yang boleh melakukan aksi ini.', 403);
    }
}

/* Log error asli ke server, tampilkan pesan umum ke user */
function handle_db_error(PDOException $e, array $known = []): void
{
    $code = $e->getCode();

    if (isset($known[$code])) {
        abort_with($known[$code], 409);
    }

    error_log('[DB ERROR] ' . $e->getMessage());
    abort_with('Terjadi kesalahan pada server. Silakan coba lagi.', 500);
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 12 - aturan bisnis & tampilan peminjaman
|--------------------------------------------------------------------------
*/

// Batas hari peminjaman: lewat dari ini & belum kembali = TERLAMBAT
const BATAS_HARI_PINJAM = 14;

/* Status di database: 'Dipinjam' / 'Selesai'. Tampilan: 'Dipinjam' / 'Dikembalikan'. */
function status_label(string $status): string
{
    return $status === 'Selesai' ? 'Dikembalikan' : $status;
}

function status_class(string $status): string
{
    return $status === 'Selesai' ? 'status-badge selesai' : 'status-badge';
}

/*
| Potongan SQL "peminjaman terlambat" (dipakai di banyak query).
| Angka berasal dari konstanta int, bukan dari input user, sehingga aman.
| Catatan: parameter bernama yang sama tidak boleh dipakai dua kali pada
| prepared statement asli, karena itu konstanta ditulis langsung.
*/
function sql_terlambat(string $alias = 'p'): string
{
    return "($alias.status = 'Dipinjam' AND $alias.tanggal_pinjam < CURRENT_DATE - "
        . (int) BATAS_HARI_PINJAM . ")";
}

/* Nilai boolean dari PostgreSQL bisa berupa true/'t'/1 tergantung versi driver */
function db_bool($v): bool
{
    return $v === true || $v === 't' || $v === '1' || $v === 1;
}
