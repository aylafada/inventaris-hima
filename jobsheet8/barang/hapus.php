<?php

require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt = $pdo->prepare("
        DELETE FROM barang
        WHERE id_barang = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);
}

header("Location: /barang/list.php");
exit;