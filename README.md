# Abdulrahman Abubakar Kajiji — Portfolio Website

A complete, responsive multi-page portfolio built with **PHP 8 + Supabase PostgreSQL (PDO)**,
a custom sunset-gradient design system, Bootstrap Icons, and a database-driven
contact form with an admin dashboard.

The database layer has been migrated from local MySQL/MariaDB (XAMPP) to
**Supabase PostgreSQL**, so the website and its database run entirely online
in production — no local MySQL, phpMyAdmin, or XAMPP database required.

## Architecture

```
┌───────────────────────────────┐
│          WEBSITE              │
│  PHP Portfolio                │
│  Home / About / Projects      │
│  Contact form                 │
│  Admin login + dashboard      │
└───────────────┬───────────────┘
                │  PDO (pdo_pgsql) over TLS
                ▼
┌───────────────────────────────┐
│          SUPABASE             │
│  PostgreSQL Database          │
│  messages · admins · projects │
└───────────────────────────────┘
```

## Features

- Home, About, Contact + 3 dedicated project pages (TaskFlow, WeatherScope, CodeCollab)
- Working contact form: PDO prepared statements, CSRF protection, PRG pattern
- Admin panel: session login, message inbox with mark-as-read / delete actions
- Dark / light theme toggle (saved in localStorage), mobile hamburger menu,
  scroll-reveal animations, reduced-motion support
- Database credentials supplied via environment variables (never hard-coded)

## Requirements

- PHP 8.0+ with the **`pdo_pgsql`** extension (enabled by default on the
  vercel-php Vercel runtime and most PHP hosting platforms)
- A free [Supabase](https://supabase.com) project (provides the PostgreSQL
  database) — **no local MySQL/MariaDB is needed**

## Setup (about 10 minutes)

### Step 1 — Create a Supabase project

1. Go to <https://supabase.com> and sign in (or sign up for free).
2. Click **New project**, give it a name (e.g. `kajiji-portfolio`), choose a
   region close to your expected visitors, and set the **database password**
   (save it — you will need it below).

### Step 2 — Open the Supabase SQL Editor

In your project dashboard, click the **SQL Editor** icon in the left sidebar.

### Step 3 — Run `supabase_schema.sql`

1. Click **New query**.
2. Open `supabase_schema.sql` from this repository, copy its entire contents
   into the editor, and click **Run**.
3. This creates the `messages`, `admins`, and `projects` tables, enables
   Row Level Security (deny-by-default for the public REST API), seeds the
   `admin` account, and inserts the three existing projects.

The script is idempotent — re-running it is safe and never duplicates rows.

### Step 4 — Obtain the PostgreSQL connection information

In the dashboard go to **Project Settings → Database** and use the
**Connection string / Connection parameters** shown there. Supabase offers
several connection methods; for a server-side PHP deployment:

| Method | Host shape | Port | Use when |
|---|---|---|---|
| **Session pooler** *(recommended)* | `aws-0-<region>.pooler.supabase.com` | `5432` | Hosting has IPv4 (most shared hosts, Vercel). Username is `postgres.<project-ref>`. |
| Transaction pooler | `aws-0-<region>.pooler.supabase.com` | `6543` | Serverless platforms (Vercel functions) where you want aggressive connection reuse. |
| Direct connection | `db.<project-ref>.supabase.co` | `5432` | Only if your host supports IPv6 (this hostname is IPv6-only unless you buy the IPv4 add-on). |

> **Not sure?** Use the **Session Pooler** values — they work everywhere,
> including hosts without IPv6. Copy the values exactly as shown in the
> Supabase dashboard for *your* project; the exact host string is per-project.

### Step 5 — Configure environment variables

Copy `.env.example` to `.env` (the `.env` file is git-ignored and must never
be committed) and fill in the values from Step 4:

**Option A — single URL (recommended):**
paste the full connection string (URI tab) into `SUPABASE_DB_URL`:

```
SUPABASE_DB_URL=postgresql://postgres.<project-ref>:<password>@aws-0-<region>.pooler.supabase.com:5432/postgres
```

