<?php

require_once __DIR__ . '/inventaris-hima/includes/auth.php';
require_once __DIR__ . '/inventaris-hima/includes/koneksi.php';


if ($_SESSION['role'] !== 'admin') {

    http_response_code(403);

    die("Akses ditolak. Hanya admin yang dapat menghapus peminjaman.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Method tidak diperbolehkan.");
}

$id_peminjaman = $_POST['id_peminjaman'] ?? null;

if (!$id_peminjaman) {
    header("Location: /peminjaman/list.php");
    exit;
}

try {

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT
            id_barang,
            status
        FROM peminjaman
        WHERE id_peminjaman = :id
        FOR UPDATE
    ");

    $stmt->execute([
        ':id' => $id_peminjaman
    ]);

    $peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$peminjaman) {
        throw new Exception("Data peminjaman tidak ditemukan.");
    }


    /*
    |--------------------------------------------------------------------------
    | JIKA MASIH DIPINJAM, KEMBALIKAN STOK
    |--------------------------------------------------------------------------
    */

    if ($peminjaman['status'] === 'Dipinjam') {

        $updateBarang = $pdo->prepare("
            UPDATE barang
            SET jumlah = jumlah + 1
            WHERE id_barang = :id_barang
        ");

        $updateBarang->execute([
            ':id_barang' => $peminjaman['id_barang']
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    $delete = $pdo->prepare("
        DELETE FROM peminjaman
        WHERE id_peminjaman = :id
    ");

    $delete->execute([
        ':id' => $id_peminjaman
    ]);


    $pdo->commit();

    header("Location: /peminjaman/list.php");
    exit;


} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Penghapusan gagal: " . $e->getMessage());
}