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
<title>Builder - LASU CV</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/preview.css"> <!-- NEW -->
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
            <li>
                <a href="dashboard.php">
                    <img src="assets/layout-dashboard.svg">
                    <span>Dashboard</span>
                </a>
            </li>

            <li >
                <a href="builder.php">
                    <img src="assets/file-pen.svg">
                    <span>Builder</span>
                </a>
            </li>

            <li class="active">
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

        <!-- HEADER (reuse yours) -->
        <div class="header-area">
            <div class="top-nav">
                <div class="tabs">
                    <button>Personal</button>
                    <button>Academic</button>
                    <button class="active">All Sections</button>
                    <button>Reports</button>
                </div>

                <div class="actions">
                    <input type="text" placeholder="Search...">

                    <div class="icons">
                        <span><img src="assets/calendar.svg"></span>
                        <span><img src="assets/bell-dot.svg"></span>
                        <span><img src="assets/settings.svg"></span>
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
        </div>

        

    </div>
</div>

</body>
</html>