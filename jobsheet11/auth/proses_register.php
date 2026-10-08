<?php

require_once __DIR__ . '/../includes/header.php';

require_post();
csrf_verify();

require_once __DIR__ . '/../includes/koneksi.php';

try {

    $nama     = input_string($_POST['nama'] ?? null, 'Nama', 3, 100);
    $username = input_string($_POST['username'] ?? null, 'Username', 3, 30);
    $password = $_POST['password'] ?? null;

    // Whitelist karakter username
    if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        throw new InputException('Username hanya boleh huruf, angka, dan underscore.');
    }

    // bcrypt hanya memakai 72 byte pertama
    if (!is_string($password) || strlen($password) < 8 || strlen($password) > 72) {
        throw new InputException('Password harus 8-72 karakter.');
    }

} catch (InputException $ex) {
    header('Location: ' . BASE_URL . '/auth/register.php?error=input');
    exit;
}

try {

    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        header('Location: ' . BASE_URL . '/auth/register.php?error=username');
        exit;
    }

    $stmt = $pdo->prepare('
        INSERT INTO users (nama, username, password, role)
        VALUES (?, ?, ?, ?)
    ');

    // Role SELALU 'petugas' dari server, tidak pernah dari input user
    $stmt->execute([
        $nama,
        $username,
        password_hash($password, PASSWORD_DEFAULT),
        'petugas',
    ]);

} catch (PDOException $e) {

    // 23505 = unique violation (username dobel saat race condition)
    if ($e->getCode() === '23505') {
        header('Location: ' . BASE_URL . '/auth/register.php?error=username');
        exit;
    }

    handle_db_error($e);
}

header('Location: ' . BASE_URL . '/auth/login.php?register=success');
exit;
