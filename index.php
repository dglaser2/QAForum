<html>
  <body>
    <h1>Pocket Rabbi</h1>
<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

session_start();
include 'dbconnect.php';
include 'header.php';

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

if (isset($_SESSION['uid'])) {
  // Redirect user to welcome page
  header("location: browse.php");
} else {
  header("location: login.php");
}

?>
  </body>
</html>