<?php
  include_once 'dbconnect.php';

  if(isset($_SESSION['usr_id'])!="") {
  header("Location:user/home.php");
}
?>

<?php

$error = false;

if (isset($_POST['signup'])) {

  $name = mysqli_real_escape_string($con, $_POST['name']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $gender = mysqli_real_escape_string($con, $_POST['gender']);
  $password = mysqli_real_escape_string($con, $_POST['password']);



  if(strlen($name) < 6) {
    $error = true;
    $name_error = "Name must contain minimum 5 cheracter";
  }

  // check previous email id
  $get_login_email = "SELECT * FROM login";
  $run_login_email = mysqli_query($con,$get_login_email);
  while($row_email=mysqli_fetch_array($run_login_email)){
    $previous_email=$row_email['email'];
    if ($previous_email == $email) {
      $error = true;
      $email_error = "E-mail id is already present";
    }
  }

  if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $email_error2 = "Please Enter Valid Email ID";
  }

  if(strlen($password) < 6) {
    $error = true;
    $password_error = "Password must contain minimum 6 cheracter";
  }


  if (!$error) {
    if(mysqli_query($con, "INSERT INTO login(name,email,gender,password) VALUES('" . $name . "','" . $email . "','" . $gender . "', '" . md5($password) . "')")) {
      $successmsg = "Successfully Registered!";
    } else {
      $errormsg = "Error in registering...Please try again later!";
    }
  }
}
?>

<?php

