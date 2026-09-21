<?php

require_once "../includes/koneksi.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("
        DELETE FROM peminjaman
        WHERE id_peminjaman = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);
}

header("Location: /peminjaman/list.php");
exit;