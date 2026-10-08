<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';


/*
|--------------------------------------------------------------------------
| HANYA ADMIN
|--------------------------------------------------------------------------
*/

if ($_SESSION['role'] !== 'admin') {

    http_response_code(403);

    die("Akses ditolak. Hanya admin yang dapat menghapus barang.");
}


/*
|--------------------------------------------------------------------------
| DELETE HARUS POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    die("Method tidak diperbolehkan.");
}


$id_barang = $_POST['id_barang'] ?? null;

if (!$id_barang) {

    header("Location: /jobsheet10/barang/list.php");

    exit;
}


/*
|--------------------------------------------------------------------------
| HAPUS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    DELETE FROM barang
    WHERE id_barang = :id_barang
");

$stmt->execute([
    ':id_barang' => $id_barang
]);


header("Location: /jobsheet10/barang/list.php");

exit;