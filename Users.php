<?php
session_start();
include('config.php');
class Users {
    public $username;
    public $name;
    public $password;
    public $mobile;
    public $isblock;
    public $isadmin;

    function signup($username, $name, $phone, $role, $pass, $isblock, $conn) {
        $qry = "INSERT INTO `users` (`user_name`, `name`, `dateofsignup`, `mobile`, `isblock`, `password`, `isadmin`) VALUES ('".$username."', '".$name."', NOW(), '".$phone."', '".$isblock."', '".$pass."', '".$role."')";
        $run = mysqli_query($conn, $qry);
        if ($run == true) {
            if($isblock == "1") {
                header("location:login.php");
            } else {
                echo "<script>alert('You are successfully registered! Please wait for admin approvel.');</script>";
            }
        } else {
            die("Some errror Occured". mysqli_error($conn));
        }
    }

    function login($name, $password, $conn){
        $qry = "SELECT * FROM users WHERE `name` = '$name' AND `password` = '$password'";
        $run = mysqli_query($conn, $qry);
        $row = mysqli_num_rows($run);
        if ($row<1) {
                 echo "<script>alert('Please enter a valid Username or Password.');</script>";
        } else {
			$data = mysqli_fetch_assoc($run);
            if($data['isblock']== "0" ){
                echo "<script>alert('You are successfully registered! Please wait for admin approvel.');</script>";
            } else {
                $id = $data['user_id'];
                $usertype = $data['isadmin'];
                $name = $data['name'];
                $_SESSION['id'] = $id;
                $_SESSION['usertype'] = $usertype;
                $_SESSION['name'] = $name;
				if($usertype == "1"){
					header("location:admin/admindashboard.php");
				} else {
					header("location:userdashboard.php");
				}
            }
        }
    }

    function select_users($isadmin, $conn) {
        $sql = "SELECT * FROM `users` WHERE isadmin = '".$isadmin."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }

    function select_pending_users($status, $conn) {
        $sql = "SELECT * FROM `users` WHERE `isblock` = $status AND `isadmin` = 0";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }

    function select_user_id($id, $conn){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '".$id."'";
        $run = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($run);
        if($rows>0) {
            return $run;
        }
    }
    
    function block($id, $conn) {
        $isblck = "";
        $qry = "SELECT * FROM users WHERE `user_id` = $id";
        $run = mysqli_query($conn, $qry);
        if(mysqli_num_rows($run)>0){
            $data = mysqli_fetch_assoc($run);
            if($data['isblock']=="0"){
                $isblck = "1";
            } else {
                $isblck = "0";
            }
            $final = "UPDATE `users` SET `isblock` = $isblck WHERE `user_id` = $id";
            $runqry = mysqli_query($conn, $final);
            if(!$runqry){
                echo "Some error occured!".mysqli_error($conn);
            }
        }
    }

    function update($id, $username, $name, $phone, $role, $pass, $isblock, $conn) {
        $qry = "UPDATE users SET `user_name` = '".$username."', `name` = '".$name."', `dateofsignup` = NOW(), `mobile` = '".$phone."', `isblock` = '".$isblock."', `password` = '".$pass."', `isadmin` = '".$role."' WHERE `user_id` = '".$id."'";
        $run = mysqli_query($conn, $qry);
        if ($run == true) {
            if($isblock == "1") {
                header("location:login.php");
            } 
            else {

                echo "<script>alert('You are successfully registered! Please wait for admin approvel.');</script>";
            }
        } else {
            die("Some errror Occured". mysqli_error($conn));
        }
    }

    function sort_users($sort, $order, $conn) {
        if($sort == "mobile"){
            $sort = "cast(`$sort` AS unsigned)";
        }
        $sql = "SELECT * FROM `users` WHERE isadmin = '0' ORDER BY $sort $order";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }
    function sort_pending_users($sort, $order, $status, $conn) {
        if($sort == "mobile"){
            $sort = "cast(`$sort` AS unsigned)";
        }
        $sql = "SELECT * FROM `users` WHERE `isadmin` = '0' AND `isblock` = $status ORDER BY $sort $order";
        // return $sql;
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }

    function update_password($id, $username, $name, $phone, $isblock, $pass, $role, $conn) {
        $sql = "UPDATE users SET `user_name` = '".$username."', `name` = '".$name."', `dateofsignup` = NOW(), `mobile` = '".$phone."', `isblock` = '".$isblock."', `password` = '".$pass."', `isadmin` = '".$role."' WHERE `user_id` = '".$id."'";
        $runqry = mysqli_query($conn, $sql);
        if(!$runqry){
            return '0';
        } else {
            return $runqry;
        }
    }
}

?>