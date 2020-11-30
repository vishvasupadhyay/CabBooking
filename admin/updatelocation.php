<?php
include("../Users.php");
include("../Locations.php");
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '1') {
        header("location:../index.php");
    }
} else {
    header("location:../index.php");
}
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $distance = $_POST['distance'];
    $obj = new Locations();
    $db = new config();
    $sql = $obj->update_loc($id, $name, $distance, 1, $db->conn);
    if($sql){
      header("location: alllocations.php");
    } else {
        echo "<script>alert('error')</script>";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="icon" type="image/png" sizes="50x50" href="taxi1.png">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
  <style>
      .form-group {
          text-align: left;
      }
  </style>
</head>
<body>
  <div id="wrap">
    <!-- Sidebar Section -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
          <li class="sidebar-brand" style="background-color:black;">
            <a class="" href="#"><img src="../ceb.png" width="100" alt="CedCab" class="logoimage" style="margin-bottom:-40px"></a>
          </li>
          <li>
              <h4><a style="color:white;" href="admindashboard.php">Home</a></h4>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Rides</a></h4>
            <a href='requestedrides.php'>Pending Rides</a>
            <a href='pastrides.php'>Compeleted Rides</a>
            <a href='cancelledrides.php'>Cancelled Rides</a>
            <a href='allrides.php'>All Rides</a>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Locations</a></h4>
            <a href='alllocations.php'>All Locations</a>
            <a class="active" href='addlocation.php'>Add New Locations</a>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Users</a></h4>
            <a href='pendingusers.php'>Pending User Requests</a>
            <a href='approvedusers.php'>Approved User Requests</a>
            <a href='allusers.php'>All Users</a>
          </li>
          <li>
            <a href='../logout.php'>Logout</a>
          </li>
          
      </ul>
    </div>
    <!-- Main Section/ Landing Page -->
    <section id="main">
    <div>
      <div class="panel-body text-right">
        <h4> Hey, <?php echo $_SESSION['username']; ?>
        <a href='../logout.php'>Logout</a></h4>
      </div>
    </div>
    <div class="text-center">
        <h2>Edit Location</h2>
        <p>Here you can Edit Location</p>
    </div>
    <div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form class="form" action="updatelocation.php" method="POST">
                <?php
                    $obj = new Locations();
                    $db = new config();
                    $id = $_GET['id'];
                    $val = $obj->select_loc_id($id, $db->conn);
                ?>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $val['id']; ?>" >
                    <input type="text" class="form-control" name="name" value="<?php echo $val['name']; ?>">
                </div>
                <div class="form-group">
                    <label for="distance">Distance From Charbagh</label>
                    <input type="number" class="form-control" name="distance" value="<?php echo $val['distance']; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-success" name="update" value="Update">
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="text-center">
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
    </div>
    </div>
    </section>
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
  <script src="../action.js"></script>
</body>
</html>