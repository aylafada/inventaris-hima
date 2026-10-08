<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_admin();   // hanya admin
require_post();    // hapus wajib POST
csrf_verify();     // token CSRF wajib valid

try {
    $id_barang = input_int($_POST['id_barang'] ?? null, 'ID barang', 1);
} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $stmt = $pdo->prepare('DELETE FROM barang WHERE id_barang = :id_barang');
    $stmt->execute([':id_barang' => $id_barang]);

} catch (PDOException $e) {
    // 23503 = foreign key violation (barang masih dipakai di peminjaman)
    handle_db_error($e, ['23503' => 'Barang tidak bisa dihapus karena masih ada data peminjaman terkait.']);
}

header('Location: ' . BASE_URL . '/barang/list.php');
exit;
