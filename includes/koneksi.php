<?php
// Konfigurasi koneksi PostgreSQL Supabase
$host = "aws-0-ap-northeast-1.pooler.supabase.com";
$port = "6543";
$db   = "postgres";
$user = "postgres.kowfyaxnyfzxcrkbpqnj";
$pass = "Ayla3081halo";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Koneksi berhasil
} catch (PDOException $e) {
    die("Koneksi ke Supabase gagal: " . $e->getMessage());
}
?>