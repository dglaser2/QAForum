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
        <p>".$qdate."</p></br>
        <h4>$body</h4>
        </item>"; 
    } 
?>

<!-- ANSWERS -->
</br></br></br><h2>Answers:</h2>
<div class="form-outline">
            <label class="form-label">Post an answer</label>
             <textarea class="form-control" name="body" rows="4" height="30" placeholder="Be specific..."></textarea>
            </div>
    </br>
    <!-- TOPIC DROPDOWN HERE -->
            <div class="form-group">
                <input type="submit" value="Post" class="btn btn-primary" name="submit" >
            </div>

<?php
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
            echo "
            <div>
            <table class='table table-hover'>
                <td>
                    <div class='d-flex'>
                        <strong>
                        <a href='profile.php?u=".$uid."'>@".$username."</a>
                        </strong>
                        <button type='button' class='btn btn-success'>Best answer</button>
                        <button type='button' class='btn btn-light'>Like</button>
                    </div>
                    </br>
                    <blockquote>
                        $body
                    </blockquote>
        
                    <div class='d-flex mt-1 justify-content-end'>
                        <p style='font-weight:bold;'>$adate</p> 
                        <div class='pl-5'></div>
                    </div>
                </td>
            </table>
            </div>";
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