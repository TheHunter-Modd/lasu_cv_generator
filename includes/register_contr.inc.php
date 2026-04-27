<?php


declare(strict_types=1);


function is_input_empty(string $firstName, string $lastName, string $matricNumber, string $email, string $pwd) {
    if (empty($firstName) || empty($lastName) || empty($matricNumber) || empty($email) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true; 
    }
    else {
        return false;
    }
}

function is_matric_number_taken(object $pdo, string $matricNumber) {
    if (get_matric_number( $pdo,  $matricNumber)) {
        return true; 
    }
    else {
        return false;
    }
}

function is_email_registered(object $pdo, string $email) {
    if (get_email( $pdo,  $email)) {
        return true; 
    }
    else {
        return false;
    }
}

function create_user(object $pdo, string $firstName, string $lastName, string $matricNumber, string $email, string $pwd) {
    set_user($pdo, $firstName, $lastName, $matricNumber, $email, $pwd);
}



