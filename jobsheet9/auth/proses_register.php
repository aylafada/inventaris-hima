<?php

require_once __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $nama === '' ||
    $username === '' ||
    $password === ''
) {
    die("Semua data wajib diisi.");
}


/*
|--------------------------------------------------------------------------
| CEK USERNAME
|--------------------------------------------------------------------------
*/

$cek = $pdo->prepare("
    SELECT id
    FROM users
    WHERE username = :username
");

$cek->execute([
    ':username' => $username
]);

if ($cek->fetch()) {
    die("Username sudah digunakan.");
}


/*
|--------------------------------------------------------------------------
| HASH PASSWORD
|--------------------------------------------------------------------------
*/

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| SIMPAN USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    INSERT INTO users
    (
        nama,
        username,
        password,
        role
    )
    VALUES
    (
        :nama,
        :username,
        :password,
        'petugas'
    )
");

$stmt->execute([
    ':nama' => $nama,
    ':username' => $username,
    ':password' => $passwordHash
]);


header("Location: /auth/login.php");
exit;