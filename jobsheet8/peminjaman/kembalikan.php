<?php

require_once __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /peminjaman/list.php");
    exit;
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        SELECT id_barang, status
        FROM peminjaman
        WHERE id_peminjaman = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peminjaman) {
        throw new Exception("Data peminjaman tidak ditemukan.");
    }

    if ($peminjaman['status'] === 'Selesai') {
        throw new Exception("Barang sudah dikembalikan.");
    }

    $updatePeminjaman = $pdo->prepare("
        UPDATE peminjaman
        SET
            tanggal_kembali = CURRENT_DATE,
            status = 'Selesai'
        WHERE id_peminjaman = :id
    ");

    $updatePeminjaman->execute([
        ':id' => $id
    ]);

    $updateBarang = $pdo->prepare("
        UPDATE barang
        SET jumlah = jumlah + 1
        WHERE id_barang = :id_barang
    ");

    $updateBarang->execute([
        ':id_barang' => $peminjaman['id_barang']
    ]);

    $pdo->commit();

    header("Location: /peminjaman/list.php");
    exit;

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Proses pengembalian gagal: " . $e->getMessage());
}