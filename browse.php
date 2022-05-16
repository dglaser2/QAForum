<?php
include 'header.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 800px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="pl-4 pt-4">
        <h1> Pocket Rabbi </h1>
        <div class="d-flex pr-4 justify-content-end">
            <div class="btn-group btn-group-toggle pb-4 pr-4" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="option1" checked> Questions
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="option2"> Answers
                </label>
            </div>
            <div class="btn-group btn-group-toggle pb-4 pr-4" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="option1" checked> Newest
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" id="option2"> Oldest
                </label>
            </div>
            <form method="post" id="top">
                <!-- <label for="topicForm">Browse by Topic:</label> -->
                <select class="form-control" name="top" id="select">
                    <option selected value="">All Topics</option>
                    <option value="1">Holidays</option>
                    <option value="2">&nbsp;&nbsp;Passover</option>
                    <option value="3">&nbsp;&nbsp;Yom Kippur</option>
                    <option value="4">&nbsp;&nbsp;Shabbat</option>
                    <option value="6">Kosher</option>
                    <option value="5">&nbsp;&nbsp;Cooking</option>
                    <option value="7">Prayer</option>
                    <option value="8">&nbsp;&nbsp;Individual</option>
                    <option value="9">&nbsp;&nbsp;Synagoguge</option>
                    <option value="10">Torah</option>
                    <option value="11">&nbsp;&nbsp;Talmud</option>
                    <option value="12">&nbsp;&nbsp;Chumash</option>
                </select>
                <input type="submit" >
            </form></br>
        </div>
        <div>

        <?php
        $con = OpenCon();
        if($keyword){
            if($keyword){
          header("header.php");
        $query = "SELECT * from Questions JOIN `Users` using(uid)  where 
          `title` LIKE '%{$keyword}%' or
	        `body` LIKE '%{$keyword}%'
          ORDER BY qdate DESC";
        //echo "so far so good";
        if ($result = $con->query($query)) {
            foreach ($result as $row) {
            extract($row);
            echo "
    <div>
    <table class='table table-hover'>
        <td>
        <strong>
            $title
        </strong>
        </br>
        <a href=profile.php?u=" . $uid . ">@" . $username . "</a>
        </br></br>
        <div style='max-width: 1000px;'>
            $body
        </div>

        <div class='d-flex mt-1 justify-content-end'>
            <p style='font-weight:bold;'>$qdate</p> 
            <div class='pl-5 pr-3'><a href='question.php?qid=" . $qid . "'>See more...</a></div>
        </div>
        </td>
    </table>
    </div>
    ";
        }
      }
      if($result->num_rows < 1){ 
          echo "No results. Sorry :)";
      }
            //header("location: browse.php");
        }  else {
            echo "Error posting question";
        }
        }
        else{
        // Get questions data
        if (isset($_GET['top'])) {
            $query = "SELECT * FROM `Questions` JOIN `Users` using (uid) WHERE topid=? ORDER BY qdate DESC";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $_GET['top']);
        } else {
            $query = "SELECT * FROM `Questions` JOIN `Users` using (uid) ORDER BY qdate DESC";
            $stmt = $con->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Print question data
        if ($result->num_rows == 0) {
            echo "No questions yet.";
        }

        foreach ($result as $row) {
            extract($row);
            echo "
    <div>
    <table class='table table-hover'>
        <td>
        <strong>
            $title
        </strong>
        </br>
        <a href=profile.php?u=" . $uid . ">@" . $username . "</a>
        </br></br>
        <div style='max-width: 1000px;'>
            $body
        </div>

        <div class='d-flex mt-1 justify-content-end'>
            <p style='font-weight:bold;'>$qdate</p> 
            <div class='pl-5 pr-3'><a href='question.php?qid=" . $qid . "'>See more...</a></div>
        </div>
        </td>
    </table>
    </div>
    ";
        }
    }
        CloseCon($con);

        ?>

</body>

</html>