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
    <title>Question</title>
</head>
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

    ?>

<!DOCTYPE html>
<html>
<body>

<footer>
</br></br></br></br></br></br>
  <a href="logout.php">Logout</a></p>
</footer>
</body>
</html>

<?php

} else {
    // Redirect user to welcome page
    header("location: logout.php");
    // error: please login to view!
}
CloseCon($con);
?>
