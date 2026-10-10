<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_admin();   // hanya admin
require_post();    // hapus wajib POST
csrf_verify();     // token CSRF wajib valid

try {
    $id = input_int($_POST['id_anggota'] ?? null, 'ID anggota', 1);
} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $stmt = $pdo->prepare('DELETE FROM anggota WHERE id_anggota = :id');
    $stmt->execute([':id' => $id]);

} catch (PDOException $e) {
    // 23503 = foreign key violation: anggota masih punya riwayat peminjaman
    handle_db_error($e, ['23503' => 'Anggota tidak bisa dihapus karena masih memiliki riwayat peminjaman.']);
}

header('Location: ' . BASE_URL . '/anggota/list.php');
exit;
