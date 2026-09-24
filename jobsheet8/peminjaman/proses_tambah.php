<?php

require_once __DIR__ . '/../includes/koneksi.php';

$id_barang = $_POST['id_barang'];
$nama_peminjam = $_POST['nama_peminjam'];
$tanggal_pinjam = $_POST['tanggal_pinjam'];

try {

    $pdo->beginTransaction();

    $cek = $pdo->prepare("
        SELECT jumlah
        FROM barang
        WHERE id_barang = :id_barang
    ");

    $cek->execute([
        ':id_barang' => $id_barang
    ]);

    $barang = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$barang || $barang['jumlah'] <= 0) {
        throw new Exception("Stok barang tidak tersedia.");
    }

    $sql = "
        INSERT INTO peminjaman
        (
            id_barang,
            nama_peminjam,
            tanggal_pinjam,
            status
        )
        VALUES
        (
            :id_barang,
            :nama_peminjam,
            :tanggal_pinjam,
            'Dipinjam'
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id_barang' => $id_barang,
        ':nama_peminjam' => $nama_peminjam,
        ':tanggal_pinjam' => $tanggal_pinjam
    ]);

    $update = $pdo->prepare("
        UPDATE barang
        SET jumlah = jumlah - 1
        WHERE id_barang = :id_barang
    ");

    $update->execute([
        ':id_barang' => $id_barang
    ]);

    $pdo->commit();

    header("Location: /peminjaman/list.php");
    exit;

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Peminjaman gagal: " . $e->getMessage());
}