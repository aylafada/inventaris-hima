<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id_peminjaman = $_POST['id_peminjaman'] ?? null;
$id_barang_baru = $_POST['id_barang'] ?? null;
$nama_peminjam = trim($_POST['nama_peminjam'] ?? '');
$tanggal_pinjam = $_POST['tanggal_pinjam'] ?? null;

if (
    !$id_peminjaman ||
    !$id_barang_baru ||
    $nama_peminjam === '' ||
    !$tanggal_pinjam
) {
    die("Data peminjaman tidak lengkap.");
}

try {

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA PEMINJAMAN LAMA
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


    $id_barang_lama = $peminjaman['id_barang'];
    $status = $peminjaman['status'];


    /*
    |--------------------------------------------------------------------------
    | JIKA BARANG DIGANTI
    |--------------------------------------------------------------------------
    */

    if ($id_barang_lama != $id_barang_baru) {

        /*
        |--------------------------------------------------------------------------
        | HANYA PEMINJAMAN AKTIF YANG MENGUBAH STOK
        |--------------------------------------------------------------------------
        */

        if ($status === 'Dipinjam') {

            /*
            | Kembalikan stok barang lama
            */

            $updateLama = $pdo->prepare("
                UPDATE barang
                SET jumlah = jumlah + 1
                WHERE id_barang = :id_barang
            ");

            $updateLama->execute([
                ':id_barang' => $id_barang_lama
            ]);


            /*
            | Cek stok barang baru
            */

            $cekBaru = $pdo->prepare("
                SELECT jumlah
                FROM barang
                WHERE id_barang = :id_barang
                FOR UPDATE
            ");

            $cekBaru->execute([
                ':id_barang' => $id_barang_baru
            ]);

            $barangBaru = $cekBaru->fetch(PDO::FETCH_ASSOC);

            if (!$barangBaru) {
                throw new Exception("Barang baru tidak ditemukan.");
            }

            if ($barangBaru['jumlah'] <= 0) {
                throw new Exception("Stok barang baru tidak tersedia.");
            }


            /*
            | Kurangi stok barang baru
            */

            $updateBaru = $pdo->prepare("
                UPDATE barang
                SET jumlah = jumlah - 1
                WHERE id_barang = :id_barang
            ");

            $updateBaru->execute([
                ':id_barang' => $id_barang_baru
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    $update = $pdo->prepare("
        UPDATE peminjaman
        SET
            id_barang = :id_barang,
            nama_peminjam = :nama_peminjam,
            tanggal_pinjam = :tanggal_pinjam
        WHERE id_peminjaman = :id_peminjaman
    ");

    $update->execute([
        ':id_barang' => $id_barang_baru,
        ':nama_peminjam' => $nama_peminjam,
        ':tanggal_pinjam' => $tanggal_pinjam,
        ':id_peminjaman' => $id_peminjaman
    ]);


    $pdo->commit();

    header("Location:/jobsheet10/peminjaman/list.php");
    exit;


} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Proses edit peminjaman gagal: " . $e->getMessage());
}