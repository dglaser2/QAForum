<?php
include "dbconnect.php";
?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark navbar-center">

  <div class="container-fluid">
    <a class="navbar-brand" href="browse.php">
        <img src="logo.png" alt="Logo" style="width:50px;" class="rounded-pill">
        <!-- <label for="exampleFormControlSelect1">Pocket Rabbi</label> -->
    </a>
    <form class="d-flex mt-3 ml-2"  method = "post" action = "browse.php">
        <input class="form-control me-2" type="text" name = "searchbar" placeholder="Search">
        <input class="btn btn-primary" type="submit" value = "Search">
      </form>
      <?php
        $con = OpenCon();
        $keyword = $_REQUEST['searchbar'];
        //echo "hello";
        CloseCon($con);
      ?>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- NAVBAR BUTTONS -->
    <div class="collapse navbar-collapse pt-2" id="mynavbar">
      <ul class="navbar-nav ml-auto">


        <li class="nav-item">
          <a class="nav-link" href="browse.php">Browse</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="postq.php">Ask a Question</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>

  </div>
</nav>
