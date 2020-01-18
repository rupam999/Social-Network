<?php
session_start();
include("dbconnect.php");
$user = $_SESSION['usr_id'];


         $get_messageFromDB = "SELECT * FROM chat";
          $run_get_messageFromDB = mysqli_query($con,$get_messageFromDB);
          while($row_get_messageFromDB = mysqli_fetch_array($run_get_messageFromDB)){

            $sender_id = $row_get_messageFromDB['sender_id'];
            $message = $row_get_messageFromDB['message'];

            if(($sender_id == $user)){

              echo "
                <div class='msg_b'>$message</div>
              ";

            } else if (($sender_id != $user)) {

            	echo "
                	<div class='msg_a'>$message</div>
              	";

            }
          }
        ?>
        <!-- for scroll -->
        <script type="text/javascript">
        	$("#mainChat").animate({ scrollTop: $("#mainChat")[0].scrollHeight}, 'fast');
        </script>