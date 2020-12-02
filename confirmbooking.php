<?php
session_start();
include("Locations.php");
include("Rides.php");
if(isset($_SESSION['id'])){
  if($_SESSION['usertype'] != '0') {
      header("location:admin/admindashboard.php");
  }
} else {
  header("location:userdashboard.php");
}
// $loc = new Locations();
// $db = new config();
// $sql = $loc->select_loc($db->conn);
    $from = $_SESSION['booking']['from'];
    $to = $_SESSION['booking']['to'];
    $luggage = $_SESSION['booking']['luggage'];
    $fare = $_SESSION['booking']['fare'];
    $distance = $_SESSION['booking']['total_distance'];
    // $cabtype = $_SESSION['booking']['cabtype'];
    $user_id = $_SESSION['id'];
    $status = '1';
    if(isset($_GET['action'])){
      $obj = new Rides();
      $db = new config();
      $sql = $obj->insert($from, $to, $luggage, $fare, $distance, $user_id, $status, $db->conn);
      header("location:requestedride.php");
      unset($_SESSION['booking']);
    } 

    if(isset($_GET['cancel'])) {
      unset($_SESSION['booking']);
      header("location:userdashboard.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab fare</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <style>
  .caret {
    margin:2px;
    margin-left:5px;
  }
    .caret-dropup {
      transform: rotate(180deg);
    }
  table th, table td {
    text-align: center !important;
  }
  </style>
</head>
<body>
  <div id="wrapper">
    <!-- Header Section -->
    <header>
      <nav class="navbar navbar-default" style="background-color: black;">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="ceb.png" style="margin-top:-47px;" width="100" alt="CedCab" class="logoimage"></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
           <!--  <li><a href="index.php">Book Cab</a></li>
            <li><a href="userdashboard.php">Dashboard</a></li> -->
           <!--  <li class="active"><a href='previousrides.php'>Rides</a></li> -->
            <!-- <li><a href='updateprofile.php'>Update Profile</a></li>
            <li><a href='changepassword.php'>Change Password</a></li> -->
            <li><a><?php echo "Hey, &nbsp".$_SESSION['username']; ?></a></li>
            <li><a href='logout.php'>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Main Section/ Landing Page -->
    <section id="main" style="background-color: cyan;">
    <div class="text-center">
        <h2><b>Confirm your Booking Here</b></h2>
        <!-- <p>Here previous rides include Completed as well as Cancelled rides</p>  -->
    </div>
      <div class="container text-center">
        <table class="table table-striped">
            <tbody>
                    <tr> 
                      <th><h4>From</h4></th><td><h4><?php echo ucfirst($from); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>To</h4></th><td><h4><?php echo ucfirst($to); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Luggage</h4></th><td><h4><?php if($luggage == "") { echo "0"; } else { echo $luggage; } ?></h4></td>
                    </tr>
                  
                    <tr>
                      <th><h4>Distance</h4></th><td><h4><?php echo ucfirst($distance); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Fare</h4></th><td><h4><?php echo ucfirst($fare); ?></h4></td>
                    </tr>
                    <tr>
                      <th><h4>Action</h4></th><td>
                        <?php echo "<a href='confirmbooking.php?action=booked' class='btn btn-success'>Confirm Booking</a>&nbsp;&nbsp;<a href='confirmbooking.php?cancel=1' class='btn btn-danger'>Cancel Booking</a>" ; ?>
                      </td>
                    </tr>
            </tbody>
        </table>
      </div>
    </section>
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="background-color: darkgrey;">

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 mr-auto my-md-4 my-0 mt-4 mb-1">

        <!-- Content -->
        <h5 class="font-weight-bold text-uppercase mb-4">Ced Cab</h5>
        
        <p>The perfect way to get through your everyday travel needs. City taxis are available 24/7 and you can book and travel in an instant.</p>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-2 col-lg-2 mx-auto my-md-4 my-0 mt-4 mb-1">

        <!-- Links -->
        <h5 class="font-weight-bold text-uppercase mb-4">Discover Ced</h5>

        <ul class="list-unstyled">
          <li>
            <p>
              <a href="#!">Careers</a>
            </p>
          </li>
          <li>
            <p>
              <a href="#!">ABOUT US</a>
            </p>
          </li>
          <li>
            <p>
              <a href="#!">Offers</a>
            </p>
          </li>
          <li>
            <p>
              <a href="#!">Contacct Us</a>
            </p>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 mx-auto my-md-4 my-0 mt-4 mb-1">

        <!-- Contact details -->
        <h5 class="font-weight-bold text-uppercase mb-4">Address</h5>

        <ul class="list-unstyled">
          <li>
            <p>
              <i class="fas fa-home mr-3"></i>Lucknow</p>
          </li>
          <li>
            <p>
              <i class="fas fa-envelope mr-3"></i> info@example.com</p>
          </li>
          <li>
            <p>
              <i class="fas fa-phone mr-3"></i> +91 1234567899</p>
          </li>
          <li>
            <p>
              <i class="fas fa-print mr-3"></i> +91 1234567899</p>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none">

      <!-- Grid column -->
     
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">©Copyright2020: Designed by-<b>Vishvas Upadhyay...</b><span>&hearts;</span> All rights reserved.
  
  </div>
  <!-- Copyright -->

</footer>
   
  </div>
  <script src="action.js"></script>
</body>
</html>