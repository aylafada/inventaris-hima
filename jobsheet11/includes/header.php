<?php

/*
|--------------------------------------------------------------------------
| header.php - bootstrap bersama (Jobsheet 11)
|--------------------------------------------------------------------------
| 1. BASE_URL otomatis : aplikasi jalan di root (php -S localhost:8000),
|    di virtual host, di sub-folder, maupun di Vercel (mis. /jobsheet11/...)
| 2. Session dengan cookie aman
| 3. Header keamanan
| 4. require_once helpers.php (e()), csrf.php, validasi.php
*/

if (!defined('BASE_URL')) {

    $reqPath = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

    if (preg_match('#^(.*?)/(?:auth|barang|peminjaman|assets)/#', $reqPath, $m)) {
        $base = $m[1];                                   // ...sebelum /barang/, /auth/, dst.
    } elseif (substr($reqPath, -4) === '.php') {
        $base = rtrim(str_replace('\\', '/', dirname($reqPath)), '/');   // /app/index.php -> /app
    } else {
        $base = rtrim($reqPath, '/');                    // /app/ -> /app
    }

    // Rapikan "//" (cegah redirect ke host lain) dan hanya izinkan karakter aman
    $base = preg_replace('#/{2,}#', '/', $base);
    $base = ($base === '/') ? '' : $base;

    // Hanya karakter aman yang boleh masuk ke URL/HTML
    if (!preg_match('#^[A-Za-z0-9_./-]*$#', $base)) {
        $base = '';
    }

    define('BASE_URL', $base);
}

if (session_status() === PHP_SESSION_NONE) {

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header(
        "Content-Security-Policy: default-src 'self'; " .
        "script-src 'self'; style-src 'self' 'unsafe-inline'; " .
        "img-src 'self' data:; frame-ancestors 'none'; " .
        "form-action 'self'; base-uri 'self'"
    );
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/validasi.php';
