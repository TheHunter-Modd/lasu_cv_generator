<?php
require_once 'includes/config_session.inc.php';

// 🔐 Protect page
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
    <link rel="apple-touch-icon" sizes="180x180" href="assets\favicon_io\apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets\favicon_io\favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets\favicon_io\favicon-16x16.png">
    <link rel="shortcut icon" href="assets\favicon_io\favicon.ico" />
    <link rel="manifest" href="assets\favicon_io\site.webmanifest">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="logo">lasu<span>cv.</span></h2>

        <ul>
            <li class="active">Dashboard</li>
            <li>Builder</li>
            <li>Preview CV</li>
        </ul>

        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

       <!-- TOP NAVIGATION -->
<div class="top-nav">

    <!-- LEFT: Tabs -->
    <div class="tabs">
        <button>Personal</button>
        <button>Academic</button>
        <button class="active">All Sections</button>
        <button>Reports</button>
    </div>

    <!-- RIGHT: Actions -->
    <div class="actions">

        <!-- SEARCH -->
        <input type="text" placeholder="Search task, Meeting, Projects...">

        <!-- ICONS -->
        <div class="icons">
            <span>📅</span>
            <span>🔔</span>
            <span>⚙️</span>
        </div>

        <!-- PROFILE -->
        <div class="profile">
            <div class="avatar">V</div>
            <div class="info">
                <strong><?php echo $_SESSION["user_matric"]; ?></strong>
                <small>LASU Student</small>
            </div>
        </div>

    </div>

</div>

<!-- HEADER TEXT -->
<div class="page-header">
    <p class="sub">Manage and track your CV</p>
    <h1>CV Dashboard</h1>
</div>

        <!-- SECTIONS -->
        <div class="sections">

            <h3>My Sections</h3>

            <div class="section-card blue">
                <h4>Personal Info</h4>
                <p>Basic contact details</p>
            </div>

            <div class="section-card orange">
                <h4>Professional Summary</h4>
                <p>Your career objective</p>
            </div>

            <div class="section-card pink">
                <h4>Education History</h4>
                <p>Academic background</p>
            </div>

            <div class="section-card green">
                <h4>Work Experience</h4>
                <p>Past roles and duties</p>
            </div>

        </div>

        <!-- ANALYTICS -->
        <div class="analytics">

            <div class="card">
                <h4>Profile Overview</h4>
                <div class="circle">75%</div>
            </div>

            <div class="card">
                <h4>ATS Score Trend</h4>
                <div class="graph">Graph Placeholder</div>
            </div>

        </div>

        <!-- PROGRESS -->
        <div class="progress">

            <h4>Resume Vitals</h4>

            <div class="bar">
                <span>Formatting</span>
                <div class="progress-line"><div style="width:85%"></div></div>
            </div>

            <div class="bar">
                <span>Keywords</span>
                <div class="progress-line"><div style="width:60%"></div></div>
            </div>

            <div class="bar">
                <span>Readability</span>
                <div class="progress-line"><div style="width:90%"></div></div>
            </div>

        </div>

    </div>
</div>

</body>
</html>