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

if(isset($_GET['ride'])){
    $id = $_GET['id'];
    $blck = new Rides();
    $db = new config();
    $sql = $blck->remove($id, $db->conn);
}
if(isset($_GET['sort'])){
  $order = $_GET['sort'];
  $sort = $_GET['val'];
  $obj = new Rides();
  $db = new config();
  $final = $obj->sort_allrides($sort, $order, $db->conn);
  // echo $final;
  // die();
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
  .caret {
    margin:2px;
    margin-left:5px;
  }
    .caret-dropup {
      transform: rotate(180deg);
    }
  </style>
</head>
<body>
  <div id="wrap">
    <!-- Header Section -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
          <li class="sidebar-brand" style="background-color:white;">
            <a class="" href="#"><img src="../taxi1.png" width="100" alt="CedCab" class="logoimage" style="margin-bottom:-40px"></a>
          </li>
             <h4> Hey, <?php echo $_SESSION['username']; ?>
          <a href='../logout.php'>Logout</a></h4>
          <li>
              <h4><a style="color:white;" href="admindashboard.php">Home</a></h4>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Rides</a></h4>
            <a href='requestedrides.php'>Pending Rides</a>
            <a href='pastrides.php'>Compeleted Rides</a>
            <a href='cancelledrides.php'>Cancelled Rides</a>
            <a class="active" href='allrides.php'>All Rides</a>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Locations</a></h4>
            <a href='alllocations.php'>All Locations</a>
            <a href='addlocation.php'>Add New Locations</a>
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
    <section id="main1">
          <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><=</a>
      <div>
        <div class="panel-body text-right">
     
        </div>
      </div>
        <div class="container text-center">
            <h2>All Rides</h2>
            <p>Here you can see all the rides of users</p> 
        </div>
          <div class="container text-center" style="width:80%;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">S.no</th>
                        <th class="text-center">
                          Date
                          <a href="allrides.php?sort=ASC&val=ride_date"><p class="caret"></p></a>
                          <a href="allrides.php?sort=DESC&val=ride_date"><p class="caret caret-dropup"></p></a>
                        </th>
                        <th class="text-center">From</th>
                        <th class="text-center">To</th>
                        <th class="text-center">
                          Total Distance
                          <a href="allrides.php?sort=ASC&val=total_distance"><p class="caret"></p></a>
                          <a href="allrides.php?sort=DESC&val=total_distance"><p class="caret caret-dropup"></p></a>
                        </th>
                        <th class="text-center">Luggage</th>
                        <th class="text-center">
                          Total Fare
                          <a href="allrides.php?sort=ASC&val=total_fare"><p class="caret"></p></a>
                          <a href="allrides.php?sort=DESC&val=total_fare"><p class="caret caret-dropup"></p></a>
                        </th>
                        <th class="text-center">Customer ID</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($_GET['sort'])) {
                      $sql = $final; 
                    } else {
                        $rides = new Rides();
                        $db = new config();
                        $sql = $rides->select_allrides($db->conn);
                    }
                    $i = 1;
                        foreach($sql as $data){
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo ucfirst($data['ride_date']); ?></td>
                                    <td><?php echo ucfirst($data['from']); ?></td>
                                    <td><?php echo ucfirst($data['to']); ?></td>
                                    <td><?php echo ucfirst($data['total_distance']); ?></td>
                                    <td><?php echo ucfirst($data['luggage']); ?></td>
                                    <td><?php echo ucfirst($data['total_fare']); ?></td>
                                    <td><?php echo ucfirst($data['customer_user_id']); ?></td>
                                    <td>
                                      <?php 
                                        if($data['status']=='0') { 
                                          echo "<span class='label label-danger'>Cancelled</span>";
                                        } elseif($data['status']=='1') { 
                                          echo "<span class='label label-warning'>Pending</span>"; 
                                        } else { 
                                          echo "<span class='label label-success'>Completed</span>";
                                        } 
                                      ?>
                                    </td>
                                </tr>
                            <?php
                    }
                ?>
                </tbody>
            </table>
        
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
  </div>
  <script src="../action.js"></script>
</body>
</html>