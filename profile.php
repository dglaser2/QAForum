<?php
    include "dbconnect.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
</html>

<?php

$con = OpenCon();

// AUTHENTICATE
// if (isset($_SESSION["uid"])) {
//
//} else { go to login page}

echo "<h1>". $_SESSION["username"] . "'s Profile</h1>";

// MY QUESTIONS
echo "<h2>My Questions</h2>";

$query = "SELECT * FROM `Questions` WHERE uid = ? ORDER BY qdate DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $_SESSION["uid"]);

$stmt->execute();

// mysqli_stmt_store_result($stmt);
$result = $stmt->get_result();
// if(mysqli_stmt_num_rows($stmt) > 0) {
//     // echo 'got it';
//     mysqli_stmt_bind_result($stmt, $qid, $uid, $title, $body, $topid, $qdate, $resolved);
//     mysqli_stmt_fetch($stmt);
// }

foreach($result as $row) {

    extract($row);

    echo "<item>
    <h4>$title</h4>
    <description>$body</description>
    </item>"; 
} 

// MY ANSWERS
echo "<h2>My Answers</h2>";

$query = "SELECT questions.title as q, answers.body as a  
FROM `Answers` join `Questions` using (qid) 
WHERE answers.uid = ? ORDER BY adate DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $_SESSION["uid"]);

$stmt->execute();

// mysqli_stmt_store_result($stmt);
$result = $stmt->get_result();
// if(mysqli_stmt_num_rows($stmt) > 0) {
//     // echo 'got it';
//     mysqli_stmt_bind_result($stmt, $qid, $uid, $title, $body, $topid, $qdate, $resolved);
//     mysqli_stmt_fetch($stmt);
// }

foreach($result as $row) {

    extract($row);

    echo "<item>
    <h4>$q</h4>
    <description>$a</description>
    </item>"; 
} 

?>
