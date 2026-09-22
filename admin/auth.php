<?php
/**
 * /admin/auth.php — session guard
 * Include at the very top of every protected admin page.
 * If no admin session exists, bounce the visitor to the login page.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_id'])) {
    // Remember nothing about the visitor — just send them to log in.
    header('Location: login.php');
    exit;
}
