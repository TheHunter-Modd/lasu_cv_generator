<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LASU CV Generator</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_io/favicon-16x16.png">
    <link rel="shortcut icon" href="assets/favicon_io/favicon.ico">
    <link rel="manifest" href="assets/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="css/stylelog.css">
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <img src="assets/file-text.svg" alt="logo">
            <div class="text">
                <h3>LASU CV Generator</h3>
                <small>ATS-Compliant Resume Builder</small>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">

            <!-- LEFT SIDE -->
            <div class="left">
                <div class="left-content">
                    <h4>LASU CV.</h4>
                    <h1>Career<br>Academy</h1>
                    <p>
                        Build a professional, ATS-compliant CV tailored for LASU students.
                        Generate clean and structured resumes that pass recruiter systems.
                    </p>
                </div>
                <div class="image1">
                    <img src="assets/shubham-dhage-4APmM2jUr_8-unsplash.jpg" alt="CV">
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="right">
                <div class="right-content">
                    <h2>Forgot Password?</h2>
                    <p class="sub">Enter your matric number to reset your password.</p>

                    <form action="includes/forgot_password.inc.php" method="post">

                        <input type="text" name="matric_number" placeholder="Matric Number" required>

                        <button class="btn" type="submit">Continue</button>

                    </form>

                    <div class="error-box">
                        <?php check_forgot_errors(); ?>
                    </div>

                    <div class="login-link" style="margin-top: 16px;">
                        Remember your password? <a href="login.php">Log In</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>© 2026 Lagos State University. Built for student career success.</p>
        <p>Generated CVs are optimized for Applicant Tracking Systems (ATS).</p>
    </div>

</body>
</html>