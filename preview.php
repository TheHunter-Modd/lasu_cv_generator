<?php
// ── Bootstrap: controller sets $cv_data, $active_tab, $preview_error ──
require_once 'includes/preview_contr.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/settings_model.inc.php';

 $_dashboard_user = get_user_by_id($pdo, $_SESSION["user_id"]);
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
    $chosen_template = $cv_data['personal']['template_choice'] ?? 'classic';
    $allowed_templates = ['classic', 'professional', 'academic'];
    if (!in_array($chosen_template, $allowed_templates)) {
        $chosen_template = 'classic';
    }
?>
<link rel="stylesheet" href="css/preview.css?v=5">
<link rel="stylesheet" href="css/templates/<?= $chosen_template ?>.css?v=2">
<link rel="stylesheet" href="css/mobile-responsive.css">
</head>
<body>

<div class="dashboard">
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileMenu()"></div>

    <!-- ── SIDEBAR ─────────────────────────────────────────── -->
    <div class="sidebar" id="appSidebar">
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
                <button class="mobile-menu-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
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
                        <!--<span><img src="assets/calendar.svg" alt=""></span>
                        <span><img src="assets/bell-dot.svg" alt=""></span>
                        <a href="settings.php" style="text-decoration:none;display:flex;align-items:center;"><img src="assets/settings.svg" style="width:20px;height:20px;" alt="Settings"></a>-->
                    </div>
                    <div class="profile-wrap" id="profileWrap">
                        <div class="profile" onclick="toggleProfile()" style="cursor:pointer;">
                            <?php if (!empty($_dashboard_user["avatar"])): ?>
                                <img src="<?php echo htmlspecialchars($_dashboard_user["avatar"]); ?>" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" alt="Avatar">
                            <?php else: ?>
                                <div class="avatar"><?php echo strtoupper(substr($_SESSION["user_matric"], 0, 1)); ?></div>
                            <?php endif; ?>
                            <div class="info">
                                <strong><?php echo $_SESSION["user_matric"]; ?></strong>
                                <small>LASU Student</small>
                            </div>
                            <svg class="chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="pd-header">
                                <?php if (!empty($_dashboard_user["avatar"])): ?>
                                    <img src="<?php echo htmlspecialchars($_dashboard_user["avatar"]); ?>" style="width:42px;height:42px;border-radius:50%;object-fit:cover;box-shadow:0 2px 8px rgba(99,102,241,0.25);" alt="Avatar">
                                <?php else: ?>
                                    <div class="pd-avatar"><?php echo strtoupper(substr($_SESSION["user_matric"], 0, 1)); ?></div>
                                <?php endif; ?>
                                <div class="pd-info">
                                    <strong><?php echo htmlspecialchars($_SESSION["user_matric"]); ?></strong>
                                    <small>LASU Student</small>
                                </div>
                            </div>
                            <div class="pd-links">
                                <a href="dashboard.php" class="pd-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                    <span>Dashboard</span>
                                    <kbd>D</kbd>
                                </a>
                                <a href="builder.php" class="pd-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    <span>Edit CV</span>
                                    <kbd>E</kbd>
                                </a>
                                <a href="preview.php" class="pd-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Preview CV</span>
                                    <kbd>P</kbd>
                                </a>
                                <a href="settings.php" class="pd-item">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                    <span>Settings</span>
                                    <kbd>S</kbd>
                                </a>
                            </div>
                            <div class="pd-divider"></div>
                            <a href="includes/logout.inc.php" class="pd-item danger">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                <span>Log Out</span>
                            </a>
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

                <div class="toolbar-right">
                    <div class="template-switcher">
                        <span class="template-label">Template:</span>
                        <button onclick="switchTemplate('classic')" class="template-btn <?= $chosen_template === 'classic' ? 'active' : '' ?>" data-template="classic">Classic</button>
                        <button onclick="switchTemplate('professional')" class="template-btn <?= $chosen_template === 'professional' ? 'active' : '' ?>" data-template="professional">Professional</button>
                        <button onclick="switchTemplate('academic')" class="template-btn <?= $chosen_template === 'academic' ? 'active' : '' ?>" data-template="academic">Academic</button>
                    </div>

                    <button class="btn-download" onclick="printCV()">
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
                <?php
                  $contact_items = [];

                  if (!empty($p['address']) && $p['address'] !== $p['email'] && $p['address'] !== $p['phone']) {
                      $contact_items[] = [
                          'icon' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
                          'text' => $p['address']
                      ];
                  }
                  if (!empty($p['phone'])) {
                      $contact_items[] = [
                          'icon' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.38 2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l1.02-.93a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
                          'text' => $p['phone']
                      ];
                  }
                  if (!empty($p['email'])) {
                      $contact_items[] = [
                          'icon' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
                          'text' => $p['email']
                      ];
                  }
                  if (!empty($p['linkedin_url'])) {
                      $contact_items[] = [
                          'icon' => '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
                          'text' => $p['linkedin_url']
                      ];
                  }
                ?>
                <?php if (!empty($contact_items)): ?>
                <div class="cv-contact-row">
                    <?php foreach ($contact_items as $item): ?>
                    <span class="cv-contact-item">
                        <?= $item['icon'] ?>
                        <?= htmlspecialchars($item['text']) ?>
                    </span>
                    <?php endforeach; ?>
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

            <!-- EXPERIENCE -->
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

<script src="js/mobile.js"></script>
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

function switchTemplate(templateName) {
    document.querySelectorAll('.template-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.template === templateName);
    });

    var btnClicked = document.querySelector('.template-btn[data-template="' + templateName + '"]');
    if (btnClicked) {
        btnClicked.textContent = 'Switching...';
    }

    fetch('includes/save_template.inc.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'template=' + templateName + '&user_id=<?= $_SESSION["user_id"] ?>'
    })
    .then(function (response) {
        var url = new URL(window.location);
        url.searchParams.set('template', templateName);
        url.searchParams.set('t', Date.now());
        window.location.href = url.toString();
    })
    .catch(function (error) {
        console.error('Error saving template:', error);
        var url = new URL(window.location);
        url.searchParams.set('template', templateName);
        url.searchParams.set('t', Date.now());
        window.location.href = url.toString();
    });
}

function toggleMobileMenu() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.querySelector('.sidebar-overlay').classList.toggle('open');
}

/* ── Profile dropdown ── */
function toggleProfile() {
    var wrap = document.getElementById('profileWrap');
    var dd   = document.getElementById('profileDropdown');
    if (!wrap || !dd) return;

    var isOpen = dd.classList.toggle('open');
    wrap.classList.toggle('open', isOpen);
}

function closeProfile() {
    var wrap = document.getElementById('profileWrap');
    var dd   = document.getElementById('profileDropdown');
    if (!wrap || !dd) return;
    dd.classList.remove('open');
    wrap.classList.remove('open');
}

document.addEventListener('click', function (e) {
    var wrap = document.getElementById('profileWrap');
    if (wrap && !wrap.contains(e.target)) {
        closeProfile();
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeProfile();
});
</script>

</body>
</html>