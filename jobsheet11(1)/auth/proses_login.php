<?php

require_once __DIR__ . '/../includes/header.php';

require_post();
csrf_verify();

require_once __DIR__ . '/../includes/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi tipe & panjang (cegah input array / string raksasa)
if (
    !is_string($username) || !is_string($password) ||
    $username === '' || $password === '' ||
    text_len($username) > 50 || strlen($password) > 72
) {
    header('Location: ' . BASE_URL . '/auth/login.php?error=1');
    exit;
}

try {

    // Prepared statement: input TIDAK PERNAH digabung ke string SQL
    $stmt = $pdo->prepare('
        SELECT id, nama, username, password, role
        FROM users
        WHERE username = ?
    ');

    $stmt->execute([$username]);

    $user = $stmt->fetch();

} catch (PDOException $e) {
    handle_db_error($e);
}

if (
    $user &&
    password_verify($password, $user['password']) &&
    in_array($user['role'], ROLE_VALID, true)
) {

    // Cegah session fixation: ID session baru setelah login berhasil
    session_regenerate_id(true);

    $_SESSION['user_id']  = (int) $user['id'];
    $_SESSION['nama']     = $user['nama'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    // Token CSRF baru untuk session baru
    unset($_SESSION['csrf_token']);
    csrf_token();

    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

header('Location: ' . BASE_URL . '/auth/login.php?error=1');
exit;
