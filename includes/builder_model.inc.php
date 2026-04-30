<?php

function save_cv_data(
    $pdo,
    $user_id,
    $full_name, $email, $phone, $linkedin, $address,
    $summary,
    $institution, $degree, $field, $edu_start, $edu_end, $cgpa,
    $company, $job_title, $exp_start, $exp_end, $description,
    $skills
) {

    // PERSONAL (your table = personal)
    $stmt = $pdo->prepare("INSERT INTO personal 
    (user_id, full_name, email, phone, linkedin_url, address)
    VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $full_name, $email, $phone, $linkedin, $address]);

    // SUMMARY (your table = summaries, column = professional_summary)
    $stmt = $pdo->prepare("INSERT INTO summaries 
        (user_id, professional_summary)
        VALUES (?, ?)");
    $stmt->execute([$user_id, $summary]);

    // EDUCATION (column = grade_cgpa)
    $stmt = $pdo->prepare("INSERT INTO education 
        (user_id, institution, degree, field_of_study, start_date, end_date, grade_cgpa)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $institution, $degree, $field, $edu_start, $edu_end, $cgpa]);

    // EXPERIENCE
    $stmt = $pdo->prepare("INSERT INTO experience 
        (user_id, company, job_title, start_date, end_date, description)
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $company, $job_title, $exp_start, $exp_end, $description]);

    // SKILLS
    if (!empty($skills)) {
        $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name) VALUES (?, ?)");
        foreach ($skills as $skill) {
            $stmt->execute([$user_id, $skill]);
        }
    }
}