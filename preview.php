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
    <?php 
    // 1. Get the chosen template from the data, default to 'classic'
    $chosen_template = $cv_data['personal']['template_choice'] ?: 'classic';
    
    // 2. Security: Only allow these exact file names (prevents hacking)
        $allowed_templates = ['classic', 'professional', 'academic'];
    if (!in_array($chosen_template, $allowed_templates)) {
        $chosen_template = 'classic';
    }
?>
<link rel="stylesheet" href="css/preview.css?v=4"> <!-- Main print/layout rules -->
<link rel="stylesheet" href="css/templates/<?= $chosen_template ?>.css?v=1"> <!-- Dynamic Template! -->
</head>
<body>

<div class="dashboard">
    <div class="sidebar-overlay" onclick="toggleMobileMenu()"></div>

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
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
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
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Dashboard
    </a>
    
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="display: flex; gap: 10px; align-items: center;">
            <span style="font-size: 0.85rem; font-weight: 600; color: #555;">Template:</span>
            <button onclick="switchTemplate('classic')" class="template-btn <?= $chosen_template === 'classic' ? 'active' : '' ?>" data-template="classic">Classic</button>
            <button onclick="switchTemplate('professional')" class="template-btn <?= $chosen_template === 'professional' ? 'active' : '' ?>" data-template="professional">Professional</button>
            <button onclick="switchTemplate('academic')" class="template-btn <?= $chosen_template === 'academic' ? 'active' : '' ?>" data-template="academic">Academic</button>
        </div>
        
        <button class="btn-download" onclick="window.print()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><rect x="6" y="14" width="12" height="8"/></svg>
            Download PDF
        </button>
    </div>
</div>

            <!-- CV Paper -->
           <?php $edu = $cv_data['education'][0] ?? []; ?>

