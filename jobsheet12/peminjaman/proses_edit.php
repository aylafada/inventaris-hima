<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id_peminjaman  = input_int($_POST['id_peminjaman'] ?? null, 'ID peminjaman', 1);
    $id_anggota     = input_int($_POST['id_anggota'] ?? null, 'Anggota', 1);
    $id_barang_baru = input_int($_POST['id_barang'] ?? null, 'Barang', 1);
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
        throw new RuntimeException('Data peminjaman tidak ditemukan.', 404);
    }

    $anggota = find_anggota($pdo, $id_anggota);

    if (!$anggota) {
        throw new RuntimeException('Anggota tidak ditemukan.', 422);
    }

    $stmt = $pdo->prepare('SELECT CAST(:tgl AS DATE) > CURRENT_DATE');
    $stmt->execute([':tgl' => $tanggal_pinjam]);

    if ($stmt->fetchColumn()) {
        throw new RuntimeException('Tanggal pinjam tidak boleh melebihi hari ini.', 422);
    }

    $id_barang_lama = (int) $peminjaman['id_barang'];

    // Ganti barang pada peminjaman AKTIF: pindahkan stok (lama +1, baru -1)
    if ($id_barang_lama !== $id_barang_baru && $peminjaman['status'] === 'Dipinjam') {

        $cek = $pdo->prepare('SELECT jumlah FROM barang WHERE id_barang = :id FOR UPDATE');
        $cek->execute([':id' => $id_barang_baru]);
        $barangBaru = $cek->fetch(PDO::FETCH_ASSOC);

        if (!$barangBaru) {
            throw new RuntimeException('Barang baru tidak ditemukan.', 422);
        }

        if ((int) $barangBaru['jumlah'] <= 0) {
            throw new RuntimeException('Stok barang baru tidak tersedia.', 409);
        }

        $pdo->prepare('UPDATE barang SET jumlah = jumlah + 1 WHERE id_barang = :id')
            ->execute([':id' => $id_barang_lama]);

        $pdo->prepare('UPDATE barang SET jumlah = jumlah - 1 WHERE id_barang = :id')
            ->execute([':id' => $id_barang_baru]);
    }

    $pdo->prepare('
        UPDATE peminjaman
        SET id_barang      = :id_barang,
            id_anggota     = :id_anggota,
            nama_peminjam  = :nama,
            tanggal_pinjam = :tanggal_pinjam
        WHERE id_peminjaman = :id
    ')->execute([
        ':id_barang'      => $id_barang_baru,
        ':id_anggota'     => $id_anggota,
        ':nama'           => $anggota['nama'],
        ':tanggal_pinjam' => $tanggal_pinjam,
        ':id'             => $id_peminjaman,
    ]);

    $pdo->commit();

} catch (RuntimeException $ex) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    abort_with($ex->getMessage(), $ex->getCode() ?: 409);

} catch (PDOException $e) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    handle_db_error($e);
}

header('Location: ' . BASE_URL . '/peminjaman/list.php');
exit;
