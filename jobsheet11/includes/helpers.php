<?php

/*
|--------------------------------------------------------------------------
| helpers.php  (BARU - Jobsheet 11)
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
