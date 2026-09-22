<?php
/**
 * /includes/header.php
 * Shared <head> + sticky navbar. Include on every public page:
 *   require_once __DIR__ . '/includes/header.php';
 *
 * Optional per-page values you may set BEFORE including:
 *   $pageTitle       — text for <title>
 *   $activePage      — 'home' | 'about' | 'contact' (highlights nav link)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio of Abdulrahman Abubakar Kajiji — aspiring tech enthusiast and developer based in Kano State, Nigeria.">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | Abdulrahman Kajiji' : 'Abdulrahman Kajiji — Portfolio' ?></title>

    <!-- Google Fonts: Inter (body) + Space Grotesk (headings) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Shared stylesheet + theme bootstrap (runs before paint to avoid flash) -->
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <script>try{var t=localStorage.getItem('ak-theme');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}</script>
</head>
<body>

<!-- ───────────────────────── NAVBAR ───────────────────────── -->
<nav class="navbar">
    <div class="navbar-inner">

        <!-- Logo (left) -->
        <a href="index.php" class="brand" aria-label="Abdulrahman Kajiji — Home">
            <span class="brand-badge">AK</span>
            <span class="brand-name">Abdulrahman<span class="brand-dot">.</span></span>
        </a>

        <!-- Nav cluster (right): links + theme toggle + hamburger -->
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="navMenu">
            <i class="bi bi-list nav-toggle-icon nav-icon-open"></i>
            <i class="bi bi-x nav-toggle-icon nav-icon-close"></i>
        </button>

        <div class="nav-cluster" id="navMenu">
            <ul class="nav-links">
                <li>
                    <a href="index.php" class="nav-link<?= (isset($activePage) && $activePage === 'home') ? ' active' : '' ?>">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li>
                    <a href="about.php" class="nav-link<?= (isset($activePage) && $activePage === 'about') ? ' active' : '' ?>">
                        <i class="bi bi-person-badge"></i> About
                    </a>
                </li>
                <li>
                    <a href="contact.php" class="nav-link<?= (isset($activePage) && $activePage === 'contact') ? ' active' : '' ?>">
                        <i class="bi bi-envelope-paper"></i> Contact
                    </a>
                </li>
            </ul>

            <!-- Dark / light theme toggle -->
            <button class="theme-toggle" id="themeToggle" aria-label="Switch color theme">
                <i class="bi bi-moon-stars theme-icon-moon"></i>
                <i class="bi bi-sun theme-icon-sun"></i>
            </button>
        </div>

    </div>
</nav>
