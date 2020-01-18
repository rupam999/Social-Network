<?php
session_start();
include("dbconnect.php");
$user = $_SESSION['usr_id'];

// print_r($_POST);

$message = mysqli_real_escape_string($con, $_POST['message']);
// $rec_id = mysqli_real_escape_string($con, $_POST['active_id']);

// echo "<script>alert($message);</script>";

        $get_user_send_friendreq_info = "INSERT INTO chat(sender_id,message) VALUES('" . $user . "','" . $message . "')";
        $run_get_user_send_friendreq_info = mysqli_query($con,$get_user_send_friendreq_info);
 ?>