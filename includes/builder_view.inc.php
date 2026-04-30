<?php

if (isset($_SESSION["builder_errors"])) {
    foreach ($_SESSION["builder_errors"] as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    unset($_SESSION["builder_errors"]);
}