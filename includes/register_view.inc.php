<?php 
declare(strict_types=1);

function register_inputs() {

    if (isset($_SESSION['register_data']['username']) && isset($_SESSION['errors_register']['username_taken'])) {
        echo '<input type="text" name="username" class="form-control" placeholder="Username" value="' . htmlspecialchars($_SESSION['register_data']['username']) . '">';
    } else {
        echo '<input type="text" name="username" class="form-control" placeholder="Username">';
       
    }

    echo '<input type="password" name="password" class="form-control" placeholder="Password">';

        if (isset($_SESSION['register_data']['email']) && isset($_SESSION['errors_signup']['email_used']) && isset($_SESSION['errors_register']['invalid_email'])) {
        echo '<input type="email" name="email" class="form-control" placeholder="E-mail"> value="' . htmlspecialchars($_SESSION['register_data']['email']) . '">';
    } else {
        echo '<input type="email" name="email" class="form-control" placeholder="E-mail">';
       
    }
}

function Check_register_errors() {
    if (isset($_SESSION['errors_register'])) {
        $errors = $_SESSION['errors_register'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-error">' .$error . '</p>';
        }

        // Clear errors after displaying them
        unset($_SESSION['errors_register']);
    } else if (isset($_GET['register']) && $_GET['register'] === 'success') {
        echo '<br>';
        echo '<p class="form-success">Signup successful!</p>';
    }
}
