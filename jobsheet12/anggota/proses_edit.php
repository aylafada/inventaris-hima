<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $id    = input_int($_POST['id_anggota'] ?? null, 'ID anggota', 1);
    $nim   = input_string($_POST['nim'] ?? null, 'NIM', 3, 20);
    $nama  = input_string($_POST['nama'] ?? null, 'Nama', 3, 100);
    $no_hp = trim((string) ($_POST['no_hp'] ?? ''));

    if (!preg_match('/^[A-Za-z0-9._-]+$/', $nim)) {
        throw new InputException('NIM hanya boleh huruf, angka, titik, minus, underscore.');
    }

    if ($no_hp !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $no_hp)) {
        throw new InputException('No. HP tidak valid (8-20 karakter: angka, +, -, spasi).');
    }

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare('
        UPDATE anggota
        SET nim = :nim, nama = :nama, no_hp = :no_hp
        WHERE id_anggota = :id
    ');

    $stmt->execute([
        ':nim'   => $nim,
        ':nama'  => $nama,
        ':no_hp' => $no_hp === '' ? null : $no_hp,
        ':id'    => $id,
    ]);

    if ($stmt->rowCount() === 0) {
        throw new RuntimeException('Data anggota tidak ditemukan.');
    }

    // Jaga konsistensi: salinan nama di peminjaman ikut diperbarui
    $pdo->prepare('UPDATE peminjaman SET nama_peminjam = :nama WHERE id_anggota = :id')
        ->execute([':nama' => $nama, ':id' => $id]);

    $pdo->commit();

} catch (RuntimeException $ex) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    abort_with($ex->getMessage(), 404);

} catch (PDOException $e) {

    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    handle_db_error($e, ['23505' => 'NIM sudah terdaftar.']);
}

header('Location: ' . BASE_URL . '/anggota/list.php');
exit;
