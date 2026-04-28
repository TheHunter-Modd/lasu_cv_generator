<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="includes/login.inc.php" method="post">

    <input type="text" name="matric_number" placeholder="Matric Number" required>

    <input type="password" name="pwd" placeholder="Password" required>

    <button type="submit">Login</button>

</form>

<?php Check_login_errors(); ?>
    </form>
    </div>
</body>
</html>