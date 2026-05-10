<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/builder_view.inc.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/settings_model.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
}

 $_dashboard_user = get_user_by_id($pdo, $_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Builder - LASU CV</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/builder.css">
<link rel="stylesheet" href="css/mobile-responsive.css">
</head>
<body>

<div class="dashboard">

    <!-- OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="appSidebar">
        <h2 class="logo">
            <img src="assets/file-text.svg">
            <span>lasucv.</span>
        </h2>

        <ul class="menu">
            <li>
                <a href="dashboard.php">
                    <img src="assets/layout-dashboard.svg">
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="builder.php">
                    <img src="assets/file-pen.svg">
                    <span>Builder</span>
                </a>
            </li>
            <li>
                <a href="preview.php">
                    <img src="assets/eye.svg">
                    <span>Preview CV</span>
                </a>
            </li>
        </ul>

        <a href="includes/logout.inc.php" class="logout">
            <img src="assets/log-out.svg">
            <span>Logout</span>
        </a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <div class="header-area">
            <div class="top-nav">

                <!-- HAMBURGER -->
                <button class="mobile-menu-btn" id="hamburgerBtn"
                        onclick="toggleSidebar()"
                        aria-label="Open navigation menu"
                        aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- TABS -->
                <div class="tabs">
                    <button>Personal</button>
                    <button>Academic</button>
                    <button class="active">All Sections</button>
                    <button>Reports</button>
                </div>

                <!-- ACTIONS -->
                <div class="actions">
                    <input type="text" placeholder="Search...">
                    <div class="icons">
                        <!--<span><img src="assets/calendar.svg"></span>
                        <span><img src="assets/bell-dot.svg"></span>
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

        <!-- BUILDER CONTENT -->
        <div class="builder-container">

            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>

            <!-- STEP NAV -->
            <div class="builder-steps">
                <span class="step active" data-step="personal">Personal</span>
                <span class="step" data-step="summary">Summary</span>
                <span class="step" data-step="education">Education</span>
                <span class="step" data-step="experience">Experience</span>
                <span class="step" data-step="skills">Skills</span>
                <span class="step" data-step="volunteer">Volunteer</span>
                <span class="step" data-step="academic">Academic</span>
            </div>

            <!-- FORM CARD -->
            <div class="builder-card">
                <form action="includes/builder.inc.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <!-- PERSONAL -->
                    <div class="form-section active" id="personal">
                        <h2>Personal Information</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Full Name *</label>
                                <input type="text" name="full_name" placeholder="e.g. John Doe">
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" placeholder="john@example.com">
                            </div>
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="text" name="phone" placeholder="+234...">
                            </div>
                            <div class="form-group">
                                <label>LinkedIn / Portfolio URL (Optional)</label>
                                <input type="text" name="linkedin_url" placeholder="linkedin.com/in/...">
                            </div>
                            <div class="form-group full">
                                <label>Address *</label>
                                <input type="text" name="address" placeholder="City, Country">
                            </div>
                        </div>
                    </div>

                    <!-- SUMMARY -->
                    <div class="form-section" id="summary">
                        <h2>Professional Summary</h2>
                        <p>Write 2-4 sentences highlighting your key skills, experiences, and career goals.</p>
                        <textarea name="professional_summary" placeholder="A highly motivated computer science student with a passion for building scalable web applications..."></textarea>
                    </div>

                    <!-- EDUCATION -->
                    <div class="form-section" id="education">
                        <h2>Education</h2>
                        <p>Add your academic background starting from the most recent.</p>
                        <div class="form-grid">
                            <div class="form-group full">
                                <label>Institution *</label>
                                <input type="text" name="institution" placeholder="e.g. Lagos State University (LASU)">
                            </div>
                            <div class="form-group">
                                <label>Degree</label>
                                <input type="text" name="degree" placeholder="e.g. Bachelor of Science">
                            </div>
                            <div class="form-group">
                                <label>Field of Study</label>
                                <input type="text" name="field_of_study" placeholder="e.g. Computer Science">
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" name="edu_start_date" placeholder="e.g. 2020">
                            </div>
                            <div class="form-group">
                                <label>End Date (or Expected)</label>
                                <input type="text" name="edu_end_date" placeholder="e.g. 2024">
                            </div>
                            <div class="form-group full">
                                <label>Grade / CGPA (Optional)</label>
                                <input type="text" name="grade_cgpa" placeholder="e.g. 3.8/4.0">
                            </div>
                        </div>
                    </div>

                    <!-- EXPERIENCE -->
                    <div class="form-section" id="experience">
                        <h2>Work Experience</h2>
                        <p>Include internships, volunteer work, or part-time jobs.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Company / Organization</label>
                                <input type="text" name="company" placeholder="e.g. Google (or LASU IT Dept)">
                            </div>
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" name="job_title" placeholder="e.g. Software Engineering Intern">
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" name="exp_start_date" placeholder="e.g. Jun 2022">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" name="exp_end_date" placeholder="e.g. Present">
                            </div>
                            <div class="form-group full">
                                <label>Description</label>
                                <textarea name="description" placeholder="• Developed a new feature that increased user retention by 20%&#10;• Collaborated with a team of 5 engineers to deploy..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SKILLS -->
                    <div class="form-section" id="skills">
                        <h2>Skills & Competencies</h2>
                        <p>Add technical skills, tools, and soft skills.</p>
                        <div class="skill-input">
                            <input type="text" id="skillInput" placeholder="e.g. JavaScript">
                            <button type="button">+ Add</button>
                        </div>
                        <div class="skill-box">
                            <p>No skills added yet.</p>
                        </div>
                    </div>

                    <!-- VOLUNTEER -->
                    <div class="form-section" id="volunteer">
                        <h2>Volunteer Experience <small style="color:#888;">(Optional)</small></h2>
                        <p>Add volunteer work, community service, or extracurricular activities.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Organization</label>
                                <input type="text" name="vol_org" placeholder="e.g. LASU Red Cross Society">
                            </div>
                            <div class="form-group">
                                <label>Role / Title</label>
                                <input type="text" name="vol_role" placeholder="e.g. Volunteer Coordinator">
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" name="vol_start" placeholder="e.g. Jan 2023">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" name="vol_end" placeholder="e.g. Present">
                            </div>
                            <div class="form-group full">
                                <label>Description</label>
                                <textarea name="vol_description" placeholder="• Organized community outreach programs reaching 500+ students..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ACADEMIC -->
                    <div class="form-section" id="academic">
                        <h2>Academic Details <small style="color:#888;">(Optional)</small></h2>
                        <p>Add relevant coursework, honors, and societies for academic-focused CVs.</p>
                        <div class="form-grid">
                            <div class="form-group full">
                                <label>Relevant Courses</label>
                                <textarea name="relevant_courses" placeholder="Data Structures & Algorithms, Database Management Systems..."></textarea>
                            </div>
                            <div class="form-group full">
                                <label>Honors & Achievements</label>
                                <textarea name="honors_achievements" placeholder="• Dean's List (2023, 2024)&#10;• Best Project Award - Final Year"></textarea>
                            </div>
                            <div class="form-group full">
                                <label>Societies & Extracurriculars</label>
                                <textarea name="societies" placeholder="• Member, LASU Computer Science Society (2022-Present)"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="builder-footer">
                        <button type="button" class="back-btn">Back</button>
                        <button type="submit" class="finish-btn">Save & Continue</button>
                    </div>

                </form>
            </div><!-- /.builder-card -->
        </div><!-- /.builder-container -->
    </div><!-- /.main -->
</div><!-- /.dashboard -->

<script>
/* ── Builder step navigation ── */
const steps     = document.querySelectorAll(".step");
const sections  = document.querySelectorAll(".form-section");
const nextBtn   = document.querySelector(".finish-btn");
const backBtn   = document.querySelector(".back-btn");
const stepOrder = ["personal","summary","education","experience","skills","volunteer","academic"];
let currentStep = 0;

function showStep(index) {
    steps.forEach(s   => s.classList.remove("active"));
    sections.forEach(s => s.classList.remove("active"));
    steps[index].classList.add("active");
    document.getElementById(stepOrder[index]).classList.add("active");
    currentStep = index;
    nextBtn.textContent = (currentStep === stepOrder.length - 1) ? "Save & Finish" : "Save & Continue";
}

steps.forEach((step, i) => step.addEventListener("click", () => showStep(i)));

/* ── Skills ── */
const addSkillBtn = document.querySelector(".skill-input button");
const skillInput  = document.querySelector(".skill-input input");
const skillBox    = document.querySelector(".skill-box");
const form        = document.querySelector("form");

addSkillBtn.addEventListener("click", () => {
    const val = skillInput.value.trim();
    if (!val) return;
    if (skillBox.querySelector("p")) skillBox.innerHTML = "";
    const tag = document.createElement("div");
    tag.className = "skill-tag-item";
    tag.innerHTML = `<span>${val}</span><button type="button" class="remove-skill" onclick="this.parentElement.remove()">×</button>`;
    skillBox.appendChild(tag);
    const hidden = document.createElement("input");
    hidden.type = "hidden"; hidden.name = "skills[]"; hidden.value = val;
    form.appendChild(hidden);
    skillInput.value = "";
    skillInput.focus();
});

nextBtn.addEventListener("click", (e) => {
    if (currentStep < stepOrder.length - 1) { e.preventDefault(); showStep(currentStep + 1); }
});

backBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (currentStep > 0) showStep(currentStep - 1);
});

showStep(0);

/* ── Sidebar toggle ── */
function toggleSidebar() {
    var sidebar = document.getElementById('appSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var btn     = document.getElementById('hamburgerBtn');

    var isOpen = sidebar.classList.toggle('open');
    overlay.classList.toggle('open');

    if (btn) {
        btn.classList.toggle('open', isOpen);
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    document.body.style.overflow = isOpen ? 'hidden' : '';
}

document.addEventListener('DOMContentLoaded', function () {
    var links = document.querySelectorAll('#appSidebar a, #appSidebar .logout');
    links.forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                var sidebar = document.getElementById('appSidebar');
                var overlay = document.getElementById('sidebarOverlay');
                var btn     = document.getElementById('hamburgerBtn');
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                if (btn) { btn.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); }
                document.body.style.overflow = '';
            }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var sidebar = document.getElementById('appSidebar');
            if (sidebar && sidebar.classList.contains('open')) toggleSidebar();
        }
    });
});

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