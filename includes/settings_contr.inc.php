<?php
declare(strict_types=1);

function is_profile_empty(string $firstName, string $lastName): bool {
    return empty($firstName) || empty($lastName);
}

function is_email_taken_by_other(object $pdo, string $email, int $userId): bool {
    return (bool) get_email_by_other_user($pdo, $email, $userId);
}

function is_current_password_wrong(string $pwd, string $hashedPwd): bool {
    return !password_verify($pwd, $hashedPwd);
}

function is_password_short(string $pwd): bool {
    return strlen($pwd) < 6;
}

function do_passwords_match(string $pwd, string $confirmPwd): bool {
    return $pwd === $confirmPwd;
}

function is_avatar_valid(array $avatarFile): array {
    $errors = [];

    // Check file size (2MB max)
    $maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if ($avatarFile["size"] > $maxSize) {
        $errors[] = "Avatar must be less than 2MB.";
    }

    // Check file type
    $allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
    if (!in_array($avatarFile["type"], $allowedTypes)) {
        $errors[] = "Only JPG, PNG, GIF, and WebP files are allowed.";
    }

    // Check for upload errors
    if ($avatarFile["error"] !== UPLOAD_ERR_OK) {
        $errors[] = "An error occurred during upload.";
    }

    return $errors;
}