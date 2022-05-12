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
            
         $fname    = $_REQUEST['fname'];
        $lname    = $_REQUEST['lname'];
         $username = $_REQUEST['username'];
         $email    = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $user_check_query = "SELECT * FROM Users WHERE username= '$username' OR email= '$email' LIMIT 1";
        
        //$result1->free();
        if($result1 = $con->query($user_check_query)){
            $user = $result1->fetch_assoc();
            if ($user['username'] === $username) {
                echo "username already exists. Please try another";
            }
            if($user['email']=== $email){
                echo "This email is already registed. Please try logging in
                or using a different email address.";
            }
        }
        else{
            $query    = "INSERT into Users (username, email, pw, fname, lname)
                     VALUES ('$username', '$email','$password', '$fname', '$lname')";
            if ($result = $con->query($query)) {
                echo "Congrats for becoming a pocket rabbi member!";
            }
            else {
                echo "Required fields are missing.";
            }
           }
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