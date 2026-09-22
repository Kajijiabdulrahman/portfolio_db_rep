<?php
/**
 * /admin/logout.php — destroy the admin session and return to login.
 */
session_start();
session_unset();
session_destroy();

header('Location: login.php');
exit;