//check if form is submitted
if (isset($_POST['login'])) {

  $email2 = mysqli_real_escape_string($con, $_POST['email1']);
  $pass2 = md5(mysqli_real_escape_string($con, $_POST['password1']));
  $result = mysqli_query($con, "SELECT * FROM login WHERE email = '" . $email2. "' and password = '" . $pass2 . "'");

  if ($row = mysqli_fetch_array($result)) {
    session_start();
    $id = $row['id'];
    $_SESSION['usr_id'] = $row['id'];
    $_SESSION['usr_name'] = $row['name'];
    $_SESSION['first_login'] = $row['first_login'];

    //$timeNow = date("Y/n/j h:i:s");
    // $timeNow = date('Y-m-d H:i:s');
    // $active_time=$timeNow 

    $activeStatus = "UPDATE login set active=1 where id='$id'";
    $run_activeStatus = mysqli_query($con,$activeStatus);

    if($_SESSION['first_login'] == 0){

      $update_login = "UPDATE login set first_login=1 where id='$id'";
      $run_update = mysqli_query($con,$update_login);

      if ($run_update) {
        header("Location:user/user_info.php");
      }
    }
    else{
      header("Location:user/home.php");
    }
  } else {
    $errormsg2 = "<center style='color:red;'font-weight:bold;>Incorrect Email or Password!!!</center>";
  }

}
 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- My custom css -->
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">

    <style type="text/css">
      .row{
        width: 100%;
      }
    </style>

  </head>
  <body>

    <div class="top_shair">
      <div class="container">
        <div class="header clearfix">
          <nav>
            <ul class="nav nav-pills float-right">
              <!-- <li class="nav-item">
                <a class="nav-link sep_login" href="login.php">Login&nbsp;&nbsp; <span style="color: #bdc3c7;">|</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link sep_register" href="register.php">Register</a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li>
              <li class="nav-item facebook">
                <a class="nav-link social_icon" href="https://www.facebook.com/sharer.php?u=https%3A%2F%2Frupamcompany.000webhostapp.com%2Fd_index.php"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li class="nav-item twitter">
                <a class="nav-link social_icon" style="padding-left: 12px;" href="https://twitter.com/intent/tweet?url=https%3A%2F%2Frupamcompany.000webhostapp.com%2Fd_index.php&text=Rupam%20Company%20%7C%20Web%20Page%20Company&via=rupamcompany&related=rupamch21309795"><i class="fab fa-twitter"></i></a>
              </li>
              <li class="nav-item google_plus">
                <a class="nav-link social_icon" style="padding-left: 12px;" href="https://plus.google.com/share?url=https%3A%2F%2Frupamcompany.000webhostapp.com%2Fd_index.php"><i class="fab fa-google-plus-g"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- top section ends here -->

    <div class="">
      <div class="wrapper">
        <div class="upper">
          <div class="container">
            <nav class="navbar navbar-expand-lg">
              <a class="navbar-brand" href="index.php" style="font-family: 'Titillium Web', sans-serif;font-weight: ;color:black;">
                ShareFrame
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <!-- Left side navbar -->
                </ul>
                <form class="form-inline my-2 my-lg-0 form-container" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <?php
                    if (isset($errormsg2)) {
                      echo $errormsg2;
                      echo "&nbsp;&nbsp;";
                    }
                  ?>
                  <input class="form-control mr-sm-2" type="email" name="email1" placeholder="Your E-mail" name="email1" required autofocus>
                  <input class="form-control mr-sm-2" type="password" name="password1" name="password1" placeholder="Your password">
                  &nbsp;&nbsp;
                  <button class="btn btn-outline-default my-2 my-sm-0 logbutton" name="login" type="submit" name="login">&nbsp;Login&nbsp;</button>
                  &nbsp;&nbsp;
                  <button class="btn btn-outline-default my-2 my-sm-0 logbutton" type="reset">&nbsp;Reset&nbsp;</button>
                </form>
              </div>
            </nav>
          </div>
        </div><!--End Of upper section-->
      </div><!--End Of Wrapper-->
    </div>
    <!-- end of nav -->

    <!-- main body start here -->
    <div class="jumbotron main_cont" style="background-image: url(&quot;images/main-bg.jpg&quot;);">
      <div class="in_main_cont">
        <div class="container">
          <div class="row">
            <div class="col-sm-7 col-md-7">
              <div class="text_area">
                <div class="main_text">
                  <h1>See what’s <span style="color: #0099ff;">happening</span> in the world right now</h1>
                  <h6>ShareFrame is an online platform that allows users to create a public profile and interact with other users on the website.So create your profile and shair your pic bios,chat with your friends,family members at free of cost.</h6>
                </div>
              </div>
            </div>
            <div class="col-sm-5 col-md-5">
              <!-- start of login register area -->
              <div>
                <div class="card card-default card-nav-tabs" style="background: rgba(0,0,0,0.8);">
                  <div class=" card-header-primary">
                    <div class="nav-tabs-navigation">
                      <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs" style="border: 0px;">
                          <li class="nav-item col-md-12" style="padding: 0px;">
                            <a class="nav-link active show nav_log_reg" href="#register" data-toggle="tab" style="border-radius: 0px;"><i class="material-icons"></i>
                              <p style="margin-bottom: 0px;">Register Now</p>
                              <center>
                                <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
                                <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
                              </center>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-body ">
                    <div class="tab-content text-center">
                      <div class="tab-pane active show" id="register">
                        <!--  -->
                        <div class="container-fluid">
                          <div class="div-pad" style="margin-left: 0px;">
    <form action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <br>
      <div class="form-group">
        <input type="text" class="form-control reg_log" required name="name" placeholder="Enter Your Name">
        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
      </div>

      <div class="form-group">
        <input type="email" class="form-control reg_log" required name="email" placeholder="Enter email" style="margin-bottom: 0px;">
        <small class="form-text text-muted" style="float: left;margin-bottom: 0px;">We'll never share your email with anyone else.</small><br>
        <span class="text-danger"><?php if (isset($email_error)) echo "<br>".$email_error; ?></span>
        <span class="text-danger"><?php if (isset($email_error2)) echo "<br>".$email_error2; ?></span>
      </div>
      <div class="clear"></div>

      <div class="form-group gender">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" required name="gender" id="maleRadio" value="male"><label class="form-check-label" for="maleRadio">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" required name="gender" id="femaleRadio" value="female"><label class="form-check-label" for="femaleRadio">Female</label>
        </div>
      </div>

      <div class="form-group">
        <input type="password" name="password" required class="form-control reg_log" placeholder="Enter Password">
        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
      </div>

      <input type="submit" class="btn btn-outline-default my-2 my-sm-0 logbutton2" name="signup" value="Register Now">
      <br>
    </form>
                          </div>
                        </div>
                        <!--  -->
                      </div>
                      <!-- area ends -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- end of login register area -->
            </div>
          </div>
        </div> <!--End of container-->
      </div>
    </div>
    <!-- main body ends here -->


    <!-- footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-11">
            <p>Copyright &copy; 2018 <span><a href="index.php">ShareFrame</a></span>. All Rights reserved.</p>
          </div>
          <div class="col-md-1">
            <div id="google_translate_element"></div>
          </div>
        </div>
      </div>
    </footer>
    <br>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript">
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
      }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  </body>
</html>
