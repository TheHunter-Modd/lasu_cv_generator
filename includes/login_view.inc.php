<?php
declare(strict_types=1);

function Check_login_errors() {
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        foreach ($errors as $error) {
            echo '<p style="color:red;">' . $error . '</p>';
        }

        unset($_SESSION["errors_login"]);
    }
}