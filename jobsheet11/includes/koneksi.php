<?php

$host     = getenv('DB_HOST');
$port     = getenv('DB_PORT') ?: '5432';
$dbname   = getenv('DB_NAME');
$user     = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$sslmode  = getenv('DB_SSLMODE') ?: 'require';   // lokal/Laragon tanpa SSL: set DB_SSLMODE=disable

try {

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode";

    $pdo = new PDO(
        $dsn,
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Prepared statement asli di sisi server (bukan emulasi)
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

} catch (PDOException $e) {

    // Detail error hanya ke log server, bukan ke browser
    error_log('[DB CONNECT] ' . $e->getMessage());

    http_response_code(500);
    die('Koneksi database gagal. Silakan coba lagi nanti.');
}
