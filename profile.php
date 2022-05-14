<?php
    include 'header.php';
    include "dbconnect.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
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

    if (isset($_GET['u'])) {
        $currID = $_GET['u'];
    } else {
        $currID = $_SESSION["uid"];
    }
    
    // Get user data
    $query = "SELECT username, fname, lname, city, country, bio, certified, sect, reputation
     FROM `Users` 
     WHERE uid = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $currID);
    $stmt->execute();
    $result = $stmt->get_result();
    foreach($result as $row) {
        extract($row);
    }

    // HEADER
    echo "<h1>". $fname . " " . $lname . "</h1>";
    echo "@".$username . " - ";
    echo $city . ", " . $country . " - ";
    echo $sect . " - ";
    echo $reputation;
    echo "</br></br><p><i>" . $bio . "</i></p>";

    // QUESTIONS
    echo "</br><h4 style='font-weight: semibold;'>Questions:</h4>";

    // Get questions data
    $query = "SELECT * FROM `Questions` WHERE uid = ? ORDER BY qdate DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $_SESSION["uid"]);
    $stmt->execute();
    $result = $stmt->get_result();

    // Print question data
    foreach($result as $row) {
        extract($row);
        echo "
        <div>
        <table class='table table-hover'>
            <td>
            <strong>
                $title
            </strong>
            </br>
            <a href=profile.php?u=".$uid.">@".$username."</a>
            </br></br>
            <blockquote>
                $body
            </blockquote>

            <div class='d-flex mt-1 justify-content-end'>
                <p style='font-weight:bold;'>$qdate</p> 
                <div class='pl-5'><a href='question.php?qid=".$qid."'>See more</a></div>
            </div>
            </td>
        </table>
        </div>
        "; 
    } 

    // MY ANSWERS
    echo "</br></br><h4>Answers:</h4>";

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
        echo "
        <div>
        <table class='table table-hover'>
            <td>
            <strong>
                $q
            </strong>
            </br></br>
            <blockquote>
                $a
            </blockquote>

            <div class='d-flex mt-1 justify-content-end'>
                <p style='font-weight:bold;'>$qdate</p> 
                <div class='pl-5'><a href='question.php?qid=".$qid."'>See more</a></div>
            </div>
            </td>
        </table>
        </div>";
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