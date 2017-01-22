<?php

session_start();

if (isset($_SESSION['user_id'])) {

    require_once 'src/Message.php';
    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        if (strlen($_POST['id']) > 0) {

            $messageId = $_POST['id'];
            $message = Message::loadMessageById($conn, $messageId);

            if ($message->getIsRead() == 0) {
                $message->saveToDB($conn);
            }

        }
    }
}


?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Wiadomość</title>
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
            <h1>Wiadomość</h1>
        </div>

        <div class='panel'>
            <div class='panel-body'>
                <form action="createMessage.php" method="post">
                    <div class='form-group'>
                        <label>Od:</label>
                        <input type="text" class='form-control' id='sender' name="title"
                               value="<?php echo $message->getUserId(); ?>">
                        <label>Wysłana dnia:</label>
                        <input type="text" class='form-control' id='creation_date' name="title"
                               value="<?php echo $message->getCreationDate(); ?>">
                        <label>Tytuł:</label>
                        <input type="text" class='form-control' id='title' name="title"
                               value="<?php echo $message->getTitle(); ?>">
                        <label>Treść:</label>
                        <input type="text" class='form-control' id='content' name='content'
                               value="<?php echo $message->getContent(); ?>">
                    </div>
                    <p>
                        <input type="button" class="btn btn-info" value="Input Button"
                               onclick="location.href = 'https://www.google.com';">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>

<html>
<head>
    <link href="style/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
</head>
</html>
