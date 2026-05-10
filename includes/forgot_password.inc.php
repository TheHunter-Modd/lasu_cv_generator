<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $matricNumber = trim($_POST["matric_number"]);

    try {
        require_once 'config_session.inc.php';
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';

        $errors = [];

        if (empty($matricNumber)) {
            $errors["empty_input"] = "Please enter your matric number!";
        }

        if (!$errors) {
            $result = get_user($pdo, $matricNumber);

            if (!$result) {
                $errors["user_not_found"] = "No account found with that matric number!";
            }
        }

        if ($errors) {
            $_SESSION["errors_forgot"] = $errors;
            header("Location: ../forgot_password.php");
            die();
        }

        // Store matric number in session for the reset step
        $_SESSION["reset_matric"] = $matricNumber;
        header("Location: ../reset_password.php");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("Location: ../forgot_password.php");
    die();
}