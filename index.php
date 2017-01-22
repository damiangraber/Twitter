<?php
session_start();

//var_dump($_POST);

//wyświetlic sesje zeby zobaczyc kto jest zalogowaney!
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tweet'])) {
    if (strlen(trim($_POST['tweet'])) > 0) {

        require_once 'connection.php';
        require_once 'src/Tweet.php';

        $tweet = new Tweet();
        $tweet->setTweetContent(trim($_POST['tweet']));
        $tweet->setUserId($_SESSION['user_id']);

        if ($tweet->saveToDB($conn)) {
            echo 'Nowy tweet został dodany!';

        } else {
            echo 'Błąd przy dodawaniu tweeta, spróbuj ponownie';
        }
    } else {
        echo "Tweet nie może być pusty!";
    }
}


if (isset($_SESSION['user_id'])) {

    require_once 'src/Tweet.php';
    require_once 'connection.php';
    require_once 'src/Comment.php';
    require_once 'src/User.php';


    $userId = $_SESSION['user_id'];

    $loggedUser = User::loadUserById($conn, $userId);
    $loggedUserName = $loggedUser->getName();

}

?>

<html>
<head>
    <link href="style/style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
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
            <h1>Welcome,
                <?php echo $loggedUserName . '!' ?></h1>
        </div>

        <div class='panel'>
            <div class='panel-body'>
                <form action="index.php" method="post">
                    <label>
                        Dodaj tweet:<br>
                        <input type="text" name="tweet" class="form-control"/>
                    </label>
                    <br>
                    <p>
                        <button class='btn btn-primary'>Dodaj</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<br>
<br>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_POST['tweetId'])) {
    if (strlen(trim($_POST['comment'])) > 0) {

        require_once 'connection.php';
        require_once 'src/Comment.php';

        $comment = new Comment();
        $comment->setText(trim($_POST['comment']));
        $comment->setUserId($_SESSION['user_id']);
        $comment->setTweetId(trim($_POST['tweetId']));

        if ($comment->saveToDB($conn)) {
            echo 'Nowy komentarz został dodany!';
            //lepiej rzucić tutaj jakiś wyjątek!

        } else {
            echo 'Błąd przy dodawaniu komentarza, spróbuj ponownie';
        }
    } else {
        echo "Komentarz nie może być pusty!";
    }
}



$allTweets = Tweet::loadAllTweets($conn);

foreach ($allTweets as $singleTweet) {

    $allComments = Comment::loadAllCommentsByTweetId($conn, $singleTweet->getId());

    $query = "SELECT name FROM Users WHERE id = " . $singleTweet->getUserId();
    $res = $conn->query($query);
    $row = $res->fetch_assoc();
    foreach ($row as $name) {


        ?>

        <div align="center">
            <a href="fUser.php?id= <?php echo $singleTweet->getUserId(); ?> ">  <?php echo $name; ?> </a>
            napisał dnia <?php echo $singleTweet->getCreationDate(); ?>
            <br>
            <div class="form-group">
            <textarea id="inner" rows="3" cols="50" style="resize: none"
                      disabled> <?php echo $singleTweet->getTweetContent(); ?>
            </textarea>
            </div>
        </div>
        <br>
        <div align="center">
            Comments:
            <?php
            foreach ($allComments as $singleComment) {
                $commentUserId = $singleComment->getUserId();
                $commentText = $singleComment->getText();
                $commentCreationDate = $singleComment->getCreationDate();
                $query = "SELECT name FROM Users WHERE id = " . $commentUserId;
                $res = $conn->query($query);
                $names = $res->fetch_assoc();
                foreach ($names as $name) {
                    echo $name . ' napisał: ' . "'" . $commentText . "' " . 'dnia: ' . $commentCreationDate . '<br>';
                }
            }
            ?>

            <form action="index.php" method="post">
                <label>
                    Add comment to Tweet:<br>
                    <input type="text" name="comment" class="form-control input-sm"/>
                    <input type="hidden" name="tweetId" value="<?php echo $singleTweet->getID(); ?>">
                </label>
                <br>
                <p>
                    <button class="btn btn-info btn-sm">Dodaj</button>
                </p>
            </form>
            <br>
        </div>

        <?php
    }

}

?>




