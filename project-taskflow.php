<?php
/**
 * project-taskflow.php — TaskFlow project page
 * Hero banner, overview, features, video demo, gallery.
 */
$pageTitle  = 'TaskFlow';
$activePage = 'home';   // project pages live under "Home" for nav purposes
require_once __DIR__ . '/includes/header.php';
?>

<!-- ─────────────────── HERO BANNER ─────────────────── -->
<section class="project-hero" style="--hero-img:url('https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=1600&q=80')">
    <div class="project-hero-overlay"></div>
    <div class="container project-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="index.php#projects">Projects</a>
            <i class="bi bi-chevron-right"></i>
            <span>TaskFlow</span>
        </nav>
        <h1 class="project-hero-title gradient-text">TaskFlow</h1>
        <p class="project-hero-tagline">
            <i class="bi bi-kanban"></i> A lightweight productivity app that makes organising your day feel effortless.
        </p>
    </div>
</section>

<!-- ─────────────────── OVERVIEW ─────────────────── -->
<section class="section">
    <div class="container">

        <div class="overview-grid">

            <!-- LEFT: detailed description -->
            <div class="overview-text reveal">
                <h2 class="section-title">Project Overview<span class="title-underline"></span></h2>

                <p>
                    <strong>TaskFlow</strong> started as a personal challenge: could I build a to-do app
                    that people would actually enjoy using, without a single line of backend code? The
                    answer became a fully client-side productivity tool that runs instantly in the browser
                    and remembers everything you do.
                </p>
                <p>
                    The core of TaskFlow is a fast task pipeline — add a task, drag it between
                    "To Do", "In Progress", and "Done" columns, and watch your progress bar fill up in
                    real time. Every change is saved to <strong>localStorage</strong> the moment it
                    happens, so even if you close the tab or go offline, your board is exactly where you
                    left it when you come back.
                </p>
                <p>
                    I paid special attention to the small details: satisfying drag-and-drop animations,
                    keyboard-friendly task creation, automatic due-date reminders, and a dark mode that
                    respects your system preference. The interface is fully responsive, so the same
                    board works beautifully on a phone during your commute or on a large desktop monitor
                    at your desk.
                </p>
                <p>
                    Building TaskFlow taught me a lot about state management in vanilla JavaScript,
                    accessible drag-and-drop patterns, and how to structure a codebase so features
                    (like reminders and statistics) can be added without rewriting everything. It
                    remains my go-to reference for clean, framework-free front-end architecture.
                </p>
            </div>

            <!-- RIGHT: info card -->
            <aside class="info-panel reveal">
                <h3 class="info-panel-title">
                    <i class="bi bi-kanban"></i> Project Info
                </h3>

                <dl class="info-panel-list">
                    <div class="info-panel-row">
                        <dt><i class="bi bi-person-badge"></i> Role</dt>
                        <dd>Front-End Developer</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-calendar3"></i> Timeline</dt>
                        <dd>3 weeks</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-code-slash"></i> Tech Stack</dt>
                        <dd>
                            <ul class="tech-list">
                                <li><i class="bi bi-filetype-html"></i> HTML5</li>
                                <li><i class="bi bi-filetype-css"></i> CSS3</li>
                                <li><i class="bi bi-filetype-js"></i> JavaScript</li>
                                <li><i class="bi bi-hdd"></i> LocalStorage</li>
                            </ul>
                        </dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-globe2"></i> Live Demo</dt>
                        <dd><a href="#" class="info-panel-link">Coming soon <i class="bi bi-box-arrow-up-right"></i></a></dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-github"></i> GitHub</dt>
                        <dd><a href="#" class="info-panel-link">View source <i class="bi bi-box-arrow-up-right"></i></a></dd>
                    </div>
                </dl>
            </aside>

        </div>
    </div>
</section>

<!-- ─────────────────── FEATURES ─────────────────── -->
<section class="section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">Key Features<span class="title-underline"></span></h2>
            <p class="section-subtitle">Everything TaskFlow does, built from scratch in vanilla JavaScript.</p>
        </div>

        <div class="features-grid">

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-plus-square"></i></span>
                <h3>Task Creation</h3>
                <p>Add tasks in seconds with titles, notes, and priority levels — no signup required.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-arrows-move"></i></span>
                <h3>Drag &amp; Drop Board</h3>
                <p>Move tasks between To Do, In Progress, and Done with smooth pointer-based dragging.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-cloud-slash"></i></span>
                <h3>Offline Saving</h3>
                <p>Every change is written to localStorage instantly — your board survives refreshes and outages.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-bar-chart"></i></span>
                <h3>Progress Tracking</h3>
                <p>A live progress ring and counters show how much of your day you have conquered.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-moon"></i></span>
                <h3>Dark Mode</h3>
                <p>Automatic theme switching that respects your system preference, day or night.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-bell"></i></span>
                <h3>Reminders</h3>
                <p>Set due dates and TaskFlow nudges you with gentle in-app reminders before deadlines.</p>
            </article>

        </div>
    </div>
</section>

<!-- ─────────────────── VIDEO DEMO ─────────────────── -->
<section class="section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">Video Demonstration<span class="title-underline"></span></h2>
            <p class="section-subtitle">Watch a full walkthrough of the project.</p>
        </div>

        <div class="video-wrapper reveal">
            <iframe
                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                title="TaskFlow — full project walkthrough"
                loading="lazy"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
        <p class="video-caption"><i class="bi bi-play-circle"></i> Watch a full walkthrough of the project.</p>

    </div>
</section>

<!-- ─────────────────── SCREENSHOT GALLERY ─────────────────── -->
<section class="section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">Screenshots<span class="title-underline"></span></h2>
            <p class="section-subtitle">A glimpse of the workspace that inspired the design.</p>
        </div>

        <div class="gallery-grid">

            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&w=800&q=80"
                     alt="Weekly planner spread with handwritten task lists" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=800&q=80"
                     alt="Person organising sticky notes on a planning board" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1512758017271-d7b84c2113f1?auto=format&fit=crop&w=800&q=80"
                     alt="Productivity tracking charts beside a laptop" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&w=800&q=80"
                     alt="Task checklist on a clipboard next to a coffee cup" loading="lazy">
            </figure>

        </div>

        <!-- Back link -->
        <div class="back-row reveal">
            <a href="index.php" class="btn btn-ghost"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

