<?php
    include "dbconnect.php";
    include "header.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question Details</title>
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 800px; padding: 20px; }
    </style>
</head>
<body>
<div class="p-4">

<?php

$con = OpenCon();

// AUTHENTICATE
if (isset($_SESSION["uid"])) {
    
    if (isset($_GET['qid'])) {
        $currID = $_GET['qid'];
    } else {
        echo "Error finding question.";
    }

    // Get question data
    $query = "SELECT * FROM `Questions` WHERE qid = ? ORDER BY qdate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $currID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print question data
    foreach($result as $row) {
        extract($row);
        echo "
        <item>
        <h2>$title</h2>
        <p>".$qdate."</p>
        <h4>$body</h4>
        </item>"; 
    } 

    // MY ANSWERS
    echo "<h2>Answers:</h2>";

    // Get answers data
    $query = "SELECT * FROM `Answers` JOIN `Users` using (uid) WHERE qid = ? ORDER BY adate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $currID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print answers data

    if ($result->num_rows > 0)
    foreach($result as $row) {
        extract($row);
        echo "<item>
        <b> @" . $username ." - ".$adate."</b>
        <body>".$body." </body>
        </item>"; 
    } else {
        echo "No answers yet.";
    }

} else {
    // Redirect user to welcome page
    header("location: logout.php");
    // error: please login to view!
}
CloseCon($con);
?>

</div>
</body>
</html>