<?php
require_once __DIR__ . '/jobsheet10/includes/koneksi.php';

// Jika berhasil terkoneksi tanpa error, ambil nama database yang sedang aktif
$dbname = $pdo->query("SELECT current_database()")->fetchColumn();
$dbuser = $pdo->query("SELECT current_user")->fetchColumn();

echo "<h1>Koneksi Berhasil!</h1>";
echo "<p><strong>Nama Database Aktif:</strong> " . htmlspecialchars($dbname) . "</p>";
echo "<p><strong>Database User:</strong> " . htmlspecialchars($dbuser) . "</p>";
?>
