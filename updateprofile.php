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
    $username = $_POST['username'];
	$phone = $_POST['phone'];
    if($username == '' || $phone == ''){
        $error = 'Please complete the form and then submit';
    } 
    else {
		$obj = new Users();
		$db = new config();
		$sql1 = $obj->select_user_id($_SESSION['id'], $db->conn);
		$data = mysqli_fetch_assoc($sql1);
		$name = $data['name'];
		$isblock = $data['isblock'];
		$pass = $data['password'];
		$role = $data['isadmin'];
        $register = new Users();
        $sql = $register->update($_SESSION['id'], $username, $name, $phone, $role, $pass, $isblock, $db->conn);
        echo $sql;
        // echo "<script>alert('Congo! you have done successfully change youre Name';)</script>";
        // session_destroy();
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
<div class="container-fluid" id='main' style="background-color: cadetblue;">
	<div class="jumbotron" id='jumb'>
		<div class="col-md-3 col-lg-3 col-sm-1">
		</div>
		<div class="col-md-6 col-lg-6 col-sm-10" id='abc' style="background-color: crimson;">
			<center>
				<a href="index.php"><img style="margin-bottom: -40px;" src="ceb.png" alt="" width="100" height="100"/></a>
			</center>
            <h2 style="text-align: center; color: black"><b>Update Your Profile Here<b></h2>
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
				<?php
				$obj = new Users();
				$db = new config();
				$sql = $obj->select_user_id($_SESSION['id'], $db->conn);
				$data = mysqli_fetch_assoc($sql);
				?>
				<div class="form-group">
					<label for='name' style="color: black;">Name:</label>
					<input type="text" class='form-control' name="username" value="<?php echo $data['user_name']; ?>">
				</div>
				<div class="form-group ">
					<label for='phone' style="color: black;">Phone:</label>
					<input type="text" class='form-control' pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="phone" value="<?php echo $data['mobile']; ?>">
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