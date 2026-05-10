<?php
require_once 'includes/config_session.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
}

 $showLoginToast = false;
if (isset($_SESSION["login_success"])) {
    unset($_SESSION["login_success"]);
    $showLoginToast = true;
}

require_once 'includes/dbh.inc.php';
require_once 'includes/settings_model.inc.php';
 $_dashboard_user = get_user_by_id($pdo, $_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - LASU CV</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/mobile-responsive.css">
</head>
<body>

<?php if ($showLoginToast): ?>
<div id="login-toast" class="toast-toast">
    <div class="toast-icon">✓</div>
    <div class="toast-body">
        <strong>Login Successful!</strong>
        <span>Welcome back! You are now signed in.</span>
    </div>
    <button class="toast-close" onclick="document.getElementById('login-toast').remove()">×</button>
</div>
<script>
(function() {
    var toast = document.getElementById('login-toast');
    if (toast) {
        setTimeout(function() {
            toast.classList.add('toast-fade-out');
            setTimeout(function() {
                if (toast.parentNode) toast.remove();
            }, 400);
        }, 4000);
    }
})();
</script>
<?php endif; ?>

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
            <li class="active">
                <img src="assets/layout-dashboard.svg" alt="">
                <span>Dashboard</span>
            </li>
            <li>
                <a href="builder.php">
                    <img src="assets/file-pen.svg" alt="">
                    <span>Builder</span>
                </a>
            </li>
            <li>
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
                    <input type="text" placeholder="Search task, meeting, projects...">
                    <div class="icons">
                       <!--<span><img src="assets/calendar.svg"></span>
                        <span><img src="assets/bell-dot.svg"></span>-->
                        <a href="settings.php" style="text-decoration:none;display:flex;align-items:center;"><img src="assets/settings.svg" style="width:20px;height:20px;" alt="Settings"></a>
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

            <div class="page-header">
                <p class="sub">Manage and track your CV</p>
                <h1>CV Dashboard</h1>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- SECTIONS -->
            <div class="sections">
                <div class="section-header">
                    <h3>My Sections</h3>
                    <span class="badge">5 Total Sections</span>
                </div>

                <div class="section-card blue">
                    <div class="section-content">
                        <div class="icon-box"><img src="assets/user.svg" alt=""></div>
                        <h4>Personal Info</h4>
                        <p>Basic contact details</p>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card orange">
                    <div class="section-content">
                        <div class="icon-box"><img src="assets/file-text.svg" alt=""></div>
                        <div class="text">
                            <h4>Professional Summary</h4>
                            <p>Your career objective</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card pink">
                    <div class="section-content">
                        <div class="icon-box"><img src="assets/graduation-cap.svg" alt=""></div>
                        <div class="text">
                            <h4>Education History</h4>
                            <p>Academic background</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card green">
                    <div class="section-content">
                        <div class="icon-box"><img src="assets/briefcase.svg" alt=""></div>
                        <div class="text">
                            <h4>Work Experience</h4>
                            <p>Past roles and duties</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card purple">
                    <div class="section-content">
                        <div class="icon-box"><img src="assets/code.svg" alt=""></div>
                        <div class="text">
                            <h4>Skills & Tools</h4>
                            <p>Technical proficiencies</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>
            </div>

            <!-- ANALYTICS -->
            <div class="analytics">
                <div class="card">
                    <h4>Profile Overview</h4>
                    <div class="donut-wrapper">
                        <div class="donut"></div>
                    </div>
                    <div class="legend">
                        <span class="dot orange"></span> Pending: 5
                        <span class="dot blue"></span> Completed: 0
                    </div>
                </div>
                <div class="card">
                    <h4>ATS Score Trend</h4>
                    <div class="graph"></div>
                </div>
            </div>

            <!-- PROGRESS -->
            <div class="progress">
                <h4>Resume Vitals</h4>
                <div class="bar">
                    <span>Formatting</span>
                    <div class="progress-line"><div class="bar-purple" style="width:85%"></div></div>
                    <small>85 / 100</small>
                </div>
                <div class="bar">
                    <span>Keywords</span>
                    <div class="progress-line"><div class="bar-red" style="width:60%"></div></div>
                    <small>60 / 100</small>
                </div>
                <div class="bar">
                    <span>Readability</span>
                    <div class="progress-line"><div class="bar-blue" style="width:90%"></div></div>
                    <small>90 / 100</small>
                </div>
                <div class="bar">
                    <span>Length</span>
                    <div class="progress-line"><div class="bar-green" style="width:100%"></div></div>
                    <small>100 / 100</small>
                </div>
                <div class="bar">
                    <span>Impact</span>
                    <div class="progress-line"><div class="bar-yellow" style="width:40%"></div></div>
                    <small>40 / 100</small>
                </div>
            </div>

            <!-- NEXT ACTIONS -->
            <div class="card actions-card">
                <div class="card-header">
                    <h4>Next Actions</h4>
                    <span class="icon"><img src="assets/calendar.svg" alt="Calendar"></span>
                </div>
                <div class="action-item">
                    <div>
                        <small>Recommended</small>
                        <h5>Add 3 Skills</h5>
                    </div>
                    <span class="arrow">↗</span>
                </div>
                <div class="action-item">
                    <div>
                        <small>Required</small>
                        <h5>Review Summary</h5>
                    </div>
                    <span class="arrow">↗</span>
                </div>
                <p class="see-all">See All Actions ></p>
            </div>

            <!-- PRO TIPS -->
            <div class="card tips-card">
                <div class="card-header">
                    <h4>Pro Tips</h4>
                    <span class="icon"><img src="assets/settings-2.svg" alt="settings-2"></span>
                </div>
                <div class="tip-item">
                    <div class="tip-icon yellow">⚡</div>
                    <div>
                        <h5>Action Verbs</h5>
                        <p>Use strong verbs to start your bullet points.</p>
                        <button>Learn More ></button>
                    </div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon green">✔</div>
                    <div>
                        <h5>Quantify Results</h5>
                        <p>Add numbers to show your impact.</p>
                        <button>Learn More ></button>
                    </div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon blue">📄</div>
                    <div>
                        <h5>Keep it Clean</h5>
                        <p>ATS systems prefer simple formatting.</p>
                        <button>Learn More ></button>
                    </div>
                </div>
            </div>

        </div><!-- /.content -->
    </div><!-- /.main -->
</div><!-- /.dashboard -->

<script>
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

// Close on outside click
document.addEventListener('click', function (e) {
    var wrap = document.getElementById('profileWrap');
    if (wrap && !wrap.contains(e.target)) {
        closeProfile();
    }
});

// Close on Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeProfile();
});
</script>

</body>
</html>