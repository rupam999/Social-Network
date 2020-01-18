<?php
//session_start();
include("dbconnect.php");
//$user = $_SESSION['usr_id'];


 if(isset($_GET['reciver_id']) && isset($_GET['sender_id'])){
  $rec_id = $_GET['reciver_id'];
  $sen_id = $_GET['sender_id'];

 $none = 0;
}
 $error = false;

  if (!$error) {
    if(mysqli_query($con, "INSERT INTO friend_request(sender_id,receiver_id) VALUES('" . $sen_id . "','" . $rec_id . "')")) {
    	echo "<script>alert('Friend request send sucessfully');</script>";
     	header("location:home.php");
    } else {
      echo "<script>alert('ERROR in Sending Friend request... Try again latter...')</script>";
      header("location:home.php");
    }
  }

	
?>