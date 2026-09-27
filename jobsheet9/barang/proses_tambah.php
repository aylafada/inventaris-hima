<?php

require_once __DIR__ . '/../includes/koneksi.php';

$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$id_kategori = $_POST['id_kategori'];
$jumlah = $_POST['jumlah'];

$sql = "
    INSERT INTO barang
    (
        kode_barang,
        nama_barang,
        id_kategori,
        jumlah
    )
    VALUES
    (
        :kode_barang,
        :nama_barang,
        :id_kategori,
        :jumlah
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':kode_barang' => $kode_barang,
    ':nama_barang' => $nama_barang,
    ':id_kategori' => $id_kategori,
    ':jumlah' => $jumlah
]);

header("Location: /barang/list.php");
exit;