<?php
include ("Users.php");
include("Locations.php");
include("Rides.php");
if(isset($_SESSION['id'])){
  if($_SESSION['usertype'] != '0') {
      header("location:admin/admindashboard.php");
  }
}
$confirmed_ride = new Rides();
$db = new config();
$comp = $confirmed_ride->select_confirmed_ride($db->conn);
if($comp == '0') {
  $completedrides = 0;
} else {
  $completedrides = 0;
  foreach($comp as $completed) {
    ++$completedrides;
  }
  $total = 0;
  foreach($comp as $price) {
    $total = $total + $price['total_fare'];
  }
}

$pend = $confirmed_ride->select_ride('1', $db->conn);
if($pend == '0') {
  $pendingrides = 0;
} else {
  $pendingrides = 0;
  foreach($pend as $pending) {
    ++$pendingrides;
  }
}
$cancell = $confirmed_ride->select_ride('0', $db->conn);
if($cancell == '0') {
  $cancelledrides = 0;
} else {
  $cancelledrides = 0;
  foreach($cancell as $cancelled) {
  ++$cancelledrides;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab fare</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="50" href="..user/taxi1.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="icon" type="image/png" sizes="50x50" href="taxi1.png">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>

  <div id="wrap">
     <!-- Sidebar -->
     
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:black;">
          <a class="" href="#"><img src="ceb.png" width="100" alt="CedCab" class="logoimage" style="margin-top:-17px"></a>
        </li>
        <li>

            <h4><a class="active" style="color:white;" href="userdashboard.php">Home</a></h4>
        </li>
        <li>
          <h4><a href="index.php" style="color: white;">Book Cab</a></h4>
          <h4><a href="#" style="color:white;">Rides</a></h4>
          <a href='requestedride.php'>Pending Rides</a>
          <a href='previousrides.php'>Compeleted Rides</a>
          <a href='cancelride.php'>Cancelled Rides</a>
          <li><a href='updateprofile.php'>Update Profile</a></li>
          <li><a href='changepassword.php'>Change Password</a></li>
          
        </li>
        <li>
          <a href='logout.php'>Logout</a>
        </li>   
      </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div>
        <div class="panel-body text-right">
        
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-warning">
              <div class="panel-heading text-center">
                <h3 >Pending Rides</h3>
                <h1><?php echo $pendingrides; ?></h1>
              </div>
             
            <div class="panel-footer text-center"><a href="requestedride.php">Click</a> to see more..
            </div>
            </div>
      <!--       <div class="panel panel-info">
              <div class="panel-heading text-center">
                <h3>Pending User Requests</h3>
                <h1><?php echo $pendingusers; ?></h1>
              </div>
              <div class="progress">
              <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="30%" aria-valuemin="0" aria-valuemax="100" style="width:10%">
                30%
              </div>
            </div>

              <div class="panel-footer text-center"><a href="pendingusers.php">Click</a> to see more..</div>
            </div> -->
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-danger">
              <div class="panel-heading  text-center">
                <h3>Cancelled Rides</h3>
                <h1><?php echo $cancelledrides; ?></h1>
              </div>
              
              <div class="panel-footer text-center"><a href="cancelride.php">Click</a> to see more..</div>
            </div>
            <!-- <div class="panel panel-success">
              <div class="panel-heading text-center">
                <h3>Total Earning</h3>
                <h1>&#8360;.<?php echo $total;  ?></h1>
              </div>
           
              <div class="panel-footer text-center"><a href="allrides.php">Click</a> to see more..</div>
            </div> -->
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-primary text-center">
              <div class="panel-heading">
                <h3>Completed Rides</h3>
                <h1><?php echo $completedrides; ?></h1>
              </div>
             
              <div class="panel-footer text-ecnter"><a href="previousrides.php">Click</a> to see more..</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="page-footer font-small mdb-color lighten-3 pt-4">

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