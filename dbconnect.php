<?php

function OpenCon() {
    $db = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbhost = "prabbi";
    $conn = new mysqli($db, $dbuser, $dbpass,$dbhost) or die("Connect failed: %s\n". $conn -> error);
     
    return $conn;
}


function CloseCon($conn)
{
$conn -> close();
}
?>