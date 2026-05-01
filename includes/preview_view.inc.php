<?php

// ============================================================
//  preview_view.inc.php
//  Responsibility: Render error banners and empty-state blocks.
//  All functions echo HTML directly — call them inside the
//  page template where you want the output to appear.
// ============================================================

// ── Fatal error banner ───────────────────────────────────────
// Call this when the DB query itself fails (exception caught
// in the controller). Echoes a red alert inside the cv-paper.
function preview_render_error(string $message): void { ?>
    <div class="preview-error-banner">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php }

// ── Empty CV state ───────────────────────────────────────────
// Call this when the user has no data at all yet.
function preview_render_empty(): void { ?>
    <div class="cv-empty-state">
        <svg width="52" height="52" viewBox="0 0 24 24" fill="none"
             stroke="#c5c9d9" stroke-width="1.5"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12
                     a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        <p>
            Your CV is empty.<br>
            Go to the <a href="builder.php">Builder</a> to fill in your details.
        </p>
    </div>
<?php }

// ── Section empty notice ─────────────────────────────────────
// Call this inside a cv-section when a particular section has
// no entries (e.g. user skipped Education).
function preview_render_section_empty(string $section_label): void { ?>
    <p class="cv-section-empty">
        No <?= htmlspecialchars($section_label) ?> added yet.
        <a href="builder.php">Add it in Builder →</a>
    </p>
<?php }
