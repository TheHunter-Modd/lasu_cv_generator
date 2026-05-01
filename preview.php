<?php
// ── Bootstrap: controller sets $cv_data, $active_tab, $preview_error ──
require_once 'includes/preview_contr.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview CV - LASU CV</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_io/favicon-16x16.png">
    <link rel="shortcut icon" href="assets/favicon_io/favicon.ico">
    <link rel="manifest" href="assets/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/preview.css">
</head>
<body>

<div class="dashboard">

    <!-- ── SIDEBAR ─────────────────────────────────────────── -->
    <div class="sidebar">
        <h2 class="logo">
            <img src="assets/file-text.svg" alt="">
            <span>lasucv.</span>
        </h2>

        <ul class="menu">
            <li>
                <a href="dashboard.php">
                    <img src="assets/layout-dashboard.svg" alt="">
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="builder.php">
                    <img src="assets/file-pen.svg" alt="">
                    <span>Builder</span>
                </a>
            </li>
            <li class="active">
                <a href="preview.php">
                    <img src="assets/eye.svg" alt="">
                    <span>Preview CV</span>
                </a>
            </li>
        </ul>

        <a href="includes/logout.inc.php" class="logout">
            <img src="assets/log-out.svg" alt="">
            <span>Logout</span>
        </a>
    </div>

    <!-- ── MAIN ────────────────────────────────────────────── -->
    <div class="main">

        <!-- HEADER -->
        <div class="header-area">
            <div class="top-nav">
                <div class="tabs">
                    <button class="<?= $active_tab === 'personal' ? 'active' : '' ?>"
                            onclick="setTab('personal')">Personal</button>
                    <button class="<?= $active_tab === 'academic' ? 'active' : '' ?>"
                            onclick="setTab('academic')">Academic</button>
                    <button class="<?= $active_tab === 'all'      ? 'active' : '' ?>"
                            onclick="setTab('all')">All Sections</button>
                    <button class="<?= $active_tab === 'reports'  ? 'active' : '' ?>"
                            onclick="setTab('reports')">Reports</button>
                </div>

                <div class="actions">
                    <input type="text" placeholder="Search Task, Meeting, Projects...">
                    <div class="icons">
                        <span><img src="assets/calendar.svg" alt=""></span>
                        <span><img src="assets/bell-dot.svg" alt=""></span>
                        <span><img src="assets/settings.svg" alt=""></span>
                    </div>
                    <div class="profile">
                        <div class="avatar">
                            <?= strtoupper(substr($_SESSION['user_matric'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="info">
                            <strong><?= htmlspecialchars($_SESSION['user_matric'] ?? '') ?></strong>
                            <small>LASU Student</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PREVIEW BODY -->
        <div class="preview-body">

            <!-- Toolbar -->
            <div class="preview-toolbar">
                <a href="dashboard.php" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    Back to Dashboard
                </a>
                <button class="btn-download" onclick="window.print()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16
                                 a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Download PDF / Print
                </button>
            </div>

            <!-- CV Paper -->
            <div class="cv-wrapper">
                <div class="cv-paper" id="cv-paper">

                    <?php if ($preview_error): ?>
                        <?php preview_render_error($preview_error); ?>

                    <?php elseif ($cv_data['is_empty']): ?>
                        <div class="cv-header" id="section-personal">
                            <h1 class="cv-name">YOUR NAME</h1>
                        </div>
                        <?php preview_render_empty(); ?>

                    <?php else: ?>

                        <!-- ── PERSONAL / HEADER ───────────────────── -->
                        <div class="cv-header" id="section-personal">

                            <h1 class="cv-name">
                                <?= $cv_data['personal']['full_name'] ?: 'YOUR NAME' ?>
                            </h1>

                            <?php $p = $cv_data['personal']; ?>
                            <?php if ($p['email'] || $p['phone'] || $p['address'] || $p['linkedin_url']): ?>
                            <div class="cv-contact-row">

                                <?php if ($p['email']): ?>
                                <span class="cv-contact-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    <?= $p['email'] ?>
                                </span>
                                <?php endif; ?>

                                <?php if ($p['phone']): ?>
                                <span class="cv-contact-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.38 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l1.02-.93a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <?= $p['phone'] ?>
                                </span>
                                <?php endif; ?>

                                <?php if ($p['address']): ?>
                                <span class="cv-contact-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <?= $p['address'] ?>
                                </span>
                                <?php endif; ?>

                                <?php if ($p['linkedin_url']): ?>
                                <span class="cv-contact-item">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                    <?= $p['linkedin_url'] ?>
                                </span>
                                <?php endif; ?>

                            </div>
                            <?php endif; ?>

                            <?php if ($p['summary']): ?>
                            <div class="cv-section" id="section-summary">
                                <div class="cv-section-title">Professional Summary</div>
                                <div class="cv-section-rule"></div>
                                <p class="cv-summary"><?= $p['summary'] ?></p>
                            </div>
                            <?php endif; ?>

                        </div><!-- /cv-header -->

                        <!-- ── EDUCATION ───────────────────────────── -->
                        <div class="cv-section" id="section-academic">
                            <div class="cv-section-title">Education</div>
                            <div class="cv-section-rule"></div>

                            <?php if (empty($cv_data['education'])): ?>
                                <?php preview_render_section_empty('education'); ?>
                            <?php else: ?>
                                <?php foreach ($cv_data['education'] as $edu): ?>
                                <div class="cv-entry">
                                    <div class="cv-entry-header">
                                        <div>
                                            <div class="cv-entry-title">
                                                <?= $edu['degree'] ?>
                                                <?= $edu['field'] ? ' in ' . $edu['field'] : '' ?>
                                            </div>
                                            <div class="cv-entry-subtitle"><?= $edu['institution'] ?></div>
                                        </div>
                                        <div class="cv-entry-date">
                                            <?= $edu['start'] ?>
                                            <?= $edu['end'] ? ' – ' . $edu['end'] : ' – Present' ?>
                                        </div>
                                    </div>
                                    <?php if ($edu['grade']): ?>
                                    <div class="cv-entry-detail">Grade / CGPA: <?= $edu['grade'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- ── EXPERIENCE ──────────────────────────── -->
                        <div class="cv-section" id="section-experience">
                            <div class="cv-section-title">Work Experience</div>
                            <div class="cv-section-rule"></div>

                            <?php if (empty($cv_data['experience'])): ?>
                                <?php preview_render_section_empty('work experience'); ?>
                            <?php else: ?>
                                <?php foreach ($cv_data['experience'] as $exp): ?>
                                <div class="cv-entry">
                                    <div class="cv-entry-header">
                                        <div>
                                            <div class="cv-entry-title"><?= $exp['job_title'] ?></div>
                                            <div class="cv-entry-subtitle"><?= $exp['company'] ?></div>
                                        </div>
                                        <div class="cv-entry-date">
                                            <?= $exp['start'] ?>
                                            <?= $exp['end'] ? ' – ' . $exp['end'] : ' – Present' ?>
                                        </div>
                                    </div>
                                    <?php if ($exp['description']): ?>
                                    <p class="cv-entry-desc"><?= $exp['description'] ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- ── SKILLS ──────────────────────────────── -->
                        <div class="cv-section" id="section-skills">
                            <div class="cv-section-title">Skills &amp; Competencies</div>
                            <div class="cv-section-rule"></div>

                            <?php if (empty($cv_data['skills'])): ?>
                                <?php preview_render_section_empty('skills'); ?>
                            <?php else: ?>
                            <div class="cv-skills-list">
                                <?php foreach ($cv_data['skills'] as $skill): ?>
                                <span class="cv-skill-tag"><?= $skill ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>

                    <?php endif; ?>

                </div><!-- /cv-paper -->
            </div><!-- /cv-wrapper -->

        </div><!-- /preview-body -->
    </div><!-- /main -->
</div><!-- /dashboard -->

<script>
const TAB_MAP = {
    personal : ['section-personal', 'section-summary', 'section-skills'],
    academic : ['section-personal', 'section-academic'],
    all      : null,
    reports  : []
};

function setTab(tab) {
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);

    const labels = { personal: 'Personal', academic: 'Academic',
                     all: 'All Sections', reports: 'Reports' };
    document.querySelectorAll('.tabs button').forEach(btn => {
        btn.classList.toggle('active', btn.textContent.trim() === labels[tab]);
    });

    const sections = document.querySelectorAll('.cv-header, .cv-section');
    const whitelist = TAB_MAP[tab];

    sections.forEach(el => {
        if (whitelist === null) {
            el.style.display = '';
        } else {
            el.style.display = whitelist.includes(el.id) ? '' : 'none';
        }
    });
}

setTab('<?= $active_tab ?>');
</script>

</body>
</html>
