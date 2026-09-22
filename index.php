<?php
/**
 * index.php — Home page
 * Hero + featured projects grid (project cards link to dedicated pages).
 */
require_once __DIR__ . '/includes/db.php';

$pageTitle  = 'Home';
$activePage = 'home';
require_once __DIR__ . '/includes/header.php';

// Featured projects are database-driven (falls back gracefully if the
// table is empty — the site still works).
$featured = $pdo->query(
    "SELECT slug, title, tagline, description, hero_image_url, tech_stack
       FROM projects
   ORDER BY id ASC"
)->fetchAll();

// Card metadata not stored in the DB: icons + card photo + page link
$cardMeta = [
    'taskflow' => [
        'icon'  => 'bi-kanban',
        'photo' => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=800&q=80',
    ],
    'weatherscope' => [
        'icon'  => 'bi-cloud-sun',
        'photo' => 'https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=800&q=80',
    ],
    'codecollab' => [
        'icon'  => 'bi-code-square',
        'photo' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
    ],
];
?>

<!-- ───────────────────────── HERO ───────────────────────── -->
<section class="hero">
    <div class="hero-glow" aria-hidden="true"></div>
    <div class="container hero-inner">

        <span class="eyebrow-pill reveal">
            <i class="bi bi-stars"></i> Available for opportunities
        </span>

        <h1 class="hero-title reveal">
            Hi, I'm <span class="gradient-text">Abdulrahman Abubakar Kajiji</span>
        </h1>

        <p class="hero-subtitle reveal">
            Aspiring Tech Enthusiast &amp; Developer — building clean, useful, and user-friendly
            digital products while learning something new every day.
        </p>

        <div class="hero-actions reveal">
            <a href="contact.php" class="btn btn-primary">
                <i class="bi bi-send"></i> Get In Touch
            </a>
            <a href="#projects" class="btn btn-ghost">
                <i class="bi bi-kanban"></i> View Projects
            </a>
        </div>

        <!-- Stat row -->
        <div class="hero-stats reveal">
            <div class="stat">
                <span class="stat-number gradient-text">3+</span>
                <span class="stat-label">Projects</span>
            </div>
            <div class="stat">
                <span class="stat-number gradient-text">8+</span>
                <span class="stat-label">Skills</span>
            </div>
            <div class="stat">
                <span class="stat-number gradient-text">&infin;</span>
                <span class="stat-label">Curiosity</span>
            </div>
        </div>

    </div>
</section>

<!-- ──────────────── FEATURED PROJECTS (id="projects") ──────────────── -->
<section class="section" id="projects">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">Featured Projects<span class="title-underline"></span></h2>
            <p class="section-subtitle">
                Things I have designed and built while learning modern web development.
            </p>
        </div>

        <div class="cards-grid">

            <?php if (!$featured): ?>
                <!-- Empty-state fallback (e.g. database imported without seed rows) -->
                <div class="empty-state reveal">
                    <i class="bi bi-kanban"></i>
                    <p>No projects found in the database yet. Run <code>supabase_schema.sql</code> in the Supabase SQL Editor to seed them.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($featured as $p): ?>
                <?php $meta = $cardMeta[$p['slug']] ?? ['icon' => 'bi-kanban', 'photo' => '']; ?>
                <article class="project-card reveal">

                    <!-- Card header photo + floating icon badge -->
                    <div class="project-card-media">
                        <img src="<?= htmlspecialchars($meta['photo']) ?>" alt="<?= htmlspecialchars($p['title']) ?> — project cover photo" loading="lazy">
                        <span class="project-card-badge"><i class="bi <?= htmlspecialchars($meta['icon']) ?>"></i></span>
                    </div>

                    <!-- Card body -->
                    <div class="project-card-body">
                        <h3 class="project-card-title"><?= htmlspecialchars($p['title']) ?></h3>
                        <p class="project-card-desc">
                            <?= htmlspecialchars($p['description'] ?: $p['tagline']) ?>
                        </p>

                        <!-- Tech stack pills -->
                        <div class="tag-row">
                            <?php foreach (array_map('trim', explode(',', $p['tech_stack'])) as $tech): ?>
                                <span class="tag"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <a href="project-<?= urlencode($p['slug']) ?>.php" class="btn btn-primary btn-sm project-card-btn">
                            View Project <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                </article>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
