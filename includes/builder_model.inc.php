<?php
function save_cv_data(
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
) {

    // PERSONAL (include template_choice)
    $template = $_POST['template_choice'] ?? 'classic';
    
    $stmt = $pdo->prepare("INSERT INTO personal 
        (user_id, full_name, email, phone, linkedin_url, address, template_choice)
        VALUES (?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        full_name = VALUES(full_name),
        email = VALUES(email),
        phone = VALUES(phone),
        linkedin_url = VALUES(linkedin_url),
        address = VALUES(address),
        template_choice = VALUES(template_choice)");
    $stmt->execute([$user_id, $full_name, $email, $phone, $linkedin, $address, $template]);

    // SUMMARY
    $stmt = $pdo->prepare("INSERT INTO summaries 
        (user_id, professional_summary)
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE 
        professional_summary = VALUES(professional_summary)");
    $stmt->execute([$user_id, $summary]);

    // EDUCATION (with new fields)
    $stmt = $pdo->prepare("INSERT INTO education 
        (user_id, institution, degree, field_of_study, start_date, end_date, grade_cgpa, 
         relevant_courses, honors_achievements, societies)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
        institution = VALUES(institution),
        degree = VALUES(degree),
        field_of_study = VALUES(field_of_study),
        start_date = VALUES(start_date),
        end_date = VALUES(end_date),
        grade_cgpa = VALUES(grade_cgpa),
        relevant_courses = VALUES(relevant_courses),
        honors_achievements = VALUES(honors_achievements),
        societies = VALUES(societies)");
    $stmt->execute([$user_id, $institution, $degree, $field, $edu_start, $edu_end, $cgpa,
                    $relevant_courses, $honors_achievements, $societies]);

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

    // SKILLS
    $stmt = $pdo->prepare("DELETE FROM skills WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    if (!empty($skills)) {
        $stmt = $pdo->prepare("INSERT INTO skills (user_id, skill_name) VALUES (?, ?)");
        foreach ($skills as $skill) {
            $stmt->execute([$user_id, $skill]);
        }
    }

    // VOLUNTEER EXPERIENCE (NEW)
    $stmt = $pdo->prepare("DELETE FROM volunteer_experience WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    if (!empty($vol_org)) {
        $stmt = $pdo->prepare("INSERT INTO volunteer_experience 
            (user_id, organization, role_title, start_date, end_date, description)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $vol_org, $vol_role, $vol_start, $vol_end, $vol_description]);
    }
}