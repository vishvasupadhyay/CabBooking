<?php
include('Users.php');

$error = '';
if (isset($_SESSION['id'])) {
    header("location:index.php");
} else {
    if (isset($_POST['login'])) {
        $name = $_POST['name'];
        $pass = $_POST['password'];
		$password = md5($pass);
		$user = new Users();
		$db = new config();
		$sql = $user->login($name, $password, $db->conn);
    }
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
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
		/*background-color: crimson;*/
		padding: 0;
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
		padding: 40px;
		margin-bottom:100px;
	}
	</style>
</head>
<body>

<div class="container-fluid" id='main'>
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
              <li><a href="signup.php">Sign Up</li>
             
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
	<div class="container jumbotron" id='jumb'>
		<div class="col-md-4 col-lg-4 col-sm-1">
		</div>
		<div class="col-md-4 col-lg-4 col-sm-10" id='abc'>
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="ceb.png" alt="" width="100" height="100"/></a>
			</center>
			<h2 style="text-align: center; color: black;">Account Login</h2>
			<?php
				if($error) {
                    ?>
                        <p style="text-align:center !important; color: aqua;"><?php echo $error; ?></p>
                    <?php
                }
			?>
			<form action="login.php" method="POST">
				<div class="form-group" style="padding: 5px 0px;">
					<label for='username'>Username:</label>
					<input type="text" class='form-control' name="name" pattern="^[_A-z0-9]*((-|\s)*[_A-z0-9])*$" required>
				</div>
				<div class="form-group" style="padding: 5px 0px;" >
					<label for='password'>Password:</label>
					<input type="password" class='form-control' name="password" id="myInput" required>
					<input type="checkbox" onclick="myFunction()">Show Password
				</div>
				<div class="form-group" style="padding: 10px 0px;">
					<input type="submit" class="btn btn-success form-control"  name="login" value="Login" style="padding: 5px 30px;">
				</div>
				
				<p style="font-size:16px; font-style:bold;color:black;text-align: center; margin-bottom: 20px;">Forget Password? <a href="forget.php"> Click Here</a></p>
				<p style="font-size:16px; font-style:bold;color:black;text-align: center;">Do not an account? <a href="signup.php"> Click Here</a></p>
			</form>
		</div>
		<div class="col-md-4 col-lg-4 col-sm-1"></div>
	</div>
	 <footer class="page-footer font-small mdb-color lighten-3 pt-4" style="background-color: lightseagreen;">

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