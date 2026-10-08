<?php

require_once __DIR__ . '/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

// Whitelist role: role di session yang tidak dikenal -> paksa login ulang
if (!in_array($_SESSION['role'] ?? '', ROLE_VALID, true)) {
    $_SESSION = [];
    session_destroy();
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}
