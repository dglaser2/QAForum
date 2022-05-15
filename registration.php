<?php
include "dbconnect.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pocket Rabbi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 500px;
            padding: 40px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Welcome to Pocket Rabbi!</h2>
        <p>Please fill in your credentials to sign up.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control" required>
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control" required>
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group">
                <label>E-mail Address</label>
                <input type="text" name="email" class="form-control" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Register">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>

</html>

<?php

// Initialize session

// Check if user is already logged in. If so, take to profile page
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//     header("location: profile.php");
//     exit;
// }

$con = OpenCon();

$username = $password = $email = $fname = $lname = "";
$username_err = $password_err = $login_err = $fname_err = $lname_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if empty
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter first name.";
    } else {
        $fname = trim($_POST["fname"]);
    }
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter last name.";
    } else {
        $lname = trim($_POST["lname"]);
    }
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (
        empty($username_err) && empty($fname_err)
        && empty($lname_err) && empty($email_err)
        && empty($password_err)
    ) {

        $fname = $_REQUEST['fname'];
        $lname = $_REQUEST['lname'];
        $username = $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $user_check_query = "SELECT * FROM Users WHERE username= '$username' OR email= '$email' LIMIT 1";

        if ($result1 = $con->query($user_check_query)) {
            $user = $result1->fetch_assoc();
            if ($user['username'] === $username) {
                echo "Username already exists. Please try another";
            }
            if ($user['email'] === $email) {
                echo "This email is already registed. Please try logging in
                or using a different email address.";
            }
        } else {
        $query = "INSERT into Users (username, email, pw, fname, lname)
                VALUES (?, ?, ?, ?, ?);";

        $stmt = $con->prepare($query);
        $stmt->bind_param('sssss', $username, $email, $password, $fname, $lname);
        $stmt->execute();

        session_start();
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["uid"] = mysqli_insert_id($con);
        $_SESSION["username"] = $username;

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: profile.php");
        } else {
            echo "error saving session.";
        }
    }
}
}
//  }

// }
CloseCon($con);

?>