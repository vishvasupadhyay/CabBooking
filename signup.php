<?php
//  include("config.php");
if(isset($_SESSION['id'])){
    if($_SESSION['usertype'] != '0'){
        header("location:index.php");
    }
}

include("Users.php");
 $error = "";
 if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $isblock="";
    if($password != $confirmpassword) {
        $error = "Password and Confirm Password did not matched!";
    } elseif($username == '' || $name == '' || $password == '' || $phone == '' || $role == '' ){
        $error = 'Please complete the form and then submit';
    } 
    else {
        if($role == "0"){
            $isblock = "0";
        } else {
            $isblock = "1";
        }
        $pass = md5($password);
        $register = new Users();
        $db = new config();
        $sql = $register->signup($username, $name, $phone, $role, $pass, $isblock, $db->conn);
        echo $sql;
    }
 }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	 <link rel="icon" type="image/png" sizes="50x50" href="taxi1.png">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	body{
		margin: 0;
		padding: 0;
		font-family:century gothic;
		color:white;
	}
	#main{
		background-image: url('lb.jpg');
/*        background-color: crimson;*/
		background-size:100% 100%;
	}
	#jumb{
		position:relative;
		background-color: rgba(0,0,0,0);
		color:white;
	}
	a{
		color:white;
	}
	#abc{
		background-color: rgba(0,0,0,0.1);
		padding: 50px;
		margin-bottom:100px;
    }
    .form-group {
        padding: 5px 0px;
    }
    .pfooter {
        font-size:16px;
        font-style:bold;
        color:white;
        text-align: center;
    }
	</style>
</head>
<body>
<div class="container-fluid" id='main' style="padding: 0;">
		<header>
      <nav class="navbar navbar-default" style="background-color:aqua; ">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="ceb.png" width="85" alt="CedCab" class="logoimage" style="margin-top: -33px;"></a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="index.php">Book Cab</a></li>
              <li><a href="login.php">Login</li>
             
              <?php 
                if(isset($_SESSION['id'])) { 
                  echo "<li><a>Hey, &nbsp".$_SESSION['name']."<li><a href='userdashboard.php'>Dashboard</a></li></a></li><li><a href='logout.php'>Logout</a></li>";
                } 
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
	<div class="jumbotron" id='jumb'>
		<div class="col-md-3 col-lg-3 col-sm-1">
		</div>
		<div class="col-md-6 col-lg-6 col-sm-10" id='abc'>
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="ceb.png" alt="" width="100" height="100"/></a>
			</center>
            <h2 style="text-align: center; color: black;">Register Here</h2>
            <?php
                if($error) {
                    ?>
                        <p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
                    <?php
                }
            ?>
			<form action="" method="POST">
				<div class="form-group">
					<label for='name' style="color: black;font-size: 20px;">Name:</label>
					<input type="text" class='form-control' name="name" pattern="^[_A-z0-9]*((-|\s)*[_A-z0-9])*$" required>
				</div>
				<div class="form-group ">
					<label for='username' style="color: black;font-size: 20px;">Username:</label>
					<input type="text" class='form-control' name="username" pattern="^[_A-z0-9]*((-|\s)*[_A-z0-9])*$" required>
				</div>
				<div class="form-group ">
					<label for='phone' style="color: black;font-size: 20px;">Phone:</label>
					<input type="tel" class='form-control' name="phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}">
                </div>

                <div class="form-group ">
					<label for='role'style="color: black;font-size: 20px;">Role:</label>
					<select class="form-control" name="role" id="role">
                        <option value=""style="color: black;font-size: 20px;">Select role</option>
                        <!-- <option value="1">Admin</option> -->
                        <option value="0"style="color: black;font-size: 20px;">User</option>
                    </select>
				</div>
				<div class="form-group">
					<label for='password' style="color: black;font-size: 20px;">Password:</label>
					<input type="password" class='form-control' name="password" pattern=".{5,}" title="five or more characters" required>
				</div>
				<div class="form-group">
					<label for='confirmpassword' style="color: black;font-size: 20px;">Confirm Password:</label>
					<input type="password" class='form-control' name="confirmpassword" pattern=".{5,}" title="five or more characters" required>
				</div>
				<div class="form-group " style="padding: 10px 0px;">
					<input type="submit" class="btn btn-success form-control"  name="submit" value="Register" style="padding: 5px 30px;">
				</div>
				<p class="pfooter" style="color: black;font-size: 20px;">Already have account? <a href="login.php"style="font-size: 20px;"> Click Here</a></p>
			</form>
	</div>
     <footer class="page-footer font-small mdb-color lighten-3 pt-4" >

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

</body>
</html>