<?php 

require_once '../src/User.php';
require_once '../connection.php';

$User = User::loadUserById($conn, 1);
var_dump($User);


$user2 = User::loadUserById($conn, 342);
var_dump($user2);


$conn->close();
$conn = NULL;

?>