**Option B — individual values** (leave `SUPABASE_DB_URL` empty):

```
SUPABASE_DB_HOST=aws-0-<region>.pooler.supabase.com
SUPABASE_DB_PORT=5432
SUPABASE_DB_NAME=postgres
SUPABASE_DB_USER=postgres.<project-ref>
SUPABASE_DB_PASSWORD=<your-database-password>
SUPABASE_DB_SSLMODE=require
```

Notes:
- The database name is **`postgres`** (not `portfolio_db`).
- If your password contains special characters (`@ : / # ?`), URL-encode them
  when using Option A, or use Option B.
- TLS is always enforced (`sslmode=require`) — required by Supabase.
- On **Vercel**: do not use a `.env` file. Add the same variables in
  *Project → Settings → Environment Variables*.

### Step 6 — Run / test the PHP application

Any PHP-capable server works — **no MySQL needed**:

```bash
# Option 1: PHP built-in server (fastest for local testing)
php -S localhost:8000

# Option 2: XAMPP Apache — place the project in C:\xampp\htdocs\kajiji
#           (Apache serves PHP; the database is still remote Supabase)
```

Then open <http://localhost:8000/>.

> **Local `pdo_pgsql` note:** XAMPP's PHP build ships `php_pgsql.dll` but may
> lack `pdo_pgsql.dll`. To test locally, enable `extension=pdo_pgsql` in
> `php.ini` if your build has the DLL, or use Laragon / another PHP 8 build.
> If the extension is missing, the site shows a friendly "database trouble"
> page and logs the reason — it never crashes with a raw stack trace.
> Production hosts (vercel-php, most shared hosts) already include `pdo_pgsql`.

Optional quick check from the command line:

```bash
php tools/check_db.php
# → ✔ Connected to PostgreSQL.
# → messages / admins / projects row counts, admin account check
```

### Step 7 — Test the site

| Test | Where | Expected |
|---|---|---|
| Projects load | `/` | Three project cards (TaskFlow, WeatherScope, CodeCollab) |
| Contact form | `/contact.php` | Submit → success flash → row appears in `messages` |
| Admin login | `/admin/login.php` | `admin` / `admin123` → redirected to dashboard |
| Dashboard | `/admin/dashboard.php` | Total/Unread Messages, Total Projects, message table |
| Mark as read | dashboard ✔ button | Status changes New → Read |
| Delete | dashboard 🗑 button | Row removed after confirmation |
| Logout | dashboard Logout | Session destroyed; dashboard redirects to login |

### Step 8 — Deploy to a PHP-compatible hosting platform

The app is a standard multi-file PHP site; any host with **PHP 8+ and
`pdo_pgsql`** works (shared hosting, Railway, Render, a VPS with
nginx/php-fpm, cPanel…). Set the environment variables from Step 5 in the
host's control panel, and set the document root to the project folder.

