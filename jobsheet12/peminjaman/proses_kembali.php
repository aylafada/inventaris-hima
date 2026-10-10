<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

// proses_kembali.php: mengubah data -> wajib POST + token CSRF (bukan link GET)
require_post();
csrf_verify();

try {
    $id = input_int($_POST['id_peminjaman'] ?? null, 'ID peminjaman', 1);
} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

// Halaman tujuan setelah berhasil: whitelist (bukan URL dari input -> anti open redirect)
$tujuan = [
    'kembali' => '/peminjaman/kembali.php',
    'list'    => '/peminjaman/list.php',
];
$dari   = $_POST['dari'] ?? 'kembali';
$dari   = (is_string($dari) && isset($tujuan[$dari])) ? $dari : 'kembali';

try {

    // Satu transaksi: ubah status + tambah kembali stok
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('
        SELECT id_barang, status
        FROM peminjaman
        WHERE id_peminjaman = :id
        FOR UPDATE
    ');
    $stmt->execute([':id' => $id]);
    $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peminjaman) {
        throw new RuntimeException('Data peminjaman tidak ditemukan.', 404);
    }

    // Cegah stok bertambah dobel jika diklik dua kali
    if ($peminjaman['status'] === 'Selesai') {
        throw new RuntimeException('Barang ini sudah dikembalikan sebelumnya.', 409);
    }

    $pdo->prepare("
        UPDATE peminjaman
        SET tanggal_kembali = CURRENT_DATE, status = 'Selesai'
        WHERE id_peminjaman = :id
    ")->execute([':id' => $id]);

    $pdo->prepare('UPDATE barang SET jumlah = jumlah + 1 WHERE id_barang = :id_barang')
        ->execute([':id_barang' => $peminjaman['id_barang']]);

    $pdo->commit();

} catch (RuntimeException $ex) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    abort_with($ex->getMessage(), $ex->getCode() ?: 409);

} catch (PDOException $e) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    handle_db_error($e);
}

header('Location: ' . BASE_URL . $tujuan[$dari]);
exit;
