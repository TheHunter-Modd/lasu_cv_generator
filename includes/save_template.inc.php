<?php
require_once 'config_session.inc.php';
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $template = $_POST['template'] ?? 'classic';

    $allowed = ['classic', 'professional', 'academic'];
    if ($user_id && in_array($template, $allowed)) {
        
        $stmt = $pdo->prepare("SELECT id FROM personal WHERE user_id = ?");
        $stmt->execute([$user_id]);
        
        if ($stmt->fetch()) {
            $stmt = $pdo->prepare("UPDATE personal SET template_choice = ? WHERE user_id = ?");
            $stmt->execute([$template, $user_id]);
            echo "Success";
        } else {
            echo "No personal record yet";
        }
    } else {
        echo "Error";
    }
} else {
    header("Location: ../preview.php");
    exit();
}