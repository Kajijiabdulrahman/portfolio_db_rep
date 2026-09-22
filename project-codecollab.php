<?php
/**
 * project-codecollab.php — CodeCollab project page
 * Hero banner, overview, features, video demo, gallery.
 */
$pageTitle  = 'CodeCollab';
$activePage = 'home';   // project pages live under "Home" for nav purposes
require_once __DIR__ . '/includes/header.php';
?>

<!-- ─────────────────── HERO BANNER ─────────────────── -->
<section class="project-hero" style="--hero-img:url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1600&q=80')">
    <div class="project-hero-overlay"></div>
    <div class="container project-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="index.php#projects">Projects</a>
            <i class="bi bi-chevron-right"></i>
            <span>CodeCollab</span>
        </nav>
        <h1 class="project-hero-title gradient-text">CodeCollab</h1>
        <p class="project-hero-tagline">
            <i class="bi bi-code-square"></i> A collaborative code editor where teams write together, in real time.
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
                    <strong>CodeCollab</strong> is the most ambitious project I have taken on so far: a
                    multi-user, real-time code editor where several people can type in the same file at
                    the same time and see each other's cursors move live — like a lightweight, self-hosted
                    Google Docs for code.
                </p>
                <p>
                    The architecture is a React front-end talking to a Node.js server over
                    <strong>Socket.io</strong> WebSockets. Every keystroke is broadcast to everyone in a
                    shared room, where a lightweight operational transform keeps all copies of the
                    document in sync. The Monaco editor — the same engine that powers VS Code — provides
                    syntax highlighting and IntelliSense-style completions.
                </p>
                <p>
                    Rooms are created with a single click and joined with a short share code, so a pair
                    programming session starts in under five seconds. Presence indicators show who is in
                    the room, and each participant gets their own labelled cursor colour. There is also a
                    lightweight chat sidebar for quick questions without leaving the editor.
                </p>
                <p>
                    This project pushed me deep into asynchronous programming, WebSocket lifecycle
                    management, and conflict resolution. Seeing another person's cursor glide across my
                    screen for the first time was genuinely magical — and it convinced me that real-time
                    collaboration is the kind of engineering I want to keep pursuing.
                </p>
            </div>

            <!-- RIGHT: info card -->
            <aside class="info-panel reveal">
                <h3 class="info-panel-title">
                    <i class="bi bi-code-square"></i> Project Info
                </h3>

                <dl class="info-panel-list">
                    <div class="info-panel-row">
                        <dt><i class="bi bi-person-badge"></i> Role</dt>
                        <dd>Front-End Developer</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-calendar3"></i> Timeline</dt>
                        <dd>6 weeks</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-code-slash"></i> Tech Stack</dt>
                        <dd>
                            <ul class="tech-list">
                                <li><i class="bi bi-lightning-charge"></i> React</li>
                                <li><i class="bi bi-hexagon"></i> Node.js</li>
                                <li><i class="bi bi-broadcast"></i> Socket.io</li>
                                <li><i class="bi bi-terminal"></i> Monaco Editor</li>
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
            <p class="section-subtitle">Real-time collaboration without the setup friction.</p>
        </div>

        <div class="features-grid">

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-people"></i></span>
                <h3>Shared Rooms</h3>
                <p>Create a room and share a short code — teammates join in seconds, no accounts needed.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-cursor"></i></span>
                <h3>Live Cursors</h3>
                <p>See every participant's cursor and selection moving in real time, colour-coded per user.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-magic"></i></span>
                <h3>Smart Editing</h3>
                <p>Monaco powers syntax highlighting and completions for dozens of languages.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-chat-dots"></i></span>
                <h3>Built-in Chat</h3>
                <p>A sidebar chat keeps discussion next to the code, with unread indicators.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-arrow-repeat"></i></span>
                <h3>Conflict Sync</h3>
                <p>Operational-transform sync keeps every copy of the document consistent, even offline edits.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-download"></i></span>
                <h3>Session Export</h3>
                <p>Download the final file, or a transcript of the session, when the session ends.</p>
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
                title="CodeCollab — full project walkthrough"
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
            <p class="section-subtitle">Moments from the pair-programming sessions that shaped the product.</p>
        </div>

        <div class="gallery-grid">

            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1522252234503-e356532cafd5?auto=format&fit=crop&w=800&q=80"
                     alt="Code on a dark monitor with colorful syntax highlighting" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80"
                     alt="Two developers reviewing code together at one desk" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1607252650355-f7fd0460ccdb?auto=format&fit=crop&w=800&q=80"
                     alt="Team pair programming with laptops and a whiteboard" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?auto=format&fit=crop&w=800&q=80"
                     alt="Developer typing code on a laptop in a dim room" loading="lazy">
            </figure>

        </div>

        <!-- Back link -->
        <div class="back-row reveal">
            <a href="index.php" class="btn btn-ghost"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

