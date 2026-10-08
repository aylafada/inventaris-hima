<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id_barang   = input_int($_POST['id_barang'] ?? null, 'ID barang', 1);
    $kode_barang = input_string($_POST['kode_barang'] ?? null, 'Kode barang', 1, 20);
    $nama_barang = input_string($_POST['nama_barang'] ?? null, 'Nama barang', 1, 100);
    $id_kategori = input_int($_POST['id_kategori'] ?? null, 'Kategori', 1);
    $jumlah      = input_int($_POST['jumlah'] ?? null, 'Jumlah', 0, 100000);

    if (!preg_match('/^[A-Za-z0-9._-]+$/', $kode_barang)) {
        throw new InputException('Kode barang hanya boleh huruf, angka, titik, minus, underscore.');
    }

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    if (!kategori_exists($pdo, $id_kategori)) {
        abort_with('Kategori tidak valid.', 422);
    }

    $stmt = $pdo->prepare('
        UPDATE barang
        SET kode_barang = :kode_barang,
            nama_barang = :nama_barang,
            id_kategori = :id_kategori,
            jumlah      = :jumlah
        WHERE id_barang = :id_barang
    ');

    $stmt->execute([
        ':kode_barang' => $kode_barang,
        ':nama_barang' => $nama_barang,
        ':id_kategori' => $id_kategori,
        ':jumlah'      => $jumlah,
        ':id_barang'   => $id_barang,
    ]);

} catch (PDOException $e) {
    handle_db_error($e, ['23505' => 'Kode barang sudah digunakan.']);
}

header('Location: ' . BASE_URL . '/barang/list.php');
exit;
