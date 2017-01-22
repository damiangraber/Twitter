<?php 

require_once '../src/User.php';
require_once '../connection.php';

$user = User::loadUserById($conn, 3);
$user->setName('User41');
var_dump($user->saveToDB($conn));

$user = User::loadUserById($conn, 3);
var_dump($user);



$conn->close();
$conn = NULL;


?>
