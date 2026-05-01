<?php

// ============================================================
//  preview.inc.php
//  Responsibility: Sanitise and structure raw DB arrays from
//  the model into a clean $cv_data array for preview.php.
//  Note: summary lives in its own table, so $raw['summary']
//  is a separate entry from $raw['personal'].
// ============================================================

function preview_sanitise_str(array $row, string $key): string {
    return isset($row[$key]) ? htmlspecialchars(trim($row[$key])) : '';
}

function preview_process(array $raw): array {

    $cv_data = [
        'personal'   => [],
        'education'  => [],
        'experience' => [],
        'skills'     => [],
        'is_empty'   => true,
    ];

    // ── Personal ──────────────────────────────────────────────
    if (!empty($raw['personal'])) {
        $p = $raw['personal'];

        // Summary comes from its own table
        $summary = '';
        if (!empty($raw['summary']) && !empty($raw['summary']['professional_summary'])) {
            $summary = htmlspecialchars(trim($raw['summary']['professional_summary']));
        }

        $cv_data['personal'] = [
            'full_name'   => preview_sanitise_str($p, 'full_name'),
            'email'       => preview_sanitise_str($p, 'email'),
            'phone'       => preview_sanitise_str($p, 'phone'),
            'linkedin_url'=> preview_sanitise_str($p, 'linkedin_url'),
            'address'     => preview_sanitise_str($p, 'address'),
            'summary'     => $summary,
        ];

        $cv_data['is_empty'] = false;
    }

    // ── Education ─────────────────────────────────────────────
    foreach ($raw['education'] as $edu) {
        $cv_data['education'][] = [
            'institution' => preview_sanitise_str($edu, 'institution'),
            'degree'      => preview_sanitise_str($edu, 'degree'),
            'field'       => preview_sanitise_str($edu, 'field_of_study'),
            'start'       => preview_sanitise_str($edu, 'start_date'),
            'end'         => preview_sanitise_str($edu, 'end_date'),
            'grade'       => preview_sanitise_str($edu, 'grade_cgpa'),
        ];
        $cv_data['is_empty'] = false;
    }

    // ── Experience ────────────────────────────────────────────
    foreach ($raw['experience'] as $exp) {
        $cv_data['experience'][] = [
            'company'     => preview_sanitise_str($exp, 'company'),
            'job_title'   => preview_sanitise_str($exp, 'job_title'),
            'start'       => preview_sanitise_str($exp, 'start_date'),
            'end'         => preview_sanitise_str($exp, 'end_date'),
            'description' => isset($exp['description'])
                                ? nl2br(htmlspecialchars(trim($exp['description'])))
                                : '',
        ];
        $cv_data['is_empty'] = false;
    }

    // ── Skills ────────────────────────────────────────────────
    foreach ($raw['skills'] as $skill) {
        $name = preview_sanitise_str($skill, 'skill_name');
        if ($name !== '') {
            $cv_data['skills'][] = $name;
            $cv_data['is_empty'] = false;
        }
    }

    return $cv_data;
}
