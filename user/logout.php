<?php
session_start();

if(isset($_SESSION['usr_id'])) {
	include("dbconnect.php");
	$id = $_SESSION['usr_id'];
	$activeStatus = "UPDATE login set active=0 where id='$id'";
    $run_activeStatus = mysqli_query($con,$activeStatus);
	session_destroy();
	unset($_SESSION['usr_id']);
	unset($_SESSION['usr_name']);
	unset($_SESSION['first_login']);
	header("Location:../index.php");
} else {
	header("Location: home.php");
}
?>