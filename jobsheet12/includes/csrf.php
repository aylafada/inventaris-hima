<?php

/*
|--------------------------------------------------------------------------
| csrf.php  (BARU - Jobsheet 12)
|--------------------------------------------------------------------------
| csrf_token()  : buat / ambil token (bin2hex(random_bytes(32))) di session
| csrf_field()  : <input type="hidden"> siap tempel di dalam <form>
| csrf_verify() : cek token POST dengan hash_equals(); salah -> HTTP 403
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_verify(): void
{
    $sent = $_POST['csrf_token'] ?? '';
    $real = $_SESSION['csrf_token'] ?? '';

    if (!is_string($sent) || $real === '' || !hash_equals($real, $sent)) {
        http_response_code(403);
        exit('403 Forbidden: token CSRF tidak valid. Muat ulang halaman lalu coba lagi.');
    }
}
