<?php
/**
 * /includes/db.php
 * PDO connection to the Supabase PostgreSQL database, shared by every page.
 *
 * ── CONFIGURATION (environment variables — no credentials in code) ────────
 * Credentials are read from real environment variables, or from a local
 * `.env` file at the project root (git-ignored). See `.env.example`.
 *
 *   Option A — single connection URL (recommended):
 *     SUPABASE_DB_URL=postgresql://user:password@host:5432/postgres
 *
 *   Option B — individual values:
 *     SUPABASE_DB_HOST / SUPABASE_DB_PORT / SUPABASE_DB_NAME /
 *     SUPABASE_DB_USER / SUPABASE_DB_PASSWORD / SUPABASE_DB_SSLMODE
 *
 * SSL/TLS is enforced with sslmode=require (mandatory for Supabase).
 * Requires the PHP `pdo_pgsql` extension (bundled by vercel-php and most
 * PHP hosting platforms; enable `extension=pdo_pgsql` in php.ini locally).
 */

/* ── Minimal .env loader (no external libraries) ─────────────────────────── */
function kajiji_load_env(): void
{
    static $loaded = false;
    if ($loaded) {
        return;
    }
    $loaded = true;

    $file = dirname(__DIR__) . '/.env';
    if (!is_readable($file)) {
        return;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        // Strip one pair of surrounding quotes, if present.
        $len = strlen($value);
        if ($len >= 2
            && (($value[0] === '"'  && $value[$len - 1] === '"')
             || ($value[0] === '\'' && $value[$len - 1] === '\''))) {
            $value = substr($value, 1, -1);
        }

        // Real environment variables always win over the .env file.
        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
        }
    }
}

function kajiji_env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

/* ── Friendly error page (never exposes credentials or driver messages) ──── */
function kajiji_db_error_page(): void
{
    http_response_code(500);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">'
       . '<title>Database Error</title>'
       . '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">'
       . '</head><body style="font-family:sans-serif;background:#120B1F;color:#F5F0FF;'
       . 'display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;">'
       . '<div style="text-align:center;padding:32px;">'
       . '<i class="bi bi-database-exclamation" style="font-size:3rem;color:#FF512F;"></i>'
       . '<h1 style="font-size:1.4rem;margin:16px 0 8px;">We\'re having trouble connecting to the database.</h1>'
       . '<p style="color:#A79BC2;">Please try again later.</p>'
       . '</div></body></html>';
    exit;
}

kajiji_load_env();

/* ── Resolve connection settings from the environment ────────────────────── */
$connectionUrl = kajiji_env('SUPABASE_DB_URL') ?? kajiji_env('DATABASE_URL');

if ($connectionUrl !== null && $connectionUrl !== '') {
    $parts = parse_url($connectionUrl);
    if ($parts === false || empty($parts['host']) || empty($parts['path'])) {
        error_log('DB configuration error: SUPABASE_DB_URL/DATABASE_URL is set but could not be parsed.');
        kajiji_db_error_page();
    }

    $dbHost = $parts['host'];
    $dbPort = isset($parts['port']) ? (string) $parts['port'] : '5432';
    $dbName = ltrim($parts['path'], '/');
    $dbUser = isset($parts['user']) ? urldecode($parts['user']) : 'postgres';
    $dbPass = isset($parts['pass']) ? urldecode($parts['pass']) : '';

    parse_str($parts['query'] ?? '', $urlQuery);
    $sslMode = $urlQuery['sslmode'] ?? kajiji_env('SUPABASE_DB_SSLMODE', 'require');
} else {
    $dbHost = kajiji_env('SUPABASE_DB_HOST');
    if ($dbHost === null || $dbHost === '') {
        error_log('DB configuration error: no Supabase credentials found. '
                . 'Set SUPABASE_DB_URL or SUPABASE_DB_HOST/PORT/NAME/USER/PASSWORD (see .env.example).');
        kajiji_db_error_page();
    }

    $dbPort  = kajiji_env('SUPABASE_DB_PORT', '5432');
    $dbName  = kajiji_env('SUPABASE_DB_NAME', 'postgres');
    $dbUser  = kajiji_env('SUPABASE_DB_USER', 'postgres');
    $dbPass  = kajiji_env('SUPABASE_DB_PASSWORD', '');
    $sslMode = kajiji_env('SUPABASE_DB_SSLMODE', 'require');
}

/* ── Connect with PDO pgsql ──────────────────────────────────────────────── */
if (!extension_loaded('pdo_pgsql')) {
    error_log('DB configuration error: the PHP extension "pdo_pgsql" is not enabled. '
            . 'Enable "extension=pdo_pgsql" in php.ini or use a host that provides it.');
    kajiji_db_error_page();
}

try {
    $dsn = sprintf(
        'pgsql:host=%s;port=%d;dbname=%s;sslmode=%s',
        $dbHost,
        (int) $dbPort,
        $dbName,
        $sslMode
    );

    $options = [
        // Throw exceptions on SQL errors
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        // Fetch rows as associative arrays by default
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Use real prepared statements (server-side) — safer
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    // Friendly message for the visitor; log the real reason for the developer.
    error_log('DB connection failed: ' . $e->getMessage());
    kajiji_db_error_page();
}
