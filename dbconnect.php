<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "studentdb";
 $dbpass = "ChickensStudent16";
 $db = "PRabbi";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
?>

<!-- /* check connection */
// if ($mysqli->connect_errno) {
//     printf("Connect failed: %s\n", $mysqli->connect_error);
//     exit();
// } -->