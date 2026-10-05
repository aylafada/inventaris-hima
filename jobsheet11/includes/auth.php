<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) && !isset($_SESSION['user_id'])) {
    // Gunakan pengecekan BASE_URL jika ada, atau redirect relatif
    $redirectUrl = defined('BASE_URL') ? BASE_URL . '/auth/login.php' : '../auth/login.php';
    header('Location: ' . $redirectUrl);
    exit;
}
?>