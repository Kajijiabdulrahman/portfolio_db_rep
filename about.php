<?php
/**
 * about.php — About page
 * Profile card + bio + skills grid.
 */
$pageTitle  = 'About';
$activePage = 'about';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ─────────────────── ABOUT ME ─────────────────── -->
<section class="section section-first">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">About Me<span class="title-underline"></span></h2>
            <p class="section-subtitle">
                Who I am, what I do, and what keeps me excited about technology.
            </p>
        </div>

        <div class="about-grid">

            <!-- LEFT: profile card -->
            <div class="about-card reveal">
                <!-- Avatar: "AK" initials inside a gradient ring -->
                <div class="avatar-ring">
                    <div class="avatar">AK</div>
                </div>

                <h3 class="about-name">Abdulrahman Abubakar Kajiji</h3>
                <p class="about-role">Web Developer &amp; Tech Enthusiast</p>

                <p class="about-location">
                    <i class="bi bi-geo-alt-fill"></i>
                    Nassarawa Local Government, Kano State, Nigeria
                </p>
            </div>

            <!-- RIGHT: bio paragraphs -->
            <div class="about-bio reveal">
                <p>
                    Hello! I'm <strong>Abdulrahman Abubakar Kajiji</strong>, a passionate and curious
                    tech learner from Nassarawa Local Government, Kano State, Nigeria. My journey into
                    technology started with a simple question — <em>"how does a website actually work?"</em>
                    — and it quickly turned into a genuine love for building things for the web.
                </p>
                <p>
                    I enjoy every stage of bringing an idea to life: sketching the layout, writing clean
                    HTML and CSS, adding interactivity with JavaScript, and then connecting everything to
                    a real backend with PHP and MySQL. What excites me most is creating products that are
                    genuinely <strong>useful</strong> — tools people actually want to open, with interfaces
                    that feel effortless.
                </p>
                <p>
                    Right now I'm focused on strengthening my front-end foundations while continuously
                    learning modern tools and frameworks. Every project I ship — like the three featured
                    on the home page — teaches me something new about performance, accessibility,
                    and writing code other people can read.
                </p>
                <p>
                    When I'm not coding, I'm exploring new tech, following developer communities, and
                    challenging myself with small experiments that stretch what I know. I'm currently
                    <strong>open to internships, junior roles, and freelance opportunities</strong> where
                    I can contribute, grow, and keep learning every single day.
                </p>
            </div>

        </div>

        <!-- ─────────────────── SKILLS ─────────────────── -->
        <div class="section-head reveal skills-head">
            <h2 class="section-title">Skills &amp; Tools<span class="title-underline"></span></h2>
            <p class="section-subtitle">The technologies I work with today — and keep sharpening.</p>
        </div>

        <div class="skills-grid reveal">

            <span class="skill-pill"><i class="bi bi-filetype-html"></i> HTML5</span>
            <span class="skill-pill"><i class="bi bi-filetype-css"></i> CSS3</span>
            <span class="skill-pill"><i class="bi bi-filetype-js"></i> JavaScript</span>
            <span class="skill-pill"><i class="bi bi-lightning-charge"></i> React</span>
            <span class="skill-pill"><i class="bi bi-git"></i> Git &amp; GitHub</span>
            <span class="skill-pill"><i class="bi bi-phone"></i> Responsive Design</span>
            <span class="skill-pill"><i class="bi bi-palette"></i> UI Design Basics</span>
            <span class="skill-pill"><i class="bi bi-lightbulb"></i> Problem Solving</span>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
