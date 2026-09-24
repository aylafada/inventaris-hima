<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'postgres';
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

if (!$host || !$user || !$pass) {
    die(
        "Konfigurasi database belum lengkap. " .
        "Silakan periksa Environment Variables Vercel."
    );
}

try {

    $dsn = "pgsql:" .
           "host={$host};" .
           "port={$port};" .
           "dbname={$db};" .
           "sslmode=require";

    $pdo = new PDO(
        $dsn,
        $user,
        $pass
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $e) {

    die(
        "Koneksi ke Supabase gagal: " .
        $e->getMessage()
    );
}