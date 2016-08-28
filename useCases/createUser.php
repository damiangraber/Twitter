<?php 

require_once '../src/User.php'; //w ten sposób wchodzimy na poziom wyżej!
require_once '../connection.php';

$user1 = new User();
$user1->setName('Damian');
$user1->setEmail('damian.graver@gmail.com');
$user1->setPassword('password1');

var_dump($user1->saveToDB($conn));

$conn->close();
$conn = NULL;


?>
