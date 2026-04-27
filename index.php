<?php
session_start();
require_once 'includes/register_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LASU CV Generator</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets\favicon_io\apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets\favicon_io\favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets\favicon_io\favicon-16x16.png">
    <link rel="shortcut icon" href="assets\favicon_io\favicon.ico" />
    <link rel="manifest" href="assets\favicon_io\site.webmanifest">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
    <!-- HEADER -->
    <div class="header">
    <div class="logo">
        <img src="assets/favicon_io/favicon-32x32.png" alt="logo">

        <div class="text">
            <h3>LASU CV Generator</h3>
            <small>ATS-Compliant Resume Builder</small>
        </div>
    </div>
</div>

    <!-- MAIN -->
    <div class="container">
        <div class="card">

            <!-- LEFT -->
            <div class="left">
                <h4>LASU CV.</h4>
                <h1>Career Academy</h1>
                <p>
                    Build a professional, ATS-compliant CV tailored for LASU students.
                    Generate clean and structured resumes that pass recruiter systems.
                </p>

                <div class="image1">
                    <img src="assets\shubham-dhage-4APmM2jUr_8-unsplash.jpg" alt="CV" width="350px" height="170px">
                </div>
            </div>

            <!-- RIGHT -->
            <div class="right">
                <h2>Welcome to LASU CV.</h2>
                <p>Let’s help you get started.</p>

                <div class="login-link">
                    Already have an account? <a href="login.php">Log in</a>
                </div>

                <form action="includes/register.inc.php" method="post">

                    <div class="form-group">
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="matric_number" placeholder="Matric Number" required>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="pwd" placeholder="Password" required>
                        <input type="password" name="confirm_pwd" placeholder="Confirm Password" required>
                    </div>

                    <div class="checkbox">
                        <input type="checkbox"> I want to receive updates
                    </div>

                    <div class="checkbox">
                        <input type="checkbox" required> I agree to Terms & Privacy Policy
                    </div>

                    <button class="btn" type="submit">Sign Up</button>

                </form>

                <div class="mt-3 text-center">
                    <?php Check_register_errors(); ?>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        © 2026 Lagos State University. Built for student career success. <br>
        Generated CVs are optimized for Applicant Tracking Systems (ATS).
    </div>
</body>
</html>