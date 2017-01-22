<?php

session_start();
?>
    <html>
    <head>
        <link href="style/style.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
    <br>
    <div align="center">
        <h1>Wiadomości</h1>
    </div>

<?php
if (isset($_SESSION['user_id'])) {

    $userId = $_SESSION['user_id'];
    require_once 'connection.php';
    require_once 'src/Message.php';

    $messages = Message::loadAllMessagesByRecipientId($conn, $userId);


    foreach ($messages as $singleMessage) {
        $title = $singleMessage->getTitle();


        ?>
        <div align="center">
            <div class="container">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Od</th>
                        <th>Temat</th>
                        <th>Dnia</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class= style="<?php echo $singleMessage->getIsRead() ? '' : 'color: blue;'?>  >

                    <td><?php echo $singleMessage->userName; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $singleMessage->getCreationDate(); ?></td>
                    <td>
                        <form action="messageDetails.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $singleMessage->getId() ?>"
                                   class="form-control"/>
                            <p>
                                <button class='btn btn-primary'>Wyświetl wiadomość</button>
                            </p>
                        </form>
                    </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
        </body>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        </html>

        <?php
    }

}
?>