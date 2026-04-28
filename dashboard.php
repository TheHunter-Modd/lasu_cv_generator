<?php
require_once 'includes/config_session.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - LASU CV</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">
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
                <img src="assets/file-pen.svg" alt="">
                <span>Builder</span>
            </li>
            
            <li>
                <img src="assets/eye.svg" alt="">
                <span>Preview CV</span>
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

                <div class="tabs">
                    <button>Personal</button>
                    <button>Academic</button>
                    <button class="active">All Sections</button>
                    <button>Reports</button>
                </div>

                <div class="actions">
                    <input type="text" placeholder="Search task, meeting, projects...">

                    <div class="icons">
                        <span><img src="assets\calendar.svg"></span>
                        <span><img src="assets\bell-dot.svg"></span>
                        <span><img src="assets\settings.svg"></span>
                    </div>

                    <div class="profile">
                        <div class="avatar">V</div>
                        <div class="info">
                            <strong><?php echo $_SESSION["user_matric"]; ?></strong>
                            <small>LASU Student</small>
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
                    <div class="icon-box">
                        <img src="assets/user.svg" alt="">
                    </div>
                    <h4>Personal Info</h4>
                    <p>Basic contact details</p>
                </div>
                <input type="checkbox">
            </div>

                <div class="section-card orange">
                    <div class="section-content">
                        <div class="icon-box">
                            <img src="assets/file-text.svg" alt="">
                        </div>
                        <div class="text">
                            <h4>Professional Summary</h4>
                            <p>Your career objective</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card pink">
                    <div class="section-content">
                        <div class="icon-box">
                            <img src="assets/graduation-cap.svg" alt="">
                        </div>
                        <div class="text">
                            <h4>Education History</h4>
                            <p>Academic background</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card green">
                    <div class="section-content">
                        <div class="icon-box">
                            <img src="assets/briefcase.svg" alt="">
                        </div>
                        <div class="text">
                            <h4>Work Experience</h4>
                            <p>Past roles and duties</p>
                        </div>
                    </div>
                    <input type="checkbox">
                </div>

                <div class="section-card purple">
                    <div class="section-content">
                        <div class="icon-box">
                            <img src="assets/code.svg" alt="">
                        </div>
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
        </div>
    </div>
</div>

</body>
</html>