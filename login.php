<?php
require_once 'src/User.php';
require_once 'connection.php';
session_start();

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
    <head></head>
    <body>
        <form method="POST">
            <label>
                E-mail:<br>
                <input type="text" name="email">
            </label>
            <br>
            <label>
                Password:<br>
                <input type="password" name="password">                
            </label>
            <br>
            <input type="submit" value="Login">
        </form>
    </body>
</html>