**Vercel (optional)** — Vercel runs PHP through the community
[`vercel-php`](https://github.com/vercel-community/php) runtime, which bundles
`pdo_pgsql` by default. Example `vercel.json`:

```json
{
  "functions": {
    "api/**/*.php": { "runtime": "vercel-php@0.9.0" }
  }
}
```

- Place (or symlink) the PHP entry files under `api/`, or follow the
  multi-page routing examples in the vercel-php documentation/repository.
- Add the environment variables in *Vercel Project → Settings → Environment
  Variables* (same names as `.env.example`).
- Because Vercel functions are serverless, prefer the **connection pooler**
  (Step 4). The **transaction pooler** (port `6543`) is the best fit for
  short-lived serverless requests.
- Do **not** deploy `.env` or `tools/check_db.php` to production.

## Migrating old MySQL data (optional)

The old local MySQL database is **not** touched by this migration. If your
`messages` table contains real contact messages you want to keep:

1. Keep the old XAMPP MySQL running temporarily and export the data:
   - phpMyAdmin → `portfolio_db` → `messages` → *Export* (SQL), or
   - `mysqldump -u root portfolio_db messages`
2. Convert each row to PostgreSQL-compatible `INSERT`s. Type changes needed:
   - `is_read`: `0`/`1` → `FALSE`/`TRUE`
   - `created_at`: MySQL `TIMESTAMP` values insert fine into `TIMESTAMPTZ`.
3. Run them in the Supabase SQL Editor:

```sql
INSERT INTO messages (name, email, subject, message, created_at, is_read) VALUES
('Old Name', 'old@example.com', 'Old subject', 'Old message...', '2024-05-01 10:30:00', TRUE)
ON CONFLICT DO NOTHING;
-- (messages has no natural unique key; only run the export once)
```

The admin account and the three projects are already seeded by
`supabase_schema.sql`, so no migration is needed for them. Once everything is
verified on Supabase, you can stop XAMPP's MySQL and archive the old
`database.sql` (kept in this repository only for reference).


## Admin Access

| URL | Credentials |
|---|---|
| `https://your-domain.com/admin/login.php` | **admin / admin123** |

> Change the password after first login! Generate a new hash with:
> `php -r "echo password_hash('your-new-password', PASSWORD_DEFAULT);"`
> then update the `admins` table in the Supabase SQL Editor:
> `UPDATE admins SET password_hash = '<new-hash>' WHERE username = 'admin';`

## File Structure

```
/
├── index.php                 Home page (hero + featured projects)
├── about.php                 About page (bio + skills)
├── contact.php               Contact page (DB-backed form)
├── project-taskflow.php      TaskFlow project page
├── project-weatherscope.php  WeatherScope project page
├── project-codecollab.php    CodeCollab project page
├── style.css                 Shared stylesheet (design system)
├── script.js                 Shared JS (theme, menu, reveal)
├── supabase_schema.sql       PostgreSQL schema + seed data (run in Supabase)
├── database.sql              Legacy MySQL schema (reference only — unused)
├── .env.example              Environment variable template (no secrets)
├── .gitignore                Keeps .env and local files out of git
├── README.md
├── /includes
│   ├── db.php                PDO pgsql connection (reads env vars)
│   ├── header.php            <head> + navbar
│   └── footer.php            Footer
├── /admin
│   ├── login.php             Login form
│   ├── auth.php              Session guard
│   ├── dashboard.php         Message inbox + stats
│   └── logout.php            Destroy session
└── /tools
    └── check_db.php          CLI connectivity self-test (dev only)
```

## Security Notes

- All queries use **PDO prepared statements** (server-side prepares,
  emulated prepares disabled) — no user input is concatenated into SQL.
- Credentials live in **environment variables** / a git-ignored `.env`;
  nothing is hard-coded and nothing is exposed to the browser or JavaScript.
- The connection uses **TLS** (`sslmode=require`) as required by Supabase.
- **Supabase RLS**: enabled on all three tables **with no public policies** —
  Supabase's auto-generated REST API (`anon` / `authenticated` roles) is
  denied all access by default. The PHP backend connects server-side with the
  `postgres` SQL role, which is unaffected by RLS, so the site keeps full
  access. This project never uses the `service_role` key or Supabase JS SDK.
- Database errors are logged server-side; visitors only see a friendly
  "We're having trouble connecting to the database. Please try again later."
  page — never driver messages, hosts, or credentials.
- CSRF tokens on every POST form (contact, login, admin actions).
- `password_verify()` for authentication; bcrypt hashes only (no plain-text
  passwords); `session_regenerate_id(true)` on login.
- All user/DB output escaped with `htmlspecialchars()`.
- Rate limiting is intentionally left as a documented next step (see the note
  in `admin/login.php`).

## Customising

- **Colours**: edit the CSS variables at the top of `style.css` (`:root`).
- **Videos**: replace the YouTube ID (`dQw4w9WgXcQ`) in each project page's
  `.video-wrapper` iframe — or in the `projects` table's `youtube_video_id`.
- **Projects**: edit rows in the `projects` table (Supabase → Table Editor);
  the home page grid is database-driven.

