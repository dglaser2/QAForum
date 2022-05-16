<?php
include 'header.php';
session_start();
unset($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post Question</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 400px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="pl-4 pt-4">
        <h1> Ask a Question </h1>

        <?php
        // if(!empty($post_err)){
        //     echo '<div class="alert alert-danger">' . $post_err . '</div>';
        // }        
        ?>
        <br>
        <br>
        <br>

        <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            </br> </br></br>
            <select class="form-control" name="top" id="select">
                    <option selected value="0">All Topics</option>
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
                <br>
                <br>
                <br>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="What's the shpiel?" required>
                <span class="invalid-feedback"><?php echo $post_err; ?></span>
            </div>
            <div class="form-outline">
                <label class="form-label">Body</label>
                <textarea class="form-control" name="body" rows="10" height="80" placeholder="Be specific..."></textarea>
            </div>
            </br>
            <!-- TOPIC DROPDOWN HERE -->
            <input type="submit" class="btn btn-primary">
            

        </form>
        </form>
    </div>
</body>

</html>

<?php
$con = OpenCon();
if (isset($_SESSION['uid'])) {
    
    $uid = $_SESSION['uid'];
    $title = $_REQUEST['title'];
    $body = $_REQUEST['body'];
    $topid = $_REQUEST['top'];                 // NEED TO INSERT CORRECT TOPIC
    // $topid = 1;          // NEED TO INSERT CORRECT TOPIC
    $qdate = date("Y-m-d H:i:s");
    //echo $topid;
    if ($body && $title && $topid) {
        // echo 'hi';
        $query = "INSERT into Questions (uid, title, body, topid, qdate)
        VALUES ('$uid', '$title', '$body', '$topid', '$qdate')";

        if ($result = $con->query($query)) {
            echo '<script>console.log("Question posted!"); </script>';
            unset($_POST);
            header("location: browse.php");
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