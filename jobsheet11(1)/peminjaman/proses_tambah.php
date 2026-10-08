<?php

require_once __DIR__ . '/../includes/auth.php';   // sebelumnya TIDAK ada: bisa diakses tanpa login
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id_barang      = input_int($_POST['id_barang'] ?? null, 'Barang', 1);
    $nama_peminjam  = input_string($_POST['nama_peminjam'] ?? null, 'Nama peminjam', 1, 100);
    $tanggal_pinjam = input_date($_POST['tanggal_pinjam'] ?? null, 'Tanggal pinjam');

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $pdo->beginTransaction();

    // FOR UPDATE: kunci baris agar stok tidak bisa dipinjam ganda bersamaan
    $cek = $pdo->prepare('
        SELECT jumlah
        FROM barang
        WHERE id_barang = :id_barang
        FOR UPDATE
    ');
    $cek->execute([':id_barang' => $id_barang]);
    $barang = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$barang || $barang['jumlah'] <= 0) {
        throw new RuntimeException('Stok barang tidak tersedia.');
    }

    $stmt = $pdo->prepare("
        INSERT INTO peminjaman (id_barang, nama_peminjam, tanggal_pinjam, status)
        VALUES (:id_barang, :nama_peminjam, :tanggal_pinjam, 'Dipinjam')
    ");
    $stmt->execute([
        ':id_barang'      => $id_barang,
        ':nama_peminjam'  => $nama_peminjam,
        ':tanggal_pinjam' => $tanggal_pinjam,
    ]);

    $update = $pdo->prepare('
        UPDATE barang SET jumlah = jumlah - 1 WHERE id_barang = :id_barang
    ');
    $update->execute([':id_barang' => $id_barang]);

    $pdo->commit();

} catch (RuntimeException $ex) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    abort_with($ex->getMessage(), 409);

} catch (PDOException $e) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    handle_db_error($e);
}

header('Location: ' . BASE_URL . '/peminjaman/list.php');
exit;
