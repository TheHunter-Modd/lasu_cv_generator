<?php
declare(strict_types=1);

function show_settings_messages(): void {
    // Show errors
    if (isset($_SESSION["errors_settings"])) {
        $errors = $_SESSION["errors_settings"];
        echo '<div class="msg-box msg-error">';
        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        echo '</div>';
        unset($_SESSION["errors_settings"]);
    }

    // Show success
    if (isset($_SESSION["success_settings"])) {
        echo '<div class="msg-box msg-success">';
        echo '<p>' . htmlspecialchars($_SESSION["success_settings"]) . '</p>';
        echo '</div>';
        unset($_SESSION["success_settings"]);
    }
}