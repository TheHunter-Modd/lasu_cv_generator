<?php
declare(strict_types=1);

function update_password(object $pdo, string $hashedPwd, string $matricNumber): void {
    $query = "UPDATE users SET pwd = :pwd WHERE matric_number = :matric_number;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":matric_number", $matricNumber);
    $stmt->execute();
}