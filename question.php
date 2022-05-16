<?php
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
    <div class="p-4">

        <?php

        $con = OpenCon();
        $currUID = $_SESSION['uid'];

        // AUTHENTICATE
        if (isset($_SESSION["uid"])) {

            if (isset($_GET['qid'])) {
                $currID = $_GET['qid'];
            } else {
                echo "Error finding question.";
            }

            // Get question data
            $query = "SELECT * FROM `Questions` join `Users` using (uid) WHERE qid = ? ORDER BY qdate DESC";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $currID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Print question data
            foreach ($result as $row) {
                extract($row);
                echo "
        <item>
        <h2>$title</h2>
        <a href=profile.php?u=" . $uid . ">@" . $username . "</a><p>" . $qdate . "</p>
        
        </br></br>       
        </br></br>
        <h4>$body</h4>
        </item>";
            }
        ?>

            <!-- ANSWERS -->
            </br></br></br>
            <h2>Answers:</h2>
            <form action="" method="post">
                <div class="form-outline">
                    <label class="form-label">Post an answer</label>
                    <textarea class="form-control" name="body" rows="4" height="30" placeholder="Be specific..."></textarea>
                </div>
                </br>
                <input type="submit" name="" class="btn btn-primary">
            </form>
        <?php

            // POST ANSWER
            if ($_REQUEST['body']) {
                $uid = $_SESSION['uid'];
                $body = $_REQUEST['body'];
                $qid = $currID;
                $adate = date("Y-m-d H:i:s");
                $query = "INSERT into Answers (uid, qid, body, adate)
    VALUES ('$uid', '$qid', '$body', '$adate')";

                if ($result = $con->query($query)) {
                    echo '<script>console.log("Answer posted!"); </script>';
                    header("location: question.php?qid=" . $qid);
                    unset($_REQUEST);
                } else {
                    echo "Error posting question";
                }
            }


            // VIEW ANSWERS
            $query = "SELECT answers.aid, answers.uid, users.username, body, count(Likes.uid) as lcount
            FROM `Answers` JOIN `Users` using (uid) left outer JOIN `Likes` using (aid)
            WHERE qid = ?
            group by answers.aid, users.username, body
            ORDER BY adate DESC";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $currID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Print answers data

            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    extract($row);

                    $like_check_query = "SELECT * FROM `LIKES` WHERE uid='$currUID' and aid='$aid' LIMIT 1";

                    $result = $con->query($like_check_query);

                    if ($result->num_rows > 0) {
                        // ALREADY LIKED
                        echo "
                        <div>
                        <table class='table table-hover'>
                            <td>
                                <div class='d-flex'>
                                    <strong class='mt-2'>
                                    <a href='profile.php?u=" . $uid . "'>@" . $username . "</a>
                                    </strong>
                                    <form action='question.php?qid=" . $qid . "&likedans=" . $aid . "' id='likeform' method='post'>
                                    <input type='submit' name='like' class='btn btn-light ml-2' form='likeform' value ='Like' disabled=''/>
                                    </form>
                                    <h6 class='ml-2 mt-2'>" . $lcount . "</h6>
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
                        // ENABLE LIKE BUTTON
                        echo "
                        <div>
                        <table class='table table-hover'>
                            <td>
                                <div class='d-flex'>
                                    <strong class='mt-2'>
                                    <a href='profile.php?u=" . $uid . "'>@" . $username . "</a>
                                    </strong>
                                    <form action='question.php?qid=" . $qid . "&likedans=" . $aid . "' id='likeform' method='post'>
                                    <input type='submit' name='like' class='btn btn-light ml-2' form='likeform' value ='Like' />
                                    </form>
                                    <h6 class='ml-2 mt-2'>" . $lcount . "</h6>
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
                    }
                }
                if ($_GET['likedans']) {
                    $aid = $_GET['likedans'];
                    $uid = $_SESSION['uid'];
                    $query = "INSERT into Likes (aid, uid)
                    VALUES ('$aid', '$uid')";

                    if ($result = $con->query($query)) {
                        echo '<script>console.log("Post liked!"); </script>';
                        echo "<script>window.location.href='question.php?qid=$qid';</script>";
                    } else {
                        echo "Error liking answer";
                        echo "<script>window.location.href='question.php?qid=$qid';</script>";
                    }
                }
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