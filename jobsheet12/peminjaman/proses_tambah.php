<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id_anggota     = input_int($_POST['id_anggota'] ?? null, 'Anggota', 1);
    $id_barang      = input_int($_POST['id_barang'] ?? null, 'Barang', 1);
    $tanggal_pinjam = input_date($_POST['tanggal_pinjam'] ?? null, 'Tanggal pinjam');

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    // Satu transaksi: insert peminjaman + kurangi stok. Gagal di mana pun = batal semua.
    $pdo->beginTransaction();

    // 1. Anggota harus ada (FOR SHARE: tidak bisa dihapus selama transaksi berjalan)
    $stmt = $pdo->prepare('
        SELECT id_anggota, nama
        FROM anggota
        WHERE id_anggota = :id
        FOR SHARE
    ');
    $stmt->execute([':id' => $id_anggota]);
    $anggota = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$anggota) {
        throw new RuntimeException('Anggota tidak ditemukan.', 422);
    }

    // 2. Validasi bisnis: tanggal tidak boleh di masa depan
    $stmt = $pdo->prepare('SELECT CAST(:tgl AS DATE) > CURRENT_DATE');
    $stmt->execute([':tgl' => $tanggal_pinjam]);

    if ($stmt->fetchColumn()) {
        throw new RuntimeException('Tanggal pinjam tidak boleh melebihi hari ini.', 422);
    }

    // 3. Validasi bisnis (tugas mandiri): anggota dengan peminjaman terlambat tidak boleh meminjam
    $stmt = $pdo->prepare('
        SELECT COUNT(*)
        FROM peminjaman p
        WHERE p.id_anggota = :id
          AND ' . sql_terlambat('p')
    );
    $stmt->execute([':id' => $id_anggota]);
    $jumlahTerlambat = (int) $stmt->fetchColumn();

    if ($jumlahTerlambat > 0) {
        throw new RuntimeException(
            'Peminjaman ditolak: ' . $anggota['nama'] . ' masih memiliki ' . $jumlahTerlambat .
            ' peminjaman yang terlambat (lebih dari ' . BATAS_HARI_PINJAM .
            ' hari belum dikembalikan). Kembalikan barang tersebut terlebih dahulu.',
            409
        );
    }

    // 4. Kunci baris barang lalu cek stok (FOR UPDATE: cegah stok minus / dobel)
    $stmt = $pdo->prepare('
        SELECT jumlah
        FROM barang
        WHERE id_barang = :id
        FOR UPDATE
    ');
    $stmt->execute([':id' => $id_barang]);
    $barang = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$barang) {
        throw new RuntimeException('Barang tidak ditemukan.', 422);
    }

    if ((int) $barang['jumlah'] <= 0) {
        throw new RuntimeException('Stok barang tidak tersedia.', 409);
    }

    // 5. Simpan peminjaman (nama_peminjam disalin dari anggota agar halaman Jobsheet 10/11 tetap bisa membaca)
    $stmt = $pdo->prepare("
        INSERT INTO peminjaman
            (id_barang, id_anggota, nama_peminjam, tanggal_pinjam, status)
        VALUES
            (:id_barang, :id_anggota, :nama, :tanggal_pinjam, 'Dipinjam')
    ");
    $stmt->execute([
        ':id_barang'      => $id_barang,
        ':id_anggota'     => $id_anggota,
        ':nama'           => $anggota['nama'],
        ':tanggal_pinjam' => $tanggal_pinjam,
    ]);

    // 6. Kurangi stok; syarat jumlah > 0 sebagai pengaman kedua
    $stmt = $pdo->prepare('
        UPDATE barang
        SET jumlah = jumlah - 1
        WHERE id_barang = :id AND jumlah > 0
    ');
    $stmt->execute([':id' => $id_barang]);

    if ($stmt->rowCount() !== 1) {
        throw new RuntimeException('Stok barang tidak tersedia.', 409);
    }

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
