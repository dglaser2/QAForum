<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "prabbi";

$mysqli = new mysqli($host, $username, $password, $db);

/* check connection */
// if ($mysqli->connect_errno) {
//     printf("Connect failed: %s\n", $mysqli->connect_error);
//     exit();
// }