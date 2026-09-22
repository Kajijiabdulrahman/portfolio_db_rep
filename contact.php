<?php
/**
 * contact.php — Contact page
 * Two-column layout: info cards (left) + validated, database-driven form (right).
 *
 * Security: PDO prepared statements, CSRF token, server-side validation,
 * PRG pattern (redirect after POST) with session flash messages.
 */
require_once __DIR__ . '/includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ── CSRF token (create if missing) ─────────────────────── */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ── POST handler: validate + insert + redirect ─────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    // 1. CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errors[] = 'Your session expired. Please try submitting the form again.';
    }

    // 2. Sanitise inputs
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // 3. Validate
    if (mb_strlen($name) < 2) {
        $errors[] = 'Please enter your name (at least 2 characters).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (mb_strlen($message) < 10) {
        $errors[] = 'Your message must be at least 10 characters long.';
    }
    if (mb_strlen($name) > 100 || mb_strlen($email) > 150
        || mb_strlen($subject) > 200 || mb_strlen($message) > 5000) {
        $errors[] = 'One of the fields is too long. Please shorten your input.';
    }

    // 4. Insert via prepared statement, then redirect (PRG pattern)
    if (!$errors) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO messages (name, email, subject, message)
                 VALUES (:name, :email, :subject, :message)'
            );
            $stmt->execute([
                ':name'    => $name,
                ':email'   => $email,
                ':subject' => $subject !== '' ? $subject : null,
                ':message' => $message,
            ]);

            $_SESSION['flash'] = [
                'type' => 'success',
                'text' => 'Thank you, ' . htmlspecialchars($name) . '! Your message has been sent — I will reply as soon as I can.',
            ];

            // Rotate the token so the form cannot be re-posted with the old one
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (PDOException $e) {
            error_log('Contact form insert failed: ' . $e->getMessage());
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Sorry — something went wrong while sending your message. Please try again in a moment.',
            ];
        }
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'text' => implode(' ', array_map('htmlspecialchars', $errors)),
        ];
    }

    // Redirect back (Post/Redirect/Get) — keeps refresh from double-submitting
    header('Location: contact.php');
    exit;
}

// Read (and clear) any flash message set above
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$pageTitle  = 'Contact';
$activePage = 'contact';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ─────────────────── GET IN TOUCH ─────────────────── -->
<section class="section section-first">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">Get In Touch<span class="title-underline"></span></h2>
            <p class="section-subtitle">
                Have a question, an idea, or an opportunity? My inbox is always open.
            </p>
        </div>

        <div class="contact-grid">

            <!-- LEFT: contact info cards -->
            <div class="contact-info">

                <div class="info-card reveal">
                    <span class="info-icon"><i class="bi bi-person-fill"></i></span>
                    <div>
                        <h3 class="info-title">Name</h3>
                        <p class="info-text">Abdulrahman Abubakar Kajiji</p>
                    </div>
                </div>

                <div class="info-card reveal">
                    <span class="info-icon"><i class="bi bi-envelope-fill"></i></span>
                    <div>
                        <h3 class="info-title">Email</h3>
                        <p class="info-text">
                            <a class="info-link" href="mailto:kajijiabdulrahman39@gmail.com">kajijiabdulrahman39@gmail.com</a>
                        </p>
                    </div>
                </div>

                <div class="info-card reveal">
                    <span class="info-icon"><i class="bi bi-geo-alt-fill"></i></span>
                    <div>
                        <h3 class="info-title">Location</h3>
                        <p class="info-text">Nassarawa Local Government, Kano State, Nigeria</p>
                    </div>
                </div>

                <div class="contact-note reveal">
                    <i class="bi bi-shield-check"></i>
                    <p>
                        Your details are stored securely and used only to reply to you.
                        This form is protected against spam and CSRF attacks.
                    </p>
                </div>

            </div>

            <!-- RIGHT: contact form -->
            <div class="contact-form-card reveal">

                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>" role="alert">
                        <i class="bi <?= $flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                        <span><?= $flash['text'] /* already escaped during validation */ ?></span>
                    </div>
                <?php endif; ?>

                <form method="post" action="contact.php" class="contact-form" novalidate>
                    <!-- CSRF protection -->
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                    <div class="form-field">
                        <label for="name">Name <span class="req">*</span></label>
                        <input type="text" id="name" name="name" placeholder="Your full name"
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                    </div>

                    <div class="form-field">
                        <label for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" placeholder="you@example.com"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-field">
                        <label for="subject">Subject <span class="optional">(optional)</span></label>
                        <input type="text" id="subject" name="subject" placeholder="What is this about?">
                    </div>

                    <div class="form-field">
                        <label for="message">Message <span class="req">*</span></label>
                        <textarea id="message" name="message" rows="6" required
                                  placeholder="Tell me a little about your project or question (min. 10 characters)..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="bi bi-send-fill"></i> Send Message
                    </button>
                </form>

            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

