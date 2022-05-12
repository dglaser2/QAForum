<?php
    include 'header.php';
    include "dbconnect.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
</body>
</html>

<?php

$con = OpenCon();

// AUTHENTICATE
if (isset($_SESSION["uid"])) {
    
    // Get user data
    $query = "SELECT username, fname, lname, city, country, bio, certified, sect, reputation
     FROM `Users` 
     WHERE uid = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach($result as $row) {
        extract($row);
    }

    // PROFILE HEADER
    echo "<h1>". $fname . " " . $lname . "'s Profile</h1>";
    echo "@".$username . " - ";
    echo $city . ", " . $country . " - ";
    echo $sect . " - ";
    echo $reputation;
    echo "<p><i>" . $bio . "</i></p>";

    // MY QUESTIONS
    echo "<h2>My Questions:</h2>";

    // Get question data
    $query = "SELECT * FROM `Questions` WHERE uid = ? ORDER BY qdate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print question data
    foreach($result as $row) {
        extract($row);
        echo "<item>
        <h4>$title</h4>
        <description>$body</description>
        <p>$qdate</p>
        </item>"; 
    } 

    // MY ANSWERS
    echo "<h2>My Answers:</h2>";

    // Get answers data
    $query = "SELECT questions.title as q, answers.body as a, qdate
    FROM `Answers` join `Questions` using (qid) 
    WHERE answers.uid = ? ORDER BY adate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print answers data
    foreach($result as $row) {
        extract($row);
        echo "<item>
        <h4>$q</h4>
        <description>$a</description>
        <p>$qdate</p>
        </item>"; 
    }

} else {
    // Redirect user to welcome page
    header("location: logout.php");
    // error: please login to view!
}
CloseCon($con);
?>
