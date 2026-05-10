<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pwd = trim($_POST["pwd"]);
    $confirmPwd = trim($_POST["confirm_pwd"]);

    try {
        require_once 'config_session.inc.php';
        require_once 'dbh.inc.php';
        require_once 'forgot_password_model.inc.php';

        $errors = [];

        if (empty($pwd) || empty($confirmPwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if (!$errors && strlen($pwd) < 6) {
            $errors["pwd_short"] = "Password must be at least 6 characters!";
        }

        if (!$errors && $pwd !== $confirmPwd) {
            $errors["pwd_mismatch"] = "Passwords do not match!";
        }

        if ($errors) {
            $_SESSION["errors_reset"] = $errors;
            header("Location: ../reset_password.php");
            die();
        }

        // Hash and update the password
        $matricNumber = $_SESSION["reset_matric"];
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

        update_password($pdo, $hashedPwd, $matricNumber);

        // Clean up reset session
        unset($_SESSION["reset_matric"]);

        // Set success flag for login page
        $_SESSION["password_reset_success"] = true;

        header("Location: ../login.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../forgot_password.php");
    die();
}