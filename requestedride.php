 <?php
 include ("Users.php");
 include ("Rides.php"); 
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '0') {
        header("location:admin/admindashboard.php");
    }
} else {
    header("location:index.php");
}
 if(isset($_GET['sort'])){
  $order = $_GET['sort'];
  $sort = $_GET['val'];
  $obj = new Rides();
  $db = new config();
  $final = $obj->sort_statuswise('1', $sort, $order, $db->conn);
  // echo $final;
  // die();
}
$datewise = "";
$cabwise ="";
// $cancelled  ="";
if(isset($_GET['sort'])){
    $order = $_GET['sort'];
    $sort = $_GET['val'];
    $id = $_SESSION['id'];
    $obj = new Rides();
    $db = new config();
    $final = $obj->sort_col($id, $sort, $order, '1', $db->conn);
}
if(isset($_POST['fetch'])){
  $date1 = $_POST['date1'];
  $date2 = $_POST['date2'];
  $id = $_SESSION['id'];
  $obj = new Rides();
  $db = new config();
  $datewise = $obj->filter_datewise($id, $date1, $date2, '1', $db->conn);
  
}
if(isset($_POST['fetch_week'])){
  $week = $_POST['week'];
  $id = $_SESSION['id'];
  $obj = new Rides();
  $db = new config();
  $datewise = $obj->filter_weekwise($id, $week, '1', $db->conn);
  // echo $datewise;
  // die();
}
if (isset($_GET['fetchcab'])) {
  $cabtype=$_GET['cabtype'];
  $id= $_SESSION['id'];
  $obj= new Rides();
  $db = new config();
  $cabwise = $obj->filter_cabtype($id , '1', $cabtype, $db->conn);
  
}
// if(isset($_GET['cancellride'])){
//   $id= $_GET['id'];
//   $blck = new Rides();
//   $db = new config();
//   $cancelled = $blck->update($id,'cancel',$db->conn);
// }

  ?>
 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab fare</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <link rel="icon" type="image/png" sizes="50x50" href="../taxi1.png">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
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
   <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand" style="background-color:black;">
          <a class="" href="#"><img src="ceb.png" width="100" alt="CedCab" class="logoimage" style="margin-top:-17px"></a>
        </li>
        <li>

            <h4><a class="active" style="color:black;" href="userdashboard.php">Home</a></h4>
        </li>
        <li>
          <h4><a href="index.php" style="color: black;">Book Cab</a></h4>
          <h4><a href="#" style="color:black;">Rides</a></h4>
          <a href='previousrides.php'>Compeleted Rides</a>
          <a href='requestedride.php'>Pending Rides</a>
          <a href='cancelride.php'>Cancelled Rides</a>
          <li><a href='updateprofile.php'>Update Profile</a></li>
          <li><a href='changepassword.php'>Change Password</a></li>
          
        </li>
        <li>
          <a href='logout.php'>Logout</a>
        </li>   
      </ul>
    </div>
   <section id="main"style="background-color: skyblue;">
       <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle</a>
    <div>
      <div class="panel-body text-right">
       
      </div>
    </div>
    <div class="container text-center">
        <h2>Pending Rides</h2>
        <p>Here you can Manage Pending Rides</p> 
    </div>
      <div class="container text-center">
        <div class="container">
        <form action="requestedride.php" method="post">
          Datewise Filter: 
          <input type="date" name="date1" required>
          <input type="date" name="date2" required>
          <input type="submit" value="fetch" name="fetch">
        </form>
        <form action="requestedride.php" method="post">
          WeekWise Filter: 
          <input type="week" name="week" required>
          <input type="submit" value="fetch" name="fetch_week">
        </form>
          <form action="requestedride.php" method="get">
          Cabwise:
          <select name="cabtype" id="Cabtype">
            <option  value="">Select options</option>
            <option value="cedmicro"<?php if(isset($_GET['cabtype'])&&($_GET['cabtype']=='cedmicro')){echo "selected";}  ?>> Cedmicro</option>
            <option value="cedmini"<?php if(isset($_GET['cabtype'])&&($_GET['cabtype']=='cedmicro')){echo "selected";}  ?>> Cedmini</option>
            <option value="cedroyal"<?php if(isset($_GET['cabtype'])&&($_GET['cabtype']=='cedmicro')){echo "selected";}  ?>> Cedroyal</option>
            <option value="cedsuv"<?php if(isset($_GET['cabtype'])&&($_GET['cabtype']=='cedmicro')){echo "selected";}  ?>> Cedsuv</option>
          </select>
          <input type="submit" value="fetch" name="fetchcab">
        </form>
      </div>
        <table class="container table table-striped" style="width:80%;">
            <thead>
                <tr>
                    <th class="text-center">S.no</th>
                    <th class="text-center">
                      Date
                      <a href="requestedride.php?sort=ASC&val=ride_date"><p class="caret"></p></a>
                      <a href="requestedride.php?sort=DESC&val=ride_date"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">From</th>
                    <th class="text-center">To</th>
                    <th class="text-center">
                      Total Distance
                      <a href="requestedride.php?sort=ASC&val=total_distance"><p class="caret"></p></a>
                      <a href="requestedride.php?sort=DESC&val=total_distance"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">Luggage</th>
                    <th class="text-center">
                      Cabtype
                     
                    </th>
                    <th class="text-center">
                      Total Fare
                      <a href="requestedride.php?sort=ASC&val=total_fare"><p class="caret"></p></a>
                      <a href="requestedride.php?sort=DESC&val=total_fare"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">Status</th>
                  <!--   <th class="text-center" colspan="2">Action</th> -->
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($_GET['sort'])) {
                  $sql = $final; 
                } elseif($datewise != "") {
                  $sql = $datewise;
                }elseif ($cabwise!=""){
                  $sql= $cabwise;
               } // }elseif($cancelled!=""){
                //   $sql= $cancelled;
                // }
                 else {
                  $rides = new Rides();
                  $db = new config();
                  $id = $_SESSION['id'];
                  $sql = $rides->select_previous_rides($id, '1',  $db->conn);
                }
                if($sql == '0'){
                    ?>
                        <td colspan="8">No Data Available</td>
                    <?php
                } else {
                    $price = 0;
                    $i = 1;
                    foreach($sql as $data){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo ucfirst($data['ride_date']); ?></td>
                                <td><?php echo ucfirst($data['from']); ?></td>
                                <td><?php echo ucfirst($data['to']); ?></td>
                                <td><?php echo ucfirst($data['total_distance']); ?></td>
                                <td><?php if($data['luggage']==""){echo '0';}else {echo $data['luggage'];}?>&#13199;</td>
                                <td><?php echo ucfirst($data['cabtype']); ?></td>
                         
                                <td><?php echo ucfirst($data['total_fare']); ?></td>
                                <td><?php if($data['status'] == '0') { echo "Cancelled"; } elseif($data['status'] == '2'){ echo "Completed"; } else { echo "Pending"; }; ?></td>
                              
                            </tr>
                        <?php
                        if($data['status'] == '1'){
                          $price = $price + $data['total_fare'];
                        }
                    }
                    ?>
                        <tr>
                            <td colspan="9"><h2>Total Spent: &#8360;.<?php echo $price; ?></h2></td>
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
<script src="action.js"></script>
 
 </body>
 </html>
