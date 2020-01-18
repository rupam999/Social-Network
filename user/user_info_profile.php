<?php
  session_start();
?>
<?php
  include("dbconnect.php");
  //include("function.php");

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
    header("location:home.php");
  }
?>

<?php

  if(isset($_POST['submit'])){

    function GetImageExtension($imagetype)
      {
          if(empty($imagetype)) return false;
          switch($imagetype)
          {
            case 'image/bmp': return '.bmp';
            case 'image/gif': return '.gif';
            case 'image/jpeg': return '.jpg';
            case 'image/png': return '.png';
            default: return false;
          }
    }

    $file_name=$_FILES["uploadedimage"]["name"];
    $temp_name=$_FILES["uploadedimage"]["tmp_name"];
    $imgtype=$_FILES["uploadedimage"]["type"];
    $ext= GetImageExtension($imgtype);
    $imagename=date("d-m-Y")."-".time().$ext;
    $target_path = "profile_img/".$imagename;


    move_uploaded_file($temp_name, $target_path);

    // 1 for profile picture  and 2 for cover
    $profile = 1;

    // cover picture
    $file_name2=$_FILES["uploadedimage2"]["name"];
    $temp_name2=$_FILES["uploadedimage2"]["tmp_name"];
    $imgtype2=$_FILES["uploadedimage2"]["type"];
    $ext2= GetImageExtension($imgtype);
    $imagename2=date("d-m-Y")."-".time().$ext2;
    $target_path2 = "cover_img/".$imagename2;


  move_uploaded_file($temp_name2, $target_path2);

  $check = date("d-m-Y")."-".time();
  if($imagename == $check){
      $imagename = "";
    }

    if($imagename2 == $check){
      $imagename2 = "";
    }

  // 1 for profile picture and 2 for cover
  $cover = 2;
  // $date = date("Y-n-j");
  $date = "0000-00-00";

  $update_profile_pic = "UPDATE personal_details set profile_pic='$imagename' where u_id='$user'";
  $update_cover_pic = "UPDATE personal_details set cover_pic='$imagename2' where u_id='$user'";

  // $run_update1 = mysqli_query($con,$insert_img1);
  // $run_update2 = mysqli_query($con,$insert_img2);
  $run_update3 = mysqli_query($con,$update_profile_pic);
  $run_update4 = mysqli_query($con,$update_cover_pic);

    if($run_update3 && $run_update4){
      // insert into post start
      if(mysqli_query($con, "INSERT INTO posts(u_id,image,profile_img) VALUES('" . $user . "','" . $imagename . "','" . $profile . "')")) {
        if(mysqli_query($con, "INSERT INTO posts(u_id,image,profile_img) VALUES('" . $user . "','" . $imagename2 . "','" . $cover . "')")) {
          if(mysqli_query($con, "INSERT INTO profile_image(u_id,name,category) VALUES('" . $user . "','" . $imagename . "','" . $profile . "')")) {
            if(mysqli_query($con, "INSERT INTO profile_image(u_id,name,category) VALUES('" . $user . "','" . $imagename2 . "','" . $cover . "')")) {
              echo "<script>alert('ok');</script>";
            } else {
              $errormsg = "Error in updating...Please try again later!";
            }
          } else {
            $errormsg = "Error in updating...Please try again later!";
          }
        } else {
          $errormsg = "Error in updating...Please try again later!";
        }
      } else {
        $errormsg = "Error in updating...Please try again later!";
      }
      // insert into post ends here
      header("location:home.php");
    } else{
      echo "<script>alert('Some problem occur!');</script>";
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
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

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
                                <h2>Profile & Cover Photo</h2>
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
                            <form action="" method="post" enctype="multipart/form-data">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <!-- upload image -->
                                    <label for="exampleInputProfile">Profile Picture : </label>
                                    <input name="uploadedimage" type="file" class="" data-max-file-size="3MB" data-max-files="1" id="imgInp" />
                                  </div>
                                  <div class="preview_image">
                                    <script type='text/javascript'>
                                      function readURL(input) {
                                        if (input.files && input.files[0]) {
                                          var reader = new FileReader();
                                          reader.onload = function(e) {
                                            $('#blah').attr('src', e.target.result);
                                          }
                                          reader.readAsDataURL(input.files[0]);
                                        }
                                      }
                                      $("#imgInp").change(function() {
                                        readURL(this);
                                      });
                                    </script>
                                    <div class="imagePreview1">
                                      <img id="blah" src="#" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputProfile">Cover Picture : </label>
                                    <input name="uploadedimage2" type="file" class="" data-max-file-size="3MB" data-max-files="1"  onchange="preview_image(event)" />
                                  </div>
                                  <div class="imagePreview1">
                                      <script type='text/javascript'>
                                        function preview_image(event) 
                                        {
                                         var reader = new FileReader();
                                         reader.onload = function()
                                         {
                                          var output = document.getElementById('output_image');
                                          output.src = reader.result;
                                         }
                                         reader.readAsDataURL(event.target.files[0]);
                                        }
                                      </script>
                                      <img id="output_image" src="#" />
                                    </div>
                                </div>
                              </div><br>
                              <div class="row">
                                <div class="col-md-3">
                                  <a>
                                    <button type="submit" name="skip" style="padding-left: 23px;padding-right: 23px;" class="btn btn-primary logbutton2">&nbsp;&nbsp;Skip this&nbsp;&nbsp;</button>
                                  </a>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                  <button type="submit" name="submit" class="btn btn-primary logbutton2">Save & Continue</button>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

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