<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        require_once 'config_session.inc.php';
        require_once 'dbh.inc.php';
        require_once 'settings_model.inc.php';
        require_once 'settings_contr.inc.php';

        $action = $_POST["action"] ?? "";
        $userId = (int) $_SESSION["user_id"];

        // ═══════════════════════════════════
        // UPDATE PROFILE (Name)
        // ═══════════════════════════════════
        if ($action === "profile") {

            $firstName = trim($_POST["first_name"]);
            $lastName = trim($_POST["last_name"]);
            $errors = [];

            if (is_profile_empty($firstName, $lastName)) {
                $errors["profile_empty"] = "First name and last name are required.";
            }

            if ($errors) {
                $_SESSION["errors_settings"] = $errors;
            } else {
                update_user_profile($pdo, $firstName, $lastName, $userId);

                // Update session name (if you store it)
                $_SESSION["user_first_name"] = htmlspecialchars($firstName);

                $_SESSION["success_settings"] = "Profile updated successfully!";
            }

            header("Location: ../settings.php");
            die();
        }

        // ═══════════════════════════════════
        // UPDATE EMAIL
        // ═══════════════════════════════════
        if ($action === "email") {

            $email = trim($_POST["email"]);
            $errors = [];

            if (empty($email)) {
                $errors["email_empty"] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors["email_invalid"] = "Invalid email format.";
            } elseif (is_email_taken_by_other($pdo, $email, $userId)) {
                $errors["email_taken"] = "That email is already used by another account.";
            }

            if ($errors) {
                $_SESSION["errors_settings"] = $errors;
            } else {
                update_user_email($pdo, $email, $userId);
                $_SESSION["success_settings"] = "Email updated successfully!";
            }

            header("Location: ../settings.php");
            die();
        }

        // ═══════════════════════════════════
        // UPDATE PASSWORD
        // ═══════════════════════════════════
        if ($action === "password") {

            $currentPwd = trim($_POST["current_pwd"]);
            $newPwd = trim($_POST["new_pwd"]);
            $confirmPwd = trim($_POST["confirm_pwd"]);
            $errors = [];

            // Get current user to verify old password
            $user = get_user_by_id($pdo, $userId);

            if (empty($currentPwd) || empty($newPwd) || empty($confirmPwd)) {
                $errors["pwd_empty"] = "All password fields are required.";
            } elseif (is_current_password_wrong($currentPwd, $user["pwd"])) {
                $errors["pwd_wrong"] = "Current password is incorrect.";
            } elseif (is_password_short($newPwd)) {
                $errors["pwd_short"] = "New password must be at least 6 characters.";
            } elseif (!do_passwords_match($newPwd, $confirmPwd)) {
                $errors["pwd_mismatch"] = "New passwords do not match.";
            }

            if ($errors) {
                $_SESSION["errors_settings"] = $errors;
            } else {
                $hashedPwd = password_hash($newPwd, PASSWORD_BCRYPT);
                update_user_password($pdo, $hashedPwd, $userId);
                $_SESSION["success_settings"] = "Password changed successfully!";
            }

            header("Location: ../settings.php");
            die();
        }

        // ═══════════════════════════════════
        // UPDATE AVATAR
        // ═══════════════════════════════════
        if ($action === "avatar") {

            $errors = [];

            if (!isset($_FILES["avatar"]) || $_FILES["avatar"]["error"] === UPLOAD_ERR_NO_FILE) {
                $errors["avatar_empty"] = "Please select an image to upload.";
            } else {
                $avatarErrors = is_avatar_valid($_FILES["avatar"]);
                if (!empty($avatarErrors)) {
                    $errors["avatar_invalid"] = implode(" ", $avatarErrors);
                }
            }

            if ($errors) {
                $_SESSION["errors_settings"] = $errors;
            } else {
                // Generate unique filename
                $fileInfo = pathinfo($_FILES["avatar"]["name"]);
                $extension = strtolower($fileInfo["extension"]);
                $newFileName = "avatar_" . $userId . "_" . time() . "." . $extension;

                $uploadDir = "../uploads/avatars/";
                $uploadPath = $uploadDir . $newFileName;

                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Move the file
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadPath)) {
                    // Delete old avatar file if it exists
                    $user = get_user_by_id($pdo, $userId);
                    if (!empty($user["avatar"]) && file_exists("../" . $user["avatar"])) {
                        unlink("../" . $user["avatar"]);
                    }

                    // Save relative path to DB
                    $dbPath = "uploads/avatars/" . $newFileName;
                    update_user_avatar($pdo, $dbPath, $userId);

                    $_SESSION["success_settings"] = "Profile photo updated!";
                } else {
                    $errors["avatar_upload"] = "Failed to upload image. Please try again.";
                    $_SESSION["errors_settings"] = $errors;
                }
            }

            header("Location: ../settings.php");
            die();
        }

        // No valid action
        header("Location: ../settings.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../settings.php");
    die();
}