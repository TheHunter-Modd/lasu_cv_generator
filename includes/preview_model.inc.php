<?php

// ============================================================
//  preview_model.inc.php
//  Responsibility: ALL database reads for the preview page.
//  Table names and columns match builder_model.inc.php exactly.
// ============================================================

// ── Personal info ─────────────────────────────────────────────
// Table: personal
// Cols:  user_id, full_name, email, phone, linkedin_url, address
function preview_get_personal(PDO $pdo, int $user_id): array|false {
    $stmt = $pdo->prepare("
        SELECT full_name, email, phone, linkedin_url, address
        FROM   personal
        WHERE  user_id = ?
        LIMIT  1
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ── Summary ────────────────────────────────────────────────────
// Table: summaries
// Cols:  user_id, professional_summary
function preview_get_summary(PDO $pdo, int $user_id): array|false {
    $stmt = $pdo->prepare("
        SELECT professional_summary
        FROM   summaries
        WHERE  user_id = ?
        LIMIT  1
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ── Education ──────────────────────────────────────────────────
// Table: education
// Cols:  user_id, institution, degree, field_of_study,
//        start_date, end_date, grade_cgpa
function preview_get_education(PDO $pdo, int $user_id): array {
    $stmt = $pdo->prepare("
        SELECT institution, degree, field_of_study,
               start_date, end_date, grade_cgpa
        FROM   education
        WHERE  user_id = ?
        ORDER  BY end_date DESC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ── Experience ─────────────────────────────────────────────────
// Table: experience
// Cols:  user_id, company, job_title, start_date, end_date, description
function preview_get_experience(PDO $pdo, int $user_id): array {
    $stmt = $pdo->prepare("
        SELECT company, job_title, start_date, end_date, description
        FROM   experience
        WHERE  user_id = ?
        ORDER  BY start_date DESC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ── Skills ─────────────────────────────────────────────────────
// Table: skills
// Cols:  user_id, skill_name
function preview_get_skills(PDO $pdo, int $user_id): array {
    $stmt = $pdo->prepare("
        SELECT skill_name
        FROM   skills
        WHERE  user_id = ?
        ORDER  BY id ASC
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
