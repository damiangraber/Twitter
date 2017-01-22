<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['id'];
    if ($userId == $_SESSION['user_id']) {
        header('Location: account.php');
    };


    require_once 'src/User.php';
    require_once 'connection.php';
    require_once 'src/Tweet.php';

    $fUser = User::loadUserById($conn, $userId);
    $fUserName = $fUser->getName();

    $fUserTweets = Tweet::loadAllTweetByUserId($conn, $userId);

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

    <div class="container">
        <div class='col-xs-12 col-sm-6 col-sm-offset-3'>
            <div class='page-header'>
                <h1><?php echo "Konto użytkownika " . $fUserName; ?></h1>
            </div>

            <div class='panel'>
                <div class='panel-body'>
                    <form action="createMessage.php" method="post">
                            <input type="hidden" name="recipientId" value="<?php echo $userId?>" class="form-control"/>
                        <p>
                            <button class='btn btn-primary'>Wyślij wiadomość</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>

    </html>

    <?php


    rsort($fUserTweets);
    foreach ($fUserTweets as $singleUserTweet) {

        echo '<div align="center">';
        echo $singleUserTweet->getCreationDate() . '<br>';
        echo '<textarea rows="3" cols="50" style="resize: none" disabled>' . $singleUserTweet->getTweetContent() . '</textarea>' . '<br><br>';
        echo '</div>';

    }

}

?>