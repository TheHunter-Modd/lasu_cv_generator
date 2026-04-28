<?php
declare(strict_types=1);

function get_user(object $pdo, string $matricNumber) {
    $query = "SELECT * FROM users WHERE matric_number = :matric_number;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":matric_number", $matricNumber);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}