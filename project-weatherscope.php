<?php
/**
 * project-weatherscope.php — WeatherScope project page
 * Hero banner, overview, features, video demo, gallery.
 */
$pageTitle  = 'WeatherScope';
$activePage = 'home';   // project pages live under "Home" for nav purposes
require_once __DIR__ . '/includes/header.php';
?>

<!-- ─────────────────── HERO BANNER ─────────────────── -->
<section class="project-hero" style="--hero-img:url('https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=1600&q=80')">
    <div class="project-hero-overlay"></div>
    <div class="container project-hero-inner reveal">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="index.php#projects">Projects</a>
            <i class="bi bi-chevron-right"></i>
            <span>WeatherScope</span>
        </nav>
        <h1 class="project-hero-title gradient-text">WeatherScope</h1>
        <p class="project-hero-tagline">
            <i class="bi bi-cloud-sun"></i> A real-time weather dashboard for any city on Earth.
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
                    <strong>WeatherScope</strong> is my first serious dive into working with third-party
                    REST APIs. Type any city into the search bar and the dashboard instantly paints a
                    complete picture of the weather there — current conditions, a seven-day forecast,
                    and animated charts of temperature and humidity trends.
                </p>
                <p>
                    Under the hood, the app fetches live data from a public weather API, normalises it
                    into a clean internal format, and renders it with pure CSS Grid and Chart.js.
                    I hand-rolled the geolocation search with debouncing, so suggestions appear as you
                    type without hammering the API on every keystroke — a small detail that taught me
                    a lot about being a good API citizen.
                </p>
                <p>
                    Error handling was a big part of this project. Cities that don't exist, network
                    timeouts, and rate limits are all caught gracefully and explained to the user with
                    friendly inline messages instead of a blank screen. The app also caches the last
                    successful lookup, so reopening it shows your favourite city immediately, even
                    before fresh data arrives.
                </p>
                <p>
                    WeatherScope stretched my skills in asynchronous JavaScript, chart rendering, and
                    designing data-dense layouts that stay calm and readable. It also cemented my love
                    for sky photography — the dynamic backgrounds change with the weather conditions,
                    turning the dashboard into something you almost want to leave open on a second
                    monitor.
                </p>
            </div>

            <!-- RIGHT: info card -->
            <aside class="info-panel reveal">
                <h3 class="info-panel-title">
                    <i class="bi bi-cloud-sun"></i> Project Info
                </h3>

                <dl class="info-panel-list">
                    <div class="info-panel-row">
                        <dt><i class="bi bi-person-badge"></i> Role</dt>
                        <dd>Front-End Developer</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-calendar3"></i> Timeline</dt>
                        <dd>4 weeks</dd>
                    </div>
                    <div class="info-panel-row">
                        <dt><i class="bi bi-code-slash"></i> Tech Stack</dt>
                        <dd>
                            <ul class="tech-list">
                                <li><i class="bi bi-filetype-js"></i> JavaScript (ES6+)</li>
                                <li><i class="bi bi-cloud-arrow-down"></i> REST API</li>
                                <li><i class="bi bi-bar-chart-line"></i> Chart.js</li>
                                <li><i class="bi bi-grid-3x3"></i> CSS Grid</li>
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
            <p class="section-subtitle">Live data, clean charts, and a dashboard that never leaves you guessing.</p>
        </div>

        <div class="features-grid">

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-search"></i></span>
                <h3>City Search</h3>
                <p>Debounced autocomplete finds any city worldwide as you type — no page reloads.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-thermometer-sun"></i></span>
                <h3>Current Conditions</h3>
                <p>Temperature, humidity, wind, and UV index presented in a clean, glanceable card.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-calendar-week"></i></span>
                <h3>7-Day Forecast</h3>
                <p>A scrollable week-ahead forecast with icons, highs and lows for every day.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-graph-up"></i></span>
                <h3>Animated Charts</h3>
                <p>Chart.js visualisations of temperature and humidity trends across the week.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-geo-alt"></i></span>
                <h3>Auto-Location</h3>
                <p>One tap uses the browser's geolocation API to load your local weather instantly.</p>
            </article>

            <article class="feature-card reveal">
                <span class="feature-icon"><i class="bi bi-wifi-off"></i></span>
                <h3>Offline Cache</h3>
                <p>The last successful lookup is cached, so the dashboard opens instantly every time.</p>
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
                title="WeatherScope — full project walkthrough"
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
            <p class="section-subtitle">Skies and storms that inspired the dashboard's visual language.</p>
        </div>

        <div class="gallery-grid">

            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1534088568595-a066f410bcda?auto=format&fit=crop&w=800&q=80"
                     alt="Dramatic sunset sky with layered clouds" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1592210454359-9043f067919b?auto=format&fit=crop&w=800&q=80"
                     alt="Weather map with forecast data on a screen" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1601134467661-3d775b999c8b?auto=format&fit=crop&w=800&q=80"
                     alt="Storm clouds gathering over an open landscape" loading="lazy">
            </figure>
            <figure class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1561553873-e8491a564fd0?auto=format&fit=crop&w=800&q=80"
                     alt="Rain drops on a window with a grey sky behind" loading="lazy">
            </figure>

        </div>

        <!-- Back link -->
        <div class="back-row reveal">
            <a href="index.php" class="btn btn-ghost"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

