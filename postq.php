<?php
    include 'header.php';  
    include "dbconnect.php";
    session_start();
    unset($_REQUEST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 400px; padding: 20px; }
    </style>
</head>
<body>
<div class="pl-4 pt-4">
    <h1> Ask a Question </h1>

<?php 
        if(!empty($post_err)){
            echo '<div class="alert alert-danger">' . $post_err . '</div>';
        }        
?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    </br>  </br></br>
        <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="What's the shpiel?" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-outline">
            <label class="form-label">Body</label>
             <textarea class="form-control" name="body" rows="10" height="80" placeholder="Be specific..."></textarea>
            </div>
    </br>
    <!-- TOPIC DROPDOWN HERE -->
            <div class="form-group">
                <input type="submit" value="Post" class="btn btn-primary" name="submit" >
            </div>
        </form>
    </form>
    </div>
</body>
</html>

<?php
    $con = OpenCon();
    if (isset($_SESSION['uid'])) {
        // need to input: uid, title, body, topid, qdate (current date)
            
        $uid = $_SESSION['uid'];
        $title = $_REQUEST['title'];
        $body = $_REQUEST['body'];
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

</body>
</html>