<div class="cv-wrapper">
    <div class="cv-paper" id="cv-paper">

        <?php if ($preview_error): ?>
            <?php preview_render_error($preview_error); ?>
        <?php elseif ($cv_data['is_empty']): ?>
            <div class="cv-header">
                <h1 class="cv-name">YOUR NAME</h1>
            </div>
            <?php preview_render_empty(); ?>
        <?php else: ?>

            <!-- HEADER (Same for all templates) -->
            <div class="cv-header" id="section-personal">
                <h1 class="cv-name">
                    <?= $cv_data['personal']['full_name'] ?: 'YOUR NAME' ?>
                </h1>
                <?php $p = $cv_data['personal']; ?>
                <?php if ($p['email'] || $p['phone'] || $p['address'] || $p['linkedin_url']): ?>
                <div class="cv-contact-row">
                    <?php if ($p['address']): ?>
                    <span class="cv-contact-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?= $p['address'] ?>
                    </span>
                    <?php endif; ?>
                                        <?php if ($p['phone']): ?>
                    <span class="cv-contact-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.38 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l1.02-.93a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <?= $p['phone'] ?>
                    </span>
                    <?php endif; ?>
                    <?php if ($p['email']): ?>
                    <span class="cv-contact-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <?= $p['email'] ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- ACADEMIC TEMPLATE: Summary comes after Education -->
            <?php if ($chosen_template !== 'academic' && $p['summary']): ?>
            <div class="cv-section" id="section-summary">
                <div class="cv-section-title">Professional Summary</div>
                <div class="cv-section-rule"></div>
                <p class="cv-summary"><?= $p['summary'] ?></p>
            </div>
            <?php endif; ?>

            <!-- EDUCATION -->
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
                                    <?php if ($edu['grade']): ?>
                                        <span style="font-weight:400; color:#666;">| GPA: <?= $edu['grade'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="cv-entry-subtitle"><?= $edu['institution'] ?></div>
                            </div>
                            <div class="cv-entry-date">
                                <?= $edu['start'] ?><?= $edu['end'] ? ' – ' . $edu['end'] : '' ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- ACADEMIC TEMPLATE SECTIONS -->
            <?php if ($chosen_template === 'academic'): ?>
                <?php if (!empty($edu['relevant_courses'])): ?>
                <div class="cv-section">
                    <div class="cv-section-title">Relevant Coursework</div>
                    <div class="cv-section-rule"></div>
                    <p class="cv-summary"><?= nl2br(htmlspecialchars($edu['relevant_courses'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($edu['honors_achievements'])): ?>
                <div class="cv-section">
                    <div class="cv-section-title">Honors & Achievements</div>
                    <div class="cv-section-rule"></div>
                    <p class="cv-summary"><?= nl2br(htmlspecialchars($edu['honors_achievements'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($edu['societies'])): ?>
                <div class="cv-section">
                    <div class="cv-section-title">Societies & Extracurriculars</div>
                    <div class="cv-section-rule"></div>
                    <p class="cv-summary"><?= nl2br(htmlspecialchars($edu['societies'])) ?></p>
                </div>
                <?php endif; ?>

                <!-- Summary for Academic template -->
                <?php if ($p['summary']): ?>
                <div class="cv-section">
                    <div class="cv-section-title">Professional Summary</div>
                    <div class="cv-section-rule"></div>
                    <p class="cv-summary"><?= $p['summary'] ?></p>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- EXPERIENCE (Classic & Academic) or RELEVANT EXPERIENCE (Professional) -->
            <?php if (!empty($cv_data['experience'])): ?>
            <div class="cv-section" id="section-experience">
                <div class="cv-section-title">
                    <?= $chosen_template === 'professional' ? 'Relevant Experience' : 'Work Experience' ?>
                </div>
                <div class="cv-section-rule"></div>
                <?php foreach ($cv_data['experience'] as $exp): ?>
                <div class="cv-entry">
                    <div class="cv-entry-header">
                        <div>
                            <div class="cv-entry-title"><?= $exp['job_title'] ?></div>
                            <div class="cv-entry-subtitle"><?= $exp['company'] ?></div>
                        </div>
                        <div class="cv-entry-date">
                            <?= $exp['start'] ?><?= $exp['end'] ? ' – ' . $exp['end'] : ' – Present' ?>
                        </div>
                    </div>
                    <?php if ($exp['description']): ?>
                    <p class="cv-entry-desc"><?= $exp['description'] ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- VOLUNTEER EXPERIENCE (Classic Template Only) -->
            <?php if ($chosen_template === 'classic' && !empty($cv_data['volunteer'])): ?>
            <div class="cv-section">
                <div class="cv-section-title">Volunteer Experience</div>
                <div class="cv-section-rule"></div>
                <?php foreach ($cv_data['volunteer'] as $vol): ?>
                <div class="cv-entry">
                    <div class="cv-entry-header">
                        <div>
                            <div class="cv-entry-title"><?= $vol['role_title'] ?></div>
                            <div class="cv-entry-subtitle"><?= $vol['organization'] ?></div>
                        </div>
                        <div class="cv-entry-date">
                            <?= $vol['start'] ?><?= $vol['end'] ? ' – ' . $vol['end'] : ' – Present' ?>
                        </div>
                    </div>
                    <?php if ($vol['description']): ?>
                    <p class="cv-entry-desc"><?= $vol['description'] ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- SKILLS -->
            <div class="cv-section" id="section-skills">
                <div class="cv-section-title">Skills &amp; Competencies</div>
                <div class="cv-section-rule"></div>
                <?php if (empty($cv_data['skills'])): ?>
                    <?php preview_render_section_empty('skills'); ?>
                <?php else: ?>
                <ul class="cv-skills-list">
                    <?php foreach ($cv_data['skills'] as $skill): ?>
                    <li><?= $skill ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>
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

// ── TEMPLATE SWITCHER LOGIC ──
function switchTemplate(templateName) {
    // 1. Update active button styling
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.template === templateName);
    });
    
    // 2. Swap the CSS file instantly on the screen
    const templateLink = document.querySelector('link[href*="css/templates/"]');
    if (templateLink) {
        templateLink.href = 'css/templates/' + templateName + '.css?v=' + Date.now();
    }
    
    // 3. Save the choice to the database in the background
    fetch('includes/save_template.inc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'template=' + templateName + '&user_id=<?= $_SESSION["user_id"] ?>'
    })
    .then(response => response.text())
    .then(data => {
        console.log('Template saved to database:', data);
    })
    .catch(error => {
        console.error('Error saving template:', error);
    });
}
function toggleMobileMenu() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.querySelector('.sidebar-overlay').classList.toggle('open');
}
</script>

</body>
</html>
