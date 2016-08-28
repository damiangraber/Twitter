<?php
session_start();
//wyświetlic sesje zeby zobaczyc kto jest alogowaney!
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
?>

<html>
    <head></head>
    <body>
        Strona główna
        <?php
        if(isset($_SESSION['user_id'])) {
            echo '<a href="logout.php">Logout</a>';
        }
        ?>
    </body>
</html>


