<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id_peminjaman  = input_int($_POST['id_peminjaman'] ?? null, 'ID peminjaman', 1);
    $id_barang_baru = input_int($_POST['id_barang'] ?? null, 'Barang', 1);
    $nama_peminjam  = input_string($_POST['nama_peminjam'] ?? null, 'Nama peminjam', 1, 100);
    $tanggal_pinjam = input_date($_POST['tanggal_pinjam'] ?? null, 'Tanggal pinjam');

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare('
        SELECT id_barang, status
        FROM peminjaman
        WHERE id_peminjaman = :id
        FOR UPDATE
    ');
    $stmt->execute([':id' => $id_peminjaman]);
    $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peminjaman) {
        throw new RuntimeException('Data peminjaman tidak ditemukan.');
    }

    $id_barang_lama = (int) $peminjaman['id_barang'];

    // Hanya peminjaman aktif yang memengaruhi stok
    if ($id_barang_lama !== $id_barang_baru && $peminjaman['status'] === 'Dipinjam') {

        $cekBaru = $pdo->prepare('
            SELECT jumlah FROM barang WHERE id_barang = :id_barang FOR UPDATE
        ');
        $cekBaru->execute([':id_barang' => $id_barang_baru]);
        $barangBaru = $cekBaru->fetch(PDO::FETCH_ASSOC);

        if (!$barangBaru) {
            throw new RuntimeException('Barang baru tidak ditemukan.');
        }

        if ($barangBaru['jumlah'] <= 0) {
            throw new RuntimeException('Stok barang baru tidak tersedia.');
        }

        $pdo->prepare('UPDATE barang SET jumlah = jumlah + 1 WHERE id_barang = :id')
            ->execute([':id' => $id_barang_lama]);

        $pdo->prepare('UPDATE barang SET jumlah = jumlah - 1 WHERE id_barang = :id')
            ->execute([':id' => $id_barang_baru]);
    }

    $update = $pdo->prepare('
        UPDATE peminjaman
        SET id_barang      = :id_barang,
            nama_peminjam  = :nama_peminjam,
            tanggal_pinjam = :tanggal_pinjam
        WHERE id_peminjaman = :id_peminjaman
    ');
    $update->execute([
        ':id_barang'      => $id_barang_baru,
        ':nama_peminjam'  => $nama_peminjam,
        ':tanggal_pinjam' => $tanggal_pinjam,
        ':id_peminjaman'  => $id_peminjaman,
    ]);

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
