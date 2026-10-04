<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /jobsheet11/auth/login.php');
    exit;
}