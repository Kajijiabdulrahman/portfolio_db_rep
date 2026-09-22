<?php
/**
 * tools/check_db.php — optional Supabase connectivity self-test.
 *
 * Usage (command line, from the project root):
 *     php tools/check_db.php
 *
 * Verifies that:
 *   1. PHP can connect to the configured Supabase PostgreSQL database.
 *   2. The three tables (messages / admins / projects) exist.
 *   3. The seeded admin account is present.
 *
 * This is a development tool. Do NOT deploy it to production.
 * Requires the pdo_pgsql extension and a configured .env (see .env.example).
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This tool may only be run from the command line.\n");
}

require __DIR__ . '/../includes/db.php';

echo "✔ Connected to PostgreSQL.\n";
echo 'Server: ' . substr((string) $pdo->query('SELECT version()')->fetchColumn(), 0, 80) . "\n\n";

foreach (['messages', 'admins', 'projects'] as $table) {
    // $table comes from the fixed list above — never from user input.
    $count = (int) $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
    printf("%-10s %d row(s)\n", $table, $count);
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM admins WHERE username = :username');
$stmt->execute([':username' => 'admin']);

echo "\nSeeded admin account 'admin': ";
echo ($stmt->fetchColumn() > 0) ? "present ✔\n" : "MISSING ✘ — run supabase_schema.sql\n";

echo "\nAll checks finished.\n";
