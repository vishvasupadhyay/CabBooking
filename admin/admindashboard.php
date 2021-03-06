<?php
include("../Users.php");
include("../Rides.php");
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '1') {
        header("location:../index.php");
    }
} else {
    header("location:../index.php");
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
$obj2 = new Users();
$blockedusers = $obj2->select_pending_users('0', $db->conn);
$pendingusers = 0;
foreach((array)$blockedusers as $blocked) {
  ++$pendingusers;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab fare</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> 
  <link rel="icon" type="image/png" sizes="50" href="..user/taxi1.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="icon" type="image/png" sizes="50x50" href="../taxi1.png">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
</head>
<body>

  <div id="wrap">
     <!-- Sidebar -->
     
    <div id="sidebar-wrapper" style="background-color: lightgreen;">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:lightgreen;">
          <a class="" href="#"><img src="../ceb.png" width="100" alt="CedCab" class="logoimage" style="margin-top:-17px"></a>
        </li>
        <li>

            <h4><a  style="color:black;" href="admindashboard.php">Home</a></h4>
        </li>
        <li>
          <h4><a href="#" style="color:black;">Rides</a></h4>
          <a href='requestedrides.php'>Pending Rides</a>
          <a href='pastrides.php'>Compeleted Rides</a>
          <a href='cancelledrides.php'>Cancelled Rides</a>
          <a href='allrides.php'>All Rides</a>
        </li>
        <li>
          <h4><a href="#" style="color:black;">Locations</a></h4>
          <a href='alllocations.php'>All Locations</a>
          <a href='addlocation.php'>Add New Locations</a>
        </li>
        <li>
        <h4><a href="changepss.php" style="color:black;">Change password</a></h4>
      </li>
        <li>
          <h4><a href="#" style="color:black;">Users</a></h4>
          <a href='pendingusers.php'>Pending User Requests</a>
          <a href='approvedusers.php'>Approved User Requests</a>
          <a href='allusers.php'>All Users</a>
        </li>
        <li>
          <a href='../logout.php'><b>Logout</b></a>
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
                <h3>Pending Rides</h3>
                <h1><?php echo $pendingrides; ?></h1>
              </div>
            
            <div class="panel-footer text-center"><a href="requestedrides.php">Click</a> to see more..
            </div>
            </div>
            <div class="panel panel-info">
              <div class="panel-heading text-center">
                <h3>Pending User Requests</h3>
                <h1><?php echo $pendingusers; ?></h1>
              </div>
              

              <div class="panel-footer text-center"><a href="pendingusers.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-danger">
              <div class="panel-heading  text-center">
                <h3>Cancelled Rides</h3>
                <h1><?php echo $cancelledrides; ?></h1>
              </div>
              
              <div class="panel-footer text-center"><a href="cancelledrides.php">Click</a> to see more..</div>
            </div>
            <div class="panel panel-success">
              <div class="panel-heading text-center">
                <h3>Total Earning</h3>
                <h1>&#8360;.<?php echo $total;  ?></h1>
              </div>
           
              <div class="panel-footer text-center"><a href="allrides.php">Click</a> to see more..</div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="panel panel-primary text-center">
              <div class="panel-heading">
                <h3>Completed Rides</h3>
                <h1><?php echo $completedrides; ?></h1>
              </div>
              
              <div class="panel-footer text-ecnter"><a href="pastrides.php">Click</a> to see more..</div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="background-color: lightcyan;">

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
  <script src="../action.js"></script>
</body>
</html>