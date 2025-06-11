<?php
$host = 'localhost';
$db = 'foodieclub';
$user = 'root';
$pass = '';

$con = mysqli_connect($host, $user, $pass, $db);


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
