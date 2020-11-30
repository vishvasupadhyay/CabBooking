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

if(isset($_GET['enable'])){
    $id = $_GET['id'];
    $blck = new Locations();
    $db = new config();
    $sql = $blck->enable_loc($id, $db->conn);
}

if(isset($_GET['delete'])) {
  $id = $_GET['id'];
  $obj = new Locations();
  $db = new config();
  $sql = $obj->delete_loc($id, $db->conn);
}

if(isset($_GET['sort'])){
  $order = $_GET['sort'];
  $sort = $_GET['val'];
  $obj = new Locations();
  $db = new config();
  $final = $obj->sort_loc($sort, $order, $db->conn);
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
    <!-- Sidebar Section -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
          <li class="sidebar-brand" style="background-color:black;">
            <a class="" href="#"><img src="../ceb.png" width="100" alt="CedCab" class="logoimage" style="margin-bottom:-40px"></a>
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
            <a href='allrides.php'>All Rides</a>
          </li>
          <li>
            <h4><a href="#" style="color:white;">Locations</a></h4>
            <a class="active" href='alllocations.php'>All Locations</a>
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
    <section id="main">
       <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><=</a>
      <div>
        <div class="panel-body text-right">
       
        </div>
      </div>
    <div class="text-center">
        <h2>All Locations</h2>
        <p>Here you can manage Locations</p> 
    </div>
      <div class="container text-center">
        <table class="container table table-striped" style="width:80%;">
            <thead>
                <tr>
                    <th class="text-center">S.no</th>
                    <th class="text-center">
                      Name
                      <a href="alllocations.php?sort=ASC&val=name"><p class="caret"></p></a>
                      <a href="alllocations.php?sort=DESC&val=name"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">
                      Distance from Charbagh
                      <a href="alllocations.php?sort=ASC&val=distance"><p class="caret"></p></a>
                      <a href="alllocations.php?sort=DESC&val=distance"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">Is Available</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
              if(isset($_GET['sort'])) {
                $sql = $final; 
              } else {
                  $users = new Locations();
                  $db = new config();
                  $sql = $users->select_loc($db->conn);
              }
                $i = 1;
                foreach($sql as $data){
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo ucfirst($data['name']); ?></td>
                        <td><?php echo ucfirst($data['distance']); ?></td>
                        <td><?php if($data['is_available'] == 1) { echo "Available"; } else { echo "Unavailable"; } ?></td>
                        <td>
                            <a href="updatelocation.php?id=<?php echo $data['id']; ?>" class="btn btn-xs btn-info btn-sm">Edit</a>
                            <a href="alllocations.php?enable=1&id=<?php echo $data['id']; ?>" class="btn btn-xs btn-warning btn-sm">Enable/Disable</a>
                            <a href="alllocations.php?delete=1&id=<?php echo $data['id']; ?>" class="btn btn-xs btn-danger btn-sm">Delete</a>
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
  <script src="../action.js"></script>
</body>
</html>