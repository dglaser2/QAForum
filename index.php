<html>
  <body>
    <h1>My Bakery</h1>
<?php

ini_set( 'error_reporting', E_ALL );
ini_set( 'display_errors', true );

include 'dbconnect.php';

?>

<form action="searchcust.php">
    Customer ID:<br>
  <input type="text" name="custid"><br>
  <input type="submit" value="Search">
</form>

<?php

$mysqli->close();
?>


    </body>
</html>