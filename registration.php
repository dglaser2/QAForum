<?php
    include "dbconnect.php";
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
        Welcome New User! 
    </h1>

    <?php
        $con = OpenCon();
        if (isset($_REQUEST['username'])) {
            
        //$fname    = stripslashes($_REQUEST['fname']);
         $fname    = $_REQUEST['fname'];
        // // //$lname    = stripslashes($_REQUEST['lname']);
        $lname    = $_REQUEST['lname'];
        // // // removes backslashes
        // // // $username = stripslashes($_REQUEST[$_REQUEST['fname']]);
        // // //escapes special characters in a string
         $username = $_REQUEST['username'];
        // // //$email    = stripslashes($_REQUEST['email']);
         $email    = $_REQUEST['email'];
        // // //$password = stripslashes($_REQUEST['password']);
         $password = $_REQUEST['password'];
        // //$firstname = date("Y-m-d H:i:s");
        echo "$fname $lname's info:
                $username, $email, $password";
        $query    = "INSERT into Users (username, email, pw, fname, lname)
                     VALUES ('$username', '$email','$password', '$fname', '$lname')";
        $result   = $con->query($query);
        // if ($result) {
        //     echo "<div class='form'>
        //           <h3>You are registered successfully.</h3><br/>
                 
        //           </div>";
        // } else {
        //     echo "<div class='form'>
        //           <h3>Required fields are missing.</h3><br/>
        //           <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
        //           </div>";
         }
        CloseCon($con);
    ?>
    <form class="form" action="" method="POST">
        <h2 class="login-title">Registration</h2>
        <input type="text" class="login-input" name="fname" placeholder="First Name" required />
        <input type="text" class="login-input" name="lname" placeholder="Last Name" required />
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Adress" required />
        <input type="password" class="login-input" name="password" placeholder="Password"required />
        <input type="submit" name="submit" value="Register" class="login-button">
        <!-- <p class="link"><a href="login.php">Click to Login</a></p> -->
    </form>
</body>
</html>

