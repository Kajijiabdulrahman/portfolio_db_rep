<?php
/**
 * /admin/login.php — admin login form
 *
 * Security: CSRF token, password_verify() against the admins table,
 * session_regenerate_id(true) on success.
 *
 * NOTE (rate limiting): for production, add a simple throttle here — e.g.
 * store $_SESSION['login_attempts'] = ['count' => n, 'first' => timestamp]
 * and sleep(1) + reject after 5 failed tries per 10 minutes, or use a
 * database-backed limiter keyed on username + IP before the query below.
 */
session_start();
require_once __DIR__ . '/../includes/db.php';

// Already logged in? Straight to the dashboard.
if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Create a CSRF token if one does not exist yet
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Verify CSRF token (timing-safe comparison)
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Your session expired. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // 2. Look the admin up with a prepared statement
        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);
        $admin = $stmt->fetch();

        // 3. Verify the password hash
        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Success — prevent session fixation, then stamp the session
            session_regenerate_id(true);
            $_SESSION['admin_id']       = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header('Location: dashboard.php');
            exit;
        }

        // Generic message: never reveal whether the username or password was wrong
        $error = 'Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Abdulrahman Kajiji</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../style.css">
    <script>try{var t=localStorage.getItem('ak-theme');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}</script>
</head>
<body class="admin-body">

    <main class="login-wrap">
        <div class="login-card reveal is-visible">

            <!-- Gradient header -->
            <div class="login-header">
                <span class="login-shield"><i class="bi bi-shield-lock"></i></span>
                <h1>Admin Login</h1>
                <p>Abdulrahman's Portfolio — Dashboard Access</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="login.php" class="login-form">
                <!-- CSRF protection -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <div class="form-field">
                    <label for="username"><i class="bi bi-person"></i> Username</label>
                    <input type="text" id="username" name="username" autocomplete="username" required autofocus>
                </div>

                <div class="form-field">
                    <label for="password"><i class="bi bi-key"></i> Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>

            <a href="../index.php" class="login-back">
                <i class="bi bi-arrow-left"></i> Back to portfolio
            </a>
        </div>
    </main>

</body>
</html>
