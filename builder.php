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
<link rel="stylesheet" href="css/builder.css"> <!-- NEW -->
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

        <!-- BUILDER CONTENT -->
        <div class="builder-container">

            <!-- BACK -->
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>

            <!-- STEP NAV -->
            <div class="builder-steps">
    <span class="step active" data-step="personal">Personal</span>
    <span class="step" data-step="summary">Summary</span>
    <span class="step" data-step="education">Education</span>
    <span class="step" data-step="experience">Experience</span>
    <span class="step" data-step="skills">Skills</span>
</div>

            <!-- CARD -->
            <div class="builder-card">

    <!-- PERSONAL -->
    <form class="form-section active" id="personal" method="POST">
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
    </form>

    <!-- SUMMARY -->
    <form class="form-section" id="summary" method="POST">
        <h2>Professional Summary</h2>
        <p>Write 2-4 sentences highlighting your key skills, experiences, and career goals.</p>
        <textarea name="professional_summary" placeholder="A highly motivated computer science student with a passion for building scalable web applications. Proficient in Html, CSS, and PHP..."></textarea>
    </form>

    <!-- EDUCATION -->
    <form class="form-section" id="education" method="POST">
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
                <input type="text" name="start_date" placeholder="e.g. 2020">
            </div>

            <div class="form-group">
                <label>End Date (or Expected)</label>
                <input type="text" name="end_date" placeholder="e.g. 2024">
            </div>

            <div class="form-group full">
                <label>Grade / CGPA (Optional)</label>
                <input type="text" name="grade_cgpa" placeholder="e.g. 3.8/4.0">
            </div>
        </div>
    </form>

    <!-- EXPERIENCE -->
    <form class="form-section" id="experience" method="POST">
        <h2>Work Experience</h2>
        <p>Include internships, volunteer work, or part-time jobs. Focus on achievements rather than duties.</p>

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
                <input type="text" name="start_date" placeholder="e.g. Jun 2022">
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="text" name="end_date" placeholder="e.g. Present">
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" id=""  placeholder="• Developed a new feature that increased user retention by 20%
• Collaborated with a team of 5 engineers to deploy..."></textarea>
            </div>

        </div>
    </form>

    <!-- SKILLS (your existing one) -->
    <form class="form-section" id="skills" method="POST">
        <h2>Skills & Competencies</h2>
        <p>Add technical skills, tools, and soft skills.</p>

        <div class="skill-input">
            <input type="text" placeholder="e.g. JavaScript">
            <button>+ Add</button>
        </div>

        <div class="skill-box">
            <p>No skills added yet.</p>
        </div>
    </form>

    <!-- FOOTER -->
    <div class="builder-footer">
        <button class="back-btn">Back</button>
        <button class="finish-btn">Save & Continue</button>
    </div>

</div>

        </div>

    </div>
</div>

<script>
const steps = document.querySelectorAll(".step");
const sections = document.querySelectorAll(".form-section");
const nextBtn = document.querySelector(".finish-btn");
const backBtn = document.querySelector(".back-btn");

let currentStep = 0;

// STEP ORDER
const stepOrder = ["personal", "summary", "education", "experience", "skills"];

// FUNCTION TO SHOW STEP
function showStep(index) {
    // remove active
    steps.forEach(s => s.classList.remove("active"));
    sections.forEach(sec => sec.classList.remove("active"));

    // activate current
    steps[index].classList.add("active");
    document.getElementById(stepOrder[index]).classList.add("active");

    currentStep = index;

    // CHANGE BUTTON TEXT ON LAST STEP
    if (currentStep === stepOrder.length - 1) {
        nextBtn.textContent = "Finish & Preview CV";
    } else {
        nextBtn.textContent = "Save & Continue";
    }
}

// CLICK ON TOP TABS
steps.forEach((step, index) => {
    step.addEventListener("click", () => {
        showStep(index);
    });
});

// NEXT BUTTON
nextBtn.addEventListener("click", async () => {

    const currentSection = document.getElementById(stepOrder[currentStep]);
    const formData = new FormData(currentSection);

    // ADD STEP NAME (VERY IMPORTANT)
    formData.append("step", stepOrder[currentStep]);

    try {
        await fetch("includes/save_builder.inc.php", {
            method: "POST",
            body: formData
        });

        // move to next step
        if (currentStep < stepOrder.length - 1) {
            showStep(currentStep + 1);
        } else {
            window.location.href = "preview.php";
        }

    } catch (error) {
        alert("Error saving data");
    }
});

// BACK BUTTON
backBtn.addEventListener("click", () => {
    if (currentStep > 0) {
        showStep(currentStep - 1);
    }
});
</script>

</body>
</html>