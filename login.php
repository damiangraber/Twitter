<?php
require_once 'src/User.php';
require_once 'connection.php';

session_start();

//Na chwilę obecną wpisuję adres w przeglądarce, sprawdzam GETa
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
    }
}

//tutaj jeszcze sprawdzać,, że jak user jest zalogowany to przekierowywać go do index.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //var_dump($_POST);
    if (isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5 && isset($_POST['password']) && strlen(trim($_POST['password'])) >= 6) {

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $user = User::login($conn, $email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            header('Location: index.php');
        } else {
            echo 'Niepoprawne dane logowania!';
        }
    } else {
        echo 'Niepoprawne dane logowania';
    }
}
?>

<html>
<head>
    <link href="style/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
</head>
<body>
<div class="container">
    <div class='col-xs-12 col-sm-6 col-sm-offset-3'>
        <div class='page-header'>
            <h1>Login</h1>
        </div>
        <div class='panel'>
            <div class='panel-body'>
                <form method="POST">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Password">
                    </div>
                    <br>
                    <input type="submit" value="Enter" class="btn btn-info btn-md">
                </form>
                <br>
                <label>
                    New to Twitter?
                </label>
                <a href="register.php" class="btn btn-info btn-md">Create Account</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

