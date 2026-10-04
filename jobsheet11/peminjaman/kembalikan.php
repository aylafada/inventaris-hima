<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

// Sebelumnya lewat GET (link) sehingga bisa dipicu dari situs lain (CSRF).
// Sekarang wajib POST + token.
require_post();
csrf_verify();

try {
    $id = input_int($_POST['id_peminjaman'] ?? null, 'ID peminjaman', 1);
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
    $stmt->execute([':id' => $id]);
    $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peminjaman) {
        throw new RuntimeException('Data peminjaman tidak ditemukan.');
    }

    if ($peminjaman['status'] === 'Selesai') {
        throw new RuntimeException('Barang sudah dikembalikan.');
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
    abort_with($ex->getMessage(), 409);

} catch (PDOException $e) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    handle_db_error($e);
}

header('Location: ' . BASE_URL . '/peminjaman/list.php');
exit;
