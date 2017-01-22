<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && isset($_POST['recipientId'])) {
    $recipientId = trim($_POST['recipientId']);

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
                            <input type="hidden" class='form-control' id='recipient' name="recipient"
                                   value="<?php echo $recipientId ?>">
                            <label>Tytuł:</label>
                            <input type="text" class='form-control' id='title' name="title">
                            <label>Treść:</label>
                            <input type="text" class='form-control' id='content' name='content'>
                        </div>
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
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && strlen(trim($_POST['title'])) > 0
    && isset($_POST['content']) && strlen(trim($_POST['content'])) > 0
    && isset($_POST['recipient']) && strlen(trim($_POST['recipient'])) > 0
) {
    $userId = trim($_SESSION['user_id']);
    $recipient = trim($_POST['recipient']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    require_once "src/Message.php";
    require_once "connection.php";

    $message = new Message();
    $message->setUserId($userId);
    $message->setRecipientId($recipient);
    $message->setTitle($title);
    $message->setContent($content);

    if ($message->saveToDB($conn)) {
        echo 'Wiadomość została wysłana!';
        ?>
        <div class="container">
            <a href="index.php">Przejdź do strony głównej</a>
            <br>
        </div>
        <?php

    } else {
        echo 'Błąd przy wysyłaniu wiadomości, spróbuj ponownie';
    }
};

/*

$('.btn').click(function(e) {
  if ($('input').val() === '') {
    e.preventDefault();
    alert('input is empty');
  }
});

 */


?>







