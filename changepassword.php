<?php
//  include("config.php");

include("Users.php");
if(isset($_SESSION['id'])){
	if($_SESSION['usertype'] != '0') {
		header("location:admin/admindashboard.php");
		}
	} else {
	header("location:index.php");
	}
 $error = "";
 if(isset($_POST['submit'])) {
	$password = $_POST['password'];
	$confirm_password = $_POST['confirmpassword'];
	if($password != $confirm_password){
        $error = "Password and Confirm Password did not matched!";
        header("location: changepassword.php");
	} else {
		$obj = new Users();
		$db = new config();
		$sql1 = $obj->select_user_id($_SESSION['id'], $db->conn);
		foreach($sql1 as $data){
            $username = $data['user_name'];
            $name = $data['name'];
            $phone = $data['mobile'];
            $isblock = $data['isblock'];
            $pass = md5($password);
            $role = $data['isadmin'];
        }
        $register = new Users();
        $sql = $register->update_password($_SESSION['id'], $username, $name, $phone, $isblock, $pass, $role, $db->conn);
        session_destroy();
        header("location: login.php");
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
		background-color: crimson;
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
<div class="container-fluid" id='main'>
	<div class="jumbotron" id='jumb'>
		<div class="col-md-3 col-lg-3 col-sm-1">
		</div>
		<div class="col-md-6 col-lg-6 col-sm-10" id='abc'>
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="ceb.png" alt="" width="100" height="100"/></a>
			</center>
            <h2 style="text-align: center;">Update Password Here</h2>
            <div class="text-right">
                <a href="userdashboard.php" class="btn btn-info">Back</a>
            </div>
            <?php
                if($error) {
                    ?>
                        <p style="color:red; text-align:center !important;"><?php echo $error; ?></p>
                    <?php
                }
            ?>
			<form action="" method="POST">
			<!-- 	<div class="form-group">
					<label for='password'>Old Password:</label>
					<input type="password1" class='form-control' name="password1">
				</div> -->
				<div class="form-group">
					<label for='password'>Password:</label>
					<input type="password" class='form-control' name="password">
				</div>
				<div class="form-group">
					<label for='confirmpassword'>Confirm Password:</label>
					<input type="password" class='form-control' name="confirmpassword">
				</div>
				<div class="form-group " style="padding: 10px 0px;">
					<input type="submit" class="btn btn-success form-control"  name="submit" value="Update" style="padding: 5px 30px;">
				</div>
				<!-- <p class="pfooter">Already have account? <a href="login.php"> Click Here</a></p> -->
			</form>
	</div>
</div>
</body>
</html>