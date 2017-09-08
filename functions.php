
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
    </body>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
<?php

function checkUser() {
    if (!isset($_SESSION['user_id'])) {
        header('Location:login.php');
        exit;
    }

    if (isset($_GET['logout'])) {
        doLogout();
    }
}

function doLogin() {
    require 'config/config.php';
    $errorMessage = '';
    $userName = $_POST['email'];
    $password = $_POST['password'];

    if ($userName == '') {
        $errorMessage = 'You must enter your username';
    } else if ($password == '') {
        $errorMessage = 'You must enter the password';
    } else {
        $sql = "SELECT id, email, password,location
		        FROM users 
				WHERE email = '$userName' AND password = '$password'";
        $output = $conn->query($sql);
        if ($output->num_rows > 0) {
            $row = $output->fetch_assoc();
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['location'] = $row['location'];
            if (isset($_SESSION['login_return_url'])) {
                header('Location: ' . $_SESSION['login_return_url']);
                exit;
            } else {
                header('Location: home.php');
                exit;
            }
        } else {
            ?> <span class="alert alert-danger" style="margin-left:40%;"> <?php echo'Invalid Username or Password '; ?> </span> <?php
        }
    }

    return $errorMessage;
}
?>
