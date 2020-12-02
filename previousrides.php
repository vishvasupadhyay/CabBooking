<?php
include("Users.php");
include("Rides.php");
$conn = new config();
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '0') {
        header("location:admin/admindashboard.php");
    }
} else {
    header("location:index.php");
}
$datewise = "";
if(isset($_GET['sort'])){
    $order = $_GET['sort'];
    $sort = $_GET['val'];
    $id = $_SESSION['id'];
    $obj = new Rides();
    $db = new config();
    $final = $obj->sort_col($id, $sort, $order, '2', $db->conn);
}
if(isset($_POST['fetch'])){
  $date1 = $_POST['date1'];
  $date2 = $_POST['date2'];
  $id = $_SESSION['id'];
  $obj = new Rides();
  $db = new config();
  $datewise = $obj->filter_datewise($id, $date1, $date2, '2', $db->conn);
  
}
if(isset($_POST['fetch_week'])){
  $week = $_POST['week'];
  $id = $_SESSION['id'];
  $obj = new Rides();
  $db = new config();
  $datewise = $obj->filter_weekwise($id, $week, '2', $db->conn);
  // echo $datewise;
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

            <h4><a class="active" style="color:white;" href="userdashboard.php">Home</a></h4>
        </li>
        <li>
          <h4><a href="index.php" style="color: white;">Book Cab</a></h4>
          <h4><a href="#" style="color:white;">Rides</a></h4>
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
    <!-- Header Section -->

   
    <!-- Main Section/ Landing Page -->
    <section id="main" style="background-color: skyblue;">
      <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle</a>
      <div class="panel-body text-right">
       
      </div>
    <div class="text-center">
        <h2>All Completed Rides</h2>
        <p>Here previous rides include Completed as well as Cancelled rides</p>
    </div>

      <div class="container text-center">
        <div class="container">
        <form action="previousrides.php" method="post">
          Datewise Filter: 
          <input type="date" name="date1" required>
          <input type="date" name="date2" required>
          <input type="submit" value="fetch" name="fetch">
        </form>
        <form action="previousrides.php" method="post">
          WeekWise Filter: 
          <input type="week" name="week" required>
          <input type="submit" value="fetch" name="fetch_week">
        </form>
      </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">S.no</th>
                    <th class="text-center">
                      Date
                      <a href="previousrides.php?sort=ASC&val=ride_date"><p class="caret"></p></a>
                      <a href="previousrides.php?sort=DESC&val=ride_date"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">From</th>
                    <th class="text-center">To</th>
                    <th class="text-center">
                      Total Distance
                      <a href="previousrides.php?sort=ASC&val=total_distance"><p class="caret"></p></a>
                      <a href="previousrides.php?sort=DESC&val=total_distance"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">Luggage</th>
                   <!--  <th class="text-center">Cab Type</th> -->
                    <th class="text-center">
                      Total Fare
                      <a href="previousrides.php?sort=ASC&val=total_fare"><p class="caret"></p></a>
                      <a href="previousrides.php?sort=DESC&val=total_fare"><p class="caret caret-dropup"></p></a>
                    </th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(isset($_GET['sort'])) {
                  $sql = $final; 
                } elseif($datewise != "") {
                  $sql = $datewise;
                } else {
                  $rides = new Rides();
                  $db = new config();
                  $id = $_SESSION['id'];
                  $sql = $rides->select_previous_rides($id, '2',  $db->conn);
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
                                <td><?php if($data['luggage'] == "") { echo '0'; } else { echo $data['luggage']; }  ?></td>
                         <!--        <td><?php echo ucfirst($data['cabtype']); ?></td> -->
                                <td><?php echo ucfirst($data['total_fare']); ?></td>
                                <td><?php if($data['status'] == '0') { echo "Cancelled"; } elseif($data['status'] == '2'){ echo "Completed"; } else { echo "Pending"; }; ?></td>
                            </tr>
                        <?php
                        if($data['status'] == '2'){
                          $price = $price + $data['total_fare'];
                        }
                    }
                    ?>
                        <tr>
                            <td colspan="9"><h2>Total Spent: <?php echo $price; ?></h2></td>
                        </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
      </div>

    </section>
   
  </div>
  <script src="action.js"></script>
</body>
</html>