<?php
    include "dbconnect.php";
    session_start();
    unset($_REQUEST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h1>
        Ask a question:
    </h1>

<?php
    $con = OpenCon();
    if (isset($_SESSION['uid'])) {
        // need to input: uid, title, body, topid, qdate (current date)
            
        $uid = $_SESSION['uid'];
        $title    = $_REQUEST['title'];
        $body    = $_REQUEST['body'];
        $qdate = date("Y-m-d H:i:s");

        if (isset($_REQUEST['body']) && isset($_REQUEST['title'])) {
            $query = "INSERT into Questions (uid, title ,body, qdate)
            VALUES ('$uid', '$title', '$body','$qdate')";
            if ($result = $con->query($query)) {
                echo '<script>console.log("Question posted!"); </script>';
                unset($_REQUEST);
            }  else {
                echo "Error posting question";
            }
        }


    } else {
        // Redirect user to welcome page
        header("location: logout.php");
        // error: please login to view!
        }
        CloseCon($con);

?>
    <form class="form" action="" method="POST">
        <h2>Title</h2>
        <input type="text" class="login-input" name="title" required />
        <h2>Body</h2>
        <textarea id="body" name="body" rows="8" cols="80" required></textarea>
</br>
        <input type="submit" name="submit" value="Post" class="login-button">
    </form>
</body>
</html>