<?php
/**
 * /admin/dashboard.php — view and manage contact messages.
 * Protected by auth.php. Actions (mark read / delete) are POST + CSRF.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

// Create a CSRF token for the action forms if missing
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ── Action handler: mark as read / delete ───────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {

    // CSRF check for every admin action
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {

        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if ($id && $id > 0) {
            if ($_POST['action'] === 'mark_read') {
                $stmt = $pdo->prepare('UPDATE messages SET is_read = TRUE WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $_SESSION['flash'] = ['type' => 'success', 'text' => 'Message #' . $id . ' marked as read.'];
            } elseif ($_POST['action'] === 'delete') {
                $stmt = $pdo->prepare('DELETE FROM messages WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $_SESSION['flash'] = ['type' => 'success', 'text' => 'Message #' . $id . ' deleted.'];
            }
        }
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'text' => 'Security token expired — please try again.'];
    }

    // PRG pattern so refresh cannot replay the action
    header('Location: dashboard.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

/* ── Stats + messages ────────────────────────────────────── */
$totalMessages   = (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$unreadMessages  = (int) $pdo->query('SELECT COUNT(*) FROM messages WHERE is_read = FALSE')->fetchColumn();
$totalProjects   = (int) $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();

$messages = $pdo->query(
    'SELECT id, name, email, subject, message, created_at, is_read
       FROM messages
   ORDER BY created_at DESC, id DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Dashboard | Abdulrahman Kajiji</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../style.css">
    <script>try{var t=localStorage.getItem('ak-theme');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}</script>
    <script src="../script.js" defer></script>
</head>
<body class="admin-body">

    <!-- ── Gradient dashboard header ── -->
    <header class="dash-header">
        <div class="container dash-header-inner">
            <div>
                <h1 class="dash-title"><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
                <p class="dash-welcome">
                    Welcome back, <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong>
                </p>
            </div>
            <div class="dash-actions">
                <a href="../index.php" class="btn btn-ghost btn-sm">
                    <i class="bi bi-globe2"></i> View Site
                </a>
                <a href="logout.php" class="btn btn-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <main class="dash-main container">

        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'error' ?>" role="alert">
                <i class="bi <?= $flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                <span><?= htmlspecialchars($flash['text']) ?></span>
            </div>
        <?php endif; ?>

        <!-- ── Stat cards ── -->
        <div class="dash-stats">

            <div class="stat-card reveal">
                <span class="stat-card-icon"><i class="bi bi-envelope-fill"></i></span>
                <div>
                    <span class="stat-card-number gradient-text"><?= $totalMessages ?></span>
                    <span class="stat-card-label">Total Messages</span>
                </div>
            </div>

            <div class="stat-card reveal">
                <span class="stat-card-icon"><i class="bi bi-envelope-exclamation-fill"></i></span>
                <div>
                    <span class="stat-card-number gradient-text"><?= $unreadMessages ?></span>
                    <span class="stat-card-label">Unread Messages</span>
                </div>
            </div>

            <div class="stat-card reveal">
                <span class="stat-card-icon"><i class="bi bi-kanban-fill"></i></span>
                <div>
                    <span class="stat-card-number gradient-text"><?= $totalProjects ?></span>
                    <span class="stat-card-label">Total Projects</span>
                </div>
            </div>

        </div>

        <!-- ── Messages section ── -->
        <section class="dash-panel reveal">
            <h2 class="dash-panel-title"><i class="bi bi-inbox"></i> Contact Messages</h2>

            <?php if (!$messages): ?>

                <!-- Empty state -->
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No messages yet. When someone contacts you through the portfolio form, it will appear here.</p>
                </div>

            <?php else: ?>

                <div class="table-wrap">
                    <table class="messages-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $m): ?>
                                <tr class="<?= $m['is_read'] ? 'row-read' : 'row-new' ?>">
                                    <td><?= (int) $m['id'] ?></td>
                                    <td class="cell-name"><?= htmlspecialchars($m['name']) ?></td>
                                    <td>
                                        <a class="table-mail" href="mailto:<?= htmlspecialchars($m['email']) ?>">
                                            <?= htmlspecialchars($m['email']) ?>
                                        </a>
                                    </td>
                                    <td class="cell-subject"><?= htmlspecialchars($m['subject'] ?: '—') ?></td>
                                    <td class="cell-message" title="<?= htmlspecialchars($m['message']) ?>">
                                        <?= htmlspecialchars(mb_strlen($m['message']) > 80 ? mb_substr($m['message'], 0, 80) . '…' : $m['message']) ?>
                                    </td>
                                    <td class="cell-date"><?= date('d M Y, H:i', strtotime($m['created_at'])) ?></td>
                                    <td>
                                        <?php if ($m['is_read']): ?>
                                            <span class="badge badge-read"><i class="bi bi-check2-all"></i> Read</span>
                                        <?php else: ?>
                                            <span class="badge badge-new"><i class="bi bi-stars"></i> New</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="cell-actions">
                                        <?php if (!$m['is_read']): ?>
                                            <!-- Mark as read -->
                                            <form method="post" action="dashboard.php" class="inline-form">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                                <input type="hidden" name="action" value="mark_read">
                                                <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                                                <button type="submit" class="icon-btn icon-btn-read" title="Mark as read">
                                                    <i class="bi bi-check2-circle"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <!-- Delete (with confirmation) -->
                                        <form method="post" action="dashboard.php" class="inline-form js-confirm-delete">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                                            <button type="submit" class="icon-btn icon-btn-delete" title="Delete message">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </section>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
