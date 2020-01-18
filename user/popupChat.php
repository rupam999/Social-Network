<?php
  session_start();
?>
<?php
  include("dbconnect.php");
  include("function.php");
  $user = $_SESSION['usr_id'];
?>

<?php
if (isset($_POST['sendMsg'])) {
  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];
    $message = mysqli_real_escape_string($con,$_POST['message']);
    $getMessage = "INSERT INTO personal_chat(sender_id,receiver_id,message) VALUES('$user','$u_id','$message')";
    $run_getMessage = mysqli_query($con,$getMessage);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="10" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/popupchat.css">

    <style type="text/css">
      .row{
        width: 100%;
      }
    </style>

    <!-- <script type="text/javascript">
     var timer = null;
      function auto_reload()
      {
        window.location = '_self';
      }
    </script> -->

  </head>
  <body>
    
    <div class="mainChatArea">
      <?php
      if(isset($_GET['u_id'])){
        $u_id = $_GET['u_id'];
        // echo "<script>alert($id)</script>";
        $sqlDetails = "SELECT name FROM personal_details WHERE u_id=$u_id";
        $run_sqlDetails = mysqli_query($con,$sqlDetails);
        $row_sqlDetails = mysqli_fetch_array($run_sqlDetails);
        $name = $row_sqlDetails['name'];
      }
    ?>
    <div class="card userArea">
      <div class="card-header">
        <div class="row">
          <div class="col-2 col-sm-2 col-md-2" style="padding-top: 6px;"> 
            <div class="active"></div>
          </div>
          <div class="col-9 col-sm-9 col-md-9 heading" style="padding-left: 0px;"> 
            <h3><?php echo $name ?></h3>
          </div>
        </div>
      </div>
      <div class="card-body" style="padding: 0px;">
          <div class="messageSection">
            <?php
              $getChat = "SELECT * FROM personal_chat WHERE sender_id=$user OR receiver_id=$user";
              $runChat = mysqli_query($con,$getChat);
              while($getChatData = mysqli_fetch_array($runChat)){
                $sender_id = $getChatData['sender_id'];
                $receiver_id = $getChatData['receiver_id'];
                $message = $getChatData['message'];

                if (($sender_id == $user && $receiver_id == $u_id) || ($sender_id == $u_id && $receiver_id == $user)) {
                  if ($sender_id == $user) {
                    echo "<div class='msg_b'>$message</div>";
                  } else if($receiver_id == $user){
                    echo "<div class='msg_a'>$message</div>";
                  }
                }
              }
            ?>

          </div>
          <form id="sendMsg" method="POST" action="" style="padding-top: 18px;">
            <div class="form-group messageArea" style="margin-bottom: 0px;">
              <input type="text" class="form-control" name="message" rows="2">
              <input type="submit" name="sendMsg" value="Send_Now" style="display: none;">
            </div>
        </form>
      </div>
    </div>
  </div>


    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>   
</body>
</html>