
<?php
  session_start();
?>
<?php
  include("dbconnect.php");

  $user = $_SESSION['usr_id'];
  $get_login_data = "SELECT * FROM login where id='$user'";
  $run_login_data = mysqli_query($con,$get_login_data);
  $row_login_data = mysqli_fetch_array($run_login_data);

  $name = $row_login_data['name'];
  $email = $row_login_data['email'];
  $gender = $row_login_data['gender'];
?>

<?php
  if (isset($_POST['skip'])) {
    header("location:user_info_profile.php");
  }
?>

<?php
$error = false;

if (isset($_POST['update'])) {

  $name = mysqli_real_escape_string($con, $_POST['new_name']);
  $email = mysqli_real_escape_string($con, $_POST['new_email']);
  $dob = $_POST['dob'];
  $c_city = mysqli_real_escape_string($con, $_POST['c_city']);
  $p_city = mysqli_real_escape_string($con, $_POST['p_city']);
  $school = mysqli_real_escape_string($con, $_POST['school']);
  $college = mysqli_real_escape_string($con, $_POST['college']);
  $company = mysqli_real_escape_string($con, $_POST['company']);

  $time=strtotime($dob);
  $year=date("Y",$time);

  $day=0;
  $month=0;

  $day = date("d",$time);
  $month = date("m",$time);

  $blank = "";



  if(strlen($name) < 6) {
    $error = true;
    $name_error = "Name must contain minimum 5 cheracter";
  }

  if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $email_error = "Please Enter Valid Email ID";
  }


  if (!$error) {
    if(mysqli_query($con, "INSERT INTO personal_details(u_id,name,email,day,month,year,c_city,p_city,school,college,company,about_me,profile_pic,cover_pic) VALUES('" . $user . "','" . $name . "','" . $email . "','" . $day . "', '" . $month . "','" . $year . "','" . $c_city . "','" . $p_city . "','" . $school . "','" . $college . "','" . $company . "','" . $blank . "','" . $blank . "','" . $blank . "')")) {
      header("location:user_info_profile.php");
    } else {
      $errormsg = "Error in updating...Please try again later! skip these step now...";
    }
  }
}
?>

<?php if ($_SESSION['first_login'] == 0) { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- filepond libery css -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">

    <!-- My css -->
    <link rel="stylesheet" type="text/css" href="css/user_info.css">
    <style type="text/css">
      .row{
        width: 100%;
      }
    </style>

  </head>
<body>


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
              </div>
            </nav>
          </div>
        </div><!--End Of upper section-->
      </div><!--End Of Wrapper-->
    </div>
    <!-- end of nav -->

    <!-- body area -->
          <div class="" style="background-image: url(&quot;../images/main-bg.jpg&quot;);width: 100%;height: 100%;"><br>
            <div class="container" style="margin-top: 10px;margin-bottom: 12px;">
              <!-- start of login register area -->
              <div>
                <div class="card card-default card-nav-tabs" style="background: rgba(0,0,0,0.8);">
                  <div class=" card-header-primary">
                    <div class="nav-tabs-navigation">
                      <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs" style="border: 0px;">
                          <li class="nav-item col-md-12" style="padding: 0px;">
                            <a class="nav-link active show nav_log_reg" href="#register" data-toggle="tab" style="border-radius: 0px;"><i class="material-icons"></i>
                              <div class="heading_info">
                                <h2>Basic Information</h2>
                                <?php
                                  if (isset($errormsg)) {
                                    echo $errormsg;
                                  }
                                ?>
                              </div>
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
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputName">Full Name</label>
                                    <input type="text" class="form-control" aria-describedby="nameHelp" value="<?php echo $name; ?>" name="new_name" placeholder="Enter Name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">E-mail id</label>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" value="<?php echo $email; ?>" name="new_email" placeholder="Enter email">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputDOB">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" aria-describedby="emailDOB">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCity">Add Current City</label>
                                    <input type="text" class="form-control" aria-describedby="cityHelp" name="c_city" placeholder="Enter Current City">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputCity">Add Pernament City</label>
                                    <input type="text" class="form-control" aria-describedby="cityHelp" name="p_city" placeholder="Enter Pernament City">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputSchool">Add School</label>
                                    <input type="text" class="form-control" aria-describedby="schoolHelp" name="school" placeholder="Enter School">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCollege">Add College</label>
                                    <input type="text" class="form-control" aria-describedby="collegeHelp" name="college" placeholder="Enter College">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCompany">Add Company</label>
                                    <input type="text" class="form-control" aria-describedby="companyHelp" name="company" placeholder="Enter Company">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-2">
                                  <a href="#">
                                    <button type="reset" style="padding-right: 23px;padding-left: 23px;" name="skip" class="btn btn-primary logbutton2">&nbsp;&nbsp;Reset&nbsp;&nbsp;</button>
                                  </a>
                                </div>
                                <div class="col-md-7"></div>
                                <div class="col-md-3">
                                  <button type="submit" name="update" class="btn btn-primary logbutton2">Save & Continue</button>
                                </div>
                              </div>
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
            </div><br>
          </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- filepond libery js -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
      FilePond.parse(document.body);
    </script>

    <script src="js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/navbar.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

</body>
</html>
<?php 
  } else{
  header("location:home.php");
  }
?>