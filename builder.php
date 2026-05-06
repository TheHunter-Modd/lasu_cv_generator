<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/builder_view.inc.php';

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
    <div class="sidebar-overlay" onclick="toggleMobileMenu()"></div>

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
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
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
                <span class="step" data-step="volunteer">Volunteer</span>
                <span class="step" data-step="academic">Academic</span>
            </div>

            <!-- CARD -->
            <div class="builder-card">
                <form action="includes/builder.inc.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                     <!-- PERSONAL -->
    <div class="form-section active" id="personal" >
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
        <textarea name="professional_summary" placeholder="A highly motivated computer science student with a passion for building scalable web applications. Proficient in Html, CSS, and PHP..."></textarea>
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
                <input type="text" name="exp_start_date" placeholder="e.g. Jun 2022">
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="text" name="exp_end_date" placeholder="e.g. Present">
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" id=""  placeholder="• Developed a new feature that increased user retention by 20%
• Collaborated with a team of 5 engineers to deploy..."></textarea>
            </div>

        </div>
    </div>

    <!-- SKILLS (your existing one) -->
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

    <!-- VOLUNTEER EXPERIENCE -->
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

<!-- ACADEMIC DETAILS -->
<div class="form-section" id="academic">
    <h2>Academic Details <small style="color:#888;">(Optional)</small></h2>
    <p>Add relevant coursework, honors, and societies for academic-focused CVs.</p>

    <div class="form-grid">
        <div class="form-group full">
            <label>Relevant Courses</label>
            <textarea name="relevant_courses" placeholder="Data Structures & Algorithms, Database Management Systems, Software Engineering, Web Technologies..."></textarea>
        </div>
        <div class="form-group full">
            <label>Honors & Achievements</label>
            <textarea name="honors_achievements" placeholder="• Dean's List (2023, 2024)&#10;• Best Project Award - Final Year&#10;• 2nd Place - LASU Hackathon 2024"></textarea>
        </div>
        <div class="form-group full">
            <label>Societies & Extracurriculars</label>
            <textarea name="societies" placeholder="• Member, LASU Computer Science Society (2022-Present)&#10;• Secretary, LASU Tech Club (2023-2024)"></textarea>
        </div>
    </div>
</div>

       <!-- FOOTER -->
    <div class="builder-footer">
        <button type="button" class="back-btn">Back</button>
        <button type="submit" class="finish-btn">Save & Continue</button>
    </div>
    

                </form>

    

   
     
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

// ORDER
const stepOrder = ["personal", "summary", "education", "experience", "skills", "volunteer", "academic"];

// SHOW STEP FUNCTION
function showStep(index) {
    steps.forEach(s => s.classList.remove("active"));
    sections.forEach(sec => sec.classList.remove("active"));

    steps[index].classList.add("active");
    document.getElementById(stepOrder[index]).classList.add("active");

    currentStep = index;

    // ONLY change text, not type
    if (currentStep === stepOrder.length - 1) {
        nextBtn.textContent = "Save & Finish";
    } else {
        nextBtn.textContent = "Save & Continue";
    }
}

// CLICK TOP NAV
steps.forEach((step, index) => {
    step.addEventListener("click", () => {
        showStep(index);
    });
});

const addSkillBtn = document.querySelector(".skill-input button");
const skillInput = document.querySelector(".skill-input input");
const skillBox = document.querySelector(".skill-box");
const form = document.querySelector("form");

addSkillBtn.addEventListener("click", () => {
    const skillValue = skillInput.value.trim();
    if (skillValue === "") return;

    // Remove "No skills" message
    if (skillBox.querySelector("p")) {
        skillBox.innerHTML = "";
    }

    // Visual tag
    const tag = document.createElement("div");
    tag.className = "skill-tag-item";
    tag.innerHTML = `
        <span>${skillValue}</span>
        <button type="button" class="remove-skill" onclick="this.parentElement.remove()">×</button>
    `;
    skillBox.appendChild(tag);

    // Hidden input — attached DIRECTLY to form, not inside skillBox
    const hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = "skills[]";
    hidden.value = skillValue;
    form.appendChild(hidden);

    skillInput.value = "";
    skillInput.focus();
});

// NEXT BUTTON
nextBtn.addEventListener("click", (e) => {

    if (currentStep < stepOrder.length - 1) {
        e.preventDefault(); // 🚫 block submit
        showStep(currentStep + 1);
    }

    // LAST STEP → do NOTHING → form submits naturally → PHP handles it ✅
});

// BACK BUTTON
backBtn.addEventListener("click", (e) => {
    e.preventDefault();

    if (currentStep > 0) {
        showStep(currentStep - 1);
    }
});

showStep(0);
function toggleMobileMenu() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.querySelector('.sidebar-overlay').classList.toggle('open');
}
</script>

</body>
</html>