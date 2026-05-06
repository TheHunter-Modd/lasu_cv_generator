<?php
require_once 'config_session.inc.php';
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $template = $_POST['template'] ?? 'classic';

    // Security check
    $allowed = ['classic', 'modern', 'minimal'];
    if ($user_id && in_array($template, $allowed)) {
        
        // Check if personal record exists first
        $stmt = $pdo->prepare("SELECT id FROM personal WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        if ($stmt->fetch()) {
            // Update existing
            $stmt = $pdo->prepare("UPDATE personal SET template_choice = ? WHERE user_id = ?");
            $stmt->execute([$template, $user_id]);
        } else {
            // If they haven't filled the builder yet, do nothing (or you could insert a blank record)
        }
        
        echo "Success";
    } else {
        echo "Error";
    }
} else {
    header("Location: ../preview.php");
    exit();
}