<?php

require_once __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $username === '' ||
    $password === ''
) {
    die("Username dan password wajib diisi.");
}


/*
|--------------------------------------------------------------------------
| CARI USER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id,
        nama,
        username,
        password,
        role
    FROM users
    WHERE username = :username
");

$stmt->execute([
    ':username' => $username
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| VERIFIKASI PASSWORD
|--------------------------------------------------------------------------
*/

if (
    !$user ||
    !password_verify($password, $user['password'])
) {
    die("Username atau password salah.");
}


/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

session_start();

session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];


/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: /");
exit;