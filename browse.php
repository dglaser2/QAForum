<?php
    include 'header.php';  
    include "dbconnect.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 800px; padding: 20px;}
    </style>
</head>
<body>
<div class="pl-4 pt-4">
    <h1> Pocket Rabbi </h1>
    <div class="d-flex pr-4 justify-content-end">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Topics
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>

<?php
$con= OpenCon();

    // Get questions data
    $query = "SELECT * FROM `Questions` JOIN `Users` using (uid) ORDER BY qdate DESC";
    $stmt = $con->prepare($query);
    // $stmt->bind_param("i", $_SESSION["uid"]);
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
            <div style='max-width: 1000px;'>
                $body
            </div>

            <div class='d-flex mt-1 justify-content-end'>
                <p style='font-weight:bold;'>$qdate</p> 
                <div class='pl-5 pr-3'><a href='question.php?qid=".$qid."'>See more</a></div>
            </div>
            </td>
        </table>
        </div>
        "; 
    } 

    CloseCon($con);

?>

</body>
</html>