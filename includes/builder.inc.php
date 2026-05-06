<?php
require_once 'config_session.inc.php';
require_once 'dbh.inc.php';
require_once 'builder_model.inc.php';
require_once 'builder_contr.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $linkedin = $_POST['linkedin_url'];
    $address = $_POST['address'];

    $summary = $_POST['professional_summary'];

    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $field = $_POST['field_of_study'];
    $edu_start = $_POST['edu_start_date'];
    $edu_end = $_POST['edu_end_date'];
    $cgpa = $_POST['grade_cgpa'];

    $company = $_POST['company'];
    $job_title = $_POST['job_title'];
    $exp_start = $_POST['exp_start_date'];
    $exp_end = $_POST['exp_end_date'];
    $description = $_POST['description'];

    $skills = $_POST['skills'] ?? [];

    // NEW FIELDS
    $vol_org = $_POST['vol_org'] ?? '';
    $vol_role = $_POST['vol_role'] ?? '';
    $vol_start = $_POST['vol_start'] ?? '';
    $vol_end = $_POST['vol_end'] ?? '';
    $vol_description = $_POST['vol_description'] ?? '';
    
    $relevant_courses = $_POST['relevant_courses'] ?? '';
    $honors_achievements = $_POST['honors_achievements'] ?? '';
    $societies = $_POST['societies'] ?? '';

    // VALIDATION
    $errors = validate_builder_input($full_name, $email);

    if (!empty($errors)) {
        $_SESSION["builder_errors"] = $errors;
        header("Location: ../builder.php");
        exit();
    }

    // Update the save_cv_data call
    save_cv_data(
    $pdo,
    $user_id,
    $full_name, $email, $phone, $linkedin, $address,
    $summary,
    $institution, $degree, $field, $edu_start, $edu_end, $cgpa,
    $company, $job_title, $exp_start, $exp_end, $description,
    $skills,
    // NEW PARAMETERS
    $vol_org, $vol_role, $vol_start, $vol_end, $vol_description,
    $relevant_courses, $honors_achievements, $societies
);
    header("Location: ../preview.php?success=1");
    exit();
}