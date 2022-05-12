<?php
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
$test = 32;

// AUTHENTICATE
if (isset($_SESSION["uid"])) {

    // Get question data
    $query = "SELECT * FROM `Questions` WHERE qid = ? ORDER BY qdate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $test);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print question data
    foreach($result as $row) {
        extract($row);
        echo "<item>
        <h2>$title</h2>
        <h4>$body</h4>
        <p>$qdate</p>
        </item>"; 
    } 

    // MY ANSWERS
    echo "<h2>Answers:</h2>";

    // Get answers data
    $query = "SELECT * FROM `Answers` JOIN `Users` using (uid) WHERE qid = ? ORDER BY adate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $test);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print answers data
    foreach($result as $row) {
        extract($row);
        echo "<item>
        <b> @" . $username ." - ".$adate."</b>
        <body>".$body." </body>
        </item>"; 
    }

} else {
    // Redirect user to welcome page
    header("location: logout.php");
    // error: please login to view!
}
CloseCon($con);
?>
