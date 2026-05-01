<?php

// ============================================================
//  preview_contr.inc.php
//  Responsibility: Orchestrate the preview page lifecycle.
//    1. Guard: redirect if not logged in
//    2. Load all dependencies
//    3. Call the model to fetch raw data
//    4. Pass raw data through the processor
//    5. Expose $cv_data and $preview_error to preview.php
//    6. Resolve the active tab from the query string
// ============================================================

require_once 'includes/config_session.inc.php';

// ── Auth guard ───────────────────────────────────────────────
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die();
}

// ── Load dependencies ────────────────────────────────────────
require_once 'includes/dbh.inc.php';          // provides $pdo
require_once 'includes/preview_model.inc.php'; // DB query functions
require_once 'includes/preview.inc.php';       // preview_process()
require_once 'includes/preview_view.inc.php';  // error/empty helpers

// ── Resolve active tab ───────────────────────────────────────
$allowed_tabs  = ['personal', 'academic', 'all', 'reports'];
$active_tab    = isset($_GET['tab']) && in_array($_GET['tab'], $allowed_tabs)
                    ? $_GET['tab']
                    : 'all';

// ── Fetch & process data ─────────────────────────────────────
$preview_error = null;   // null = no error; string = error message
$cv_data       = [];

try {
    $user_id = (int) $_SESSION['user_id'];

    $raw = [
        'personal'   => preview_get_personal($pdo, $user_id),
        'summary'    => preview_get_summary($pdo, $user_id),
        'education'  => preview_get_education($pdo, $user_id),
        'experience' => preview_get_experience($pdo, $user_id),
        'skills'     => preview_get_skills($pdo, $user_id),
    ];

    $cv_data = preview_process($raw);

} catch (PDOException $e) {
    // Don't expose raw DB errors to the browser — log and show friendly message
    error_log('[LASU CV] preview_contr error: ' . $e->getMessage());
    $preview_error = "We couldn't load your CV data right now. Please try again later.";
}
