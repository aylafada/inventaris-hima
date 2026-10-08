<?php

session_start();

require_once __DIR__ . '/../includes/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE username = ?
");

$stmt->execute([$username]);

$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    header('Location: /jobsheet10/index.php');
    exit;

}

header('Location: /jobsheet10/auth/login.php?error=1');
exit;