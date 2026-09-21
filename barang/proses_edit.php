<?php

require_once "../includes/koneksi.php";

$id_barang = $_POST['id_barang'];
$kode_barang = $_POST['kode_barang'];
$nama_barang = $_POST['nama_barang'];
$id_kategori = $_POST['id_kategori'];
$jumlah = $_POST['jumlah'];

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