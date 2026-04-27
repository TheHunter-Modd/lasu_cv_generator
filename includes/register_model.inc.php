<?php
//interact only with db

declare(strict_types=1);


function get_first_name(object $pdo, string $firstName) {
    $query = "SELECT * FROM users WHERE first_name = :first_name;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":first_name", $firstName);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_last_name(object $pdo, string $lastName) {
    $query = "SELECT * FROM users WHERE last_name = :last_name;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":last_name", $lastName);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_matric_number(object $pdo, string $matricNumber) {
    $query = "SELECT * FROM users WHERE matric_number = :matric_number;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":matric_number", $matricNumber);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email) {
    $query = "SELECT * FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $firstName, string $lastName, string $matricNumber, string $email, string $pwd) {
    $query = "INSERT INTO users (first_name, last_name, matric_number, email, pwd) VALUES (:first_name, :last_name, :matric_number, :email, :pwd);";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12,
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":matric_number", $matricNumber);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->execute();
}