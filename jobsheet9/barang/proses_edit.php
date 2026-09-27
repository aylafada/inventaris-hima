<?php

require_once __DIR__ . '/../includes/koneksi.php';

$id_barang = $_POST['id_barang'] ?? null;
$kode_barang = trim($_POST['kode_barang'] ?? '');
$nama_barang = trim($_POST['nama_barang'] ?? '');
$id_kategori = $_POST['id_kategori'] ?? null;
$jumlah = $_POST['jumlah'] ?? null;

if (
    !$id_barang ||
    $kode_barang === '' ||
    $nama_barang === '' ||
    !$id_kategori ||
    $jumlah === null
) {
    die("Data barang tidak lengkap.");
}

$sql = "
    UPDATE barang
    SET
        kode_barang = :kode_barang,
        nama_barang = :nama_barang,
        id_kategori = :id_kategori,
        jumlah = :jumlah
    WHERE id_barang = :id_barang
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':kode_barang' => $kode_barang,
    ':nama_barang' => $nama_barang,
    ':id_kategori' => $id_kategori,
    ':jumlah' => $jumlah,
    ':id_barang' => $id_barang
]);

header("Location: /barang/list.php");
exit;