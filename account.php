<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

require_once 'connection.php';
require_once 'src/User.php';
require_once 'src/Tweet.php';

$connectedUserId = $_SESSION['user_id'];

$loggedUser = User::loadUserById($conn, $connectedUserId);

$loggedUserId = $loggedUser->getId();
$loggedUserEmail = $loggedUser->getEmail();
$loggedUserName = $loggedUser->getName();
$loggedUserPassword = $loggedUser->getPassword();


$userTweets = Tweet::loadAllTweetByUserId($conn, $loggedUserId);

?>


<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Konto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/style.css" rel="stylesheet">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <script src="js/app.js"></script>
</head>
<body>
<nav class="navbar navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><img src="img/chameleon.png"></a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li><a href="account.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
            <li><a href="messagesBox.php"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Sign out</a></li>
        </ul>
    </div>
</nav>
<br>
<div class="container">
    <div class='col-xs-12 col-sm-6 col-sm-offset-3'>
        <div class='page-header'>
            <h1>Profile details</h1>
        </div>

        <div class='panel'>
            <div class='panel-body'>
                <form action="account.php" method="post">
                    <div class='form-group'>
                        <label>Email:</label>
                        <input type="text" class='form-control' id='email' name="email"
                               value="<?php echo $loggedUserEmail ?>" disabled>
                        <label>Name:</label>
                        <input type="text" class='form-control' id='name' name="name"
                               value="<?php echo $loggedUserName ?>">
                        <label>Current password:</label>
                        <input type="password" class='form-control' id='oldpass' name="oldpass" value="">
                        <label>New password:</label>
                        <input type="password" class='form-control' id='pass1' name="pass1" value="">
                        <label>Retype password:</label>
                        <input type="password" class='form-control' id='pass2' name="pass2" value="">
                    </div>

                    <p>
                        <button class='btn btn-primary'>Save changes</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['oldpass']) && strlen($_POST['oldpass']) > 5 && strlen($_POST['pass1']) > 5 && password_verify($_POST['oldpass'], $loggedUserPassword)
        && $_POST['pass1'] == $_POST['pass2']
    ) {
        $updatedName = $_POST['name'];
        $updatedPassword = $_POST['pass1'];
        $loggedUser->setName(mysqli_real_escape_string($conn, $updatedName));
        $loggedUser->setPassword(mysqli_real_escape_string($conn, $updatedPassword));
        if($loggedUser->saveToDB($conn)) {
            echo 'Połączono z bazą!';
        }
        else {
            echo 'Brak połączenia';
        };

        echo 'Dane zaktualizowane';
    } else {
        echo 'Niepoprawne dane!';
    }
    //header("Refresh:0");
}



?>

<div class="container">
<div class="class='col-xs-12 col-sm-6 col-sm-offset-3" >
    <label>
        Tweety
    </label>
</div>
</div>

<?php
rsort($userTweets);
foreach ($userTweets as $singleUserTweet) {

echo '<div align="center">';
    echo 'Napisałeś/aś dnia ' . $singleUserTweet->getCreationDate() . '<br>';
    echo '<textarea rows="3" cols="50" style="resize: none" disabled>' . $singleUserTweet->getTweetContent() . '</textarea>' . '<br><br>';
    echo '</div>';

}
?>