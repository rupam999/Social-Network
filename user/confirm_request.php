<?php
include("dbconnect.php");

 if(isset($_GET['reciver_id']) && isset($_GET['sender_id'])){
  $rec_id = $_GET['reciver_id'];
  $sen_id = $_GET['sender_id'];
  $req_id = $_GET['request_id'];
}

  $get_friend_request_info = "SELECT * FROM friend_request where request_id='$req_id'";
  $run_get_friend_request_info = mysqli_query($con,$get_friend_request_info);
  $row_get_friend_request_info = mysqli_fetch_array($run_get_friend_request_info);

  $sen_id = $row_get_friend_request_info['sender_id'];
  $rec_id = $row_get_friend_request_info['receiver_id'];

  $error = false;
  $accept = 1;

  if (!$error) {
    if(mysqli_query($con, "UPDATE friend_request set response='$accept' WHERE request_id='$req_id'")) {
      if (!$error) {
        if(mysqli_query($con, "INSERT INTO friends(rec_id,friend_id,req_id) VALUES('" . $rec_id . "','" . $sen_id . "','" . $req_id . "')")) {
          if(mysqli_query($con, "INSERT INTO friends(rec_id,friend_id,req_id) VALUES('" . $sen_id . "','" . $rec_id . "','" . $req_id . "')")) {
            echo "<script>alert('All work fine');</script>";
            header("location:home.php");
          } else {
            echo "<script>alert('ERROR in inserting in Friends... Try again latter...')</script>";
            header("location:home.php");
          }
          // echo "<script>alert('Friend request acept sucessfully');</script>";
          header("location:home.php");
        } else {
          echo "<script>alert('ERROR in inserting in Friends... Try again latter...')</script>";
          header("location:home.php");
        }
      }
    } else {
      echo "<script>alert('ERROR in accepting Friend request... Try again latter...')</script>";
      header("location:home.php");
    }
  }
	
?>