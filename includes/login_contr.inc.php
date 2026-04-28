<?php
declare(strict_types=1);

function is_input_empty(string $matricNumber, string $pwd) {
    return empty($matricNumber) || empty($pwd);
}

function is_user_wrong($result) {
    return !$result;
}

function is_password_wrong(string $pwd, string $hashedPwd) {
    return !password_verify($pwd, $hashedPwd);
}