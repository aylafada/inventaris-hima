<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

require_post();
csrf_verify();

try {

    $nim   = input_string($_POST['nim'] ?? null, 'NIM', 3, 20);
    $nama  = input_string($_POST['nama'] ?? null, 'Nama', 3, 100);
    $no_hp = trim((string) ($_POST['no_hp'] ?? ''));

    if (!preg_match('/^[A-Za-z0-9._-]+$/', $nim)) {
        throw new InputException('NIM hanya boleh huruf, angka, titik, minus, underscore.');
    }

    // No. HP opsional; jika diisi harus berupa nomor
    if ($no_hp !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $no_hp)) {
        throw new InputException('No. HP tidak valid (8-20 karakter: angka, +, -, spasi).');
    }

} catch (InputException $ex) {
    abort_with($ex->getMessage(), 422);
}

try {

    $stmt = $pdo->prepare('
        INSERT INTO anggota (nim, nama, no_hp)
        VALUES (:nim, :nama, :no_hp)
    ');

    $stmt->execute([
        ':nim'   => $nim,
        ':nama'  => $nama,
        ':no_hp' => $no_hp === '' ? null : $no_hp,
    ]);

} catch (PDOException $e) {
    handle_db_error($e, ['23505' => 'NIM sudah terdaftar.']);
}

header('Location: ' . BASE_URL . '/anggota/list.php');
exit;
