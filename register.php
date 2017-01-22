<?php

//Sesja zostaje?
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 0
        && isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5
        && isset($_POST['password']) && strlen(trim($_POST['password'])) >= 6
        && isset($_POST['retyped_password'])
        && trim($_POST['password']) == trim($_POST['retyped_password'])
    ) {

        require_once 'connection.php';
        require_once 'src/User.php';

        $user = new User();
        $user->setName(trim($_POST['name']));
        $user->setEmail(trim($_POST['email']));
        $user->setPassword(trim($_POST['password']));

        if ($user->saveToDB($conn)) {
            echo 'Gratulacje, zarejestrowałeś się! Przejdź na stronę logowania ';
            echo '<a href="login.php">Login</a>';

        } else {
            echo 'Błąd przy rejestracji, spróbuj ponownie';
        }
    } else {
        echo 'Błędne dane w formularzu';
    }
}


?>


<html>
<head>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/app.js"></script>
    <link href="style/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
</head>
<body>

<div class="container">
    <div class='col-xs-12 col-sm-6 col-sm-offset-3'>
        <div class='page-header'>
            <h1>Create Account</h1>
        </div>
        <div class='panel'>
            <div class='panel-body'>
                <form method="POST">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password"
                               placeholder="Password">
                    </div>
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="retyped_password" type="password" class="form-control" name="retyped_password"
                               placeholder="Retype password">
                    </div>
                    <br>
                    <input type="submit" value="Register" class="btn btn-info btn-md">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>






