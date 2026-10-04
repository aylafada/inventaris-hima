<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$nama = $_POST['nama'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($nama === '' || $username === '' || $password === '') {
    header('Location: /jobsheet11/auth/register.php');
    exit;
}

/*
| Cek username
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM users
    WHERE username = ?
");

$stmt->execute([$username]);

if ($stmt->fetch()) {
    header('Location: /jobsheet11/auth/register.php?error=username');
    exit;
}


/*
| Hash password
*/

$passwordHash = password_hash($password, PASSWORD_DEFAULT);


/*
| Simpan user
*/

$stmt = $pdo->prepare("
    INSERT INTO users (nama, username, password, role)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $nama,
    $username,
    $passwordHash,
    'petugas'
]);


/*
| Redirect ke login
*/

header('Location: /jobsheet11/auth/login.php?register=success');
exit;