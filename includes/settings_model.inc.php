<?php
declare(strict_types=1);

function get_user_by_id(object $pdo, int $userId): ?array {
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
}

function update_user_profile(object $pdo, string $firstName, string $lastName, int $userId): void {
    $query = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function update_user_email(object $pdo, string $email, int $userId): void {
    $query = "UPDATE users SET email = :email WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function update_user_password(object $pdo, string $hashedPwd, int $userId): void {
    $query = "UPDATE users SET pwd = :pwd WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function update_user_avatar(object $pdo, string $avatarPath, int $userId): void {
    $query = "UPDATE users SET avatar = :avatar WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":avatar", $avatarPath);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
}

function get_email_by_other_user(object $pdo, string $email, int $userId): ?array {
    $query = "SELECT * FROM users WHERE email = :email AND id != :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
}