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

    // PERSONAL - Update if exists, insert if not
    $stmt = $pdo->prepare("INSERT INTO personal 
        (user_id, full_name, email, phone, linkedin_url, address)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        full_name = VALUES(full_name),
        email = VALUES(email),
        phone = VALUES(phone),
        linkedin_url = VALUES(linkedin_url),
        address = VALUES(address)");
    $stmt->execute([$user_id, $full_name, $email, $phone, $linkedin, $address]);

    // SUMMARY
    $stmt = $pdo->prepare("INSERT INTO summaries 
        (user_id, professional_summary)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE 
        professional_summary = VALUES(professional_summary)");
    $stmt->execute([$user_id, $summary]);

    // EDUCATION
    $stmt = $pdo->prepare("INSERT INTO education 
        (user_id, institution, degree, field_of_study, start_date, end_date, grade_cgpa)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        institution = VALUES(institution),
        degree = VALUES(degree),
        field_of_study = VALUES(field_of_study),
        start_date = VALUES(start_date),
        end_date = VALUES(end_date),
        grade_cgpa = VALUES(grade_cgpa)");
    $stmt->execute([$user_id, $institution, $degree, $field, $edu_start, $edu_end, $cgpa]);

    // EXPERIENCE
    $stmt = $pdo->prepare("INSERT INTO experience 
        (user_id, company, job_title, start_date, end_date, description)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        company = VALUES(company),
        job_title = VALUES(job_title),
        start_date = VALUES(start_date),
        end_date = VALUES(end_date),
        description = VALUES(description)");
    $stmt->execute([$user_id, $company, $job_title, $exp_start, $exp_end, $description]);

    // SKILLS - Delete old, insert new
    $stmt = $pdo->prepare("DELETE FROM skills WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    if (!empty($skills)) {
        $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name) VALUES (?, ?)");
        foreach ($skills as $skill) {
            $stmt->execute([$user_id, $skill]);
        }
    }
}