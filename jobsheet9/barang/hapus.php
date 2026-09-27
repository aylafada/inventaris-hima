<?php

require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method tidak diperbolehkan.");
}

$id_barang = $_POST['id_barang'] ?? null;

if (!$id_barang) {
    header("Location: /barang/list.php");
    exit;
}

$stmt = $pdo->prepare("
    DELETE FROM barang
    WHERE id_barang = :id_barang
");

$stmt->execute([
    ':id_barang' => $id_barang
]);

header("Location: /barang/list.php");
exit;