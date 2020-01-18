<?php
  session_start();
?>
<?php
  include("dbconnect.php");
  include("function.php");
  $user = $_SESSION['usr_id'];
  if (isset($_GET['group_id'])) {
    $group_id = $_GET['group_id'];
  }
?>
<?php
  $user = $_SESSION['usr_id'];
  $get_user_personal_info = "SELECT * FROM personal_details where u_id='$user'";
  $run_user_personal_info = mysqli_query($con,$get_user_personal_info);
  $row_user_personal_info = mysqli_fetch_array($run_user_personal_info);

  $name = $row_user_personal_info['name'];
  $email = $row_user_personal_info['email'];
  $profile_pic = $row_user_personal_info['profile_pic'];
  $cover_pic = $row_user_personal_info['cover_pic'];

  if ($profile_pic == "") {
    $profile_pic = "blank_profile2.png";
  }
  if ($cover_pic == "") {
    $cover_pic = "blank_cover.png";
  }
?>

<?php
include("dbconnect.php");
$user = $_SESSION['usr_id'];

if (isset($_POST['create'])) {
  $error = false;

  $groupName = mysqli_real_escape_string($con, $_POST['groupName']);
  $groupDesc = mysqli_real_escape_string($con, $_POST['groupDesc']);


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
    $target_path = "group_profile_img/".$imagename;

    move_uploaded_file($temp_name, $target_path);


    $file_name2=$_FILES["uploadedimage2"]["name"];
    $temp_name2=$_FILES["uploadedimage2"]["tmp_name"];
    $imgtype2=$_FILES["uploadedimage2"]["type"];
    $ext2= GetImageExtension($imgtype);
    $imagename2=date("d-m-Y")."-".time().$ext2;
    $target_path2 = "group_img/".$imagename2;

    move_uploaded_file($temp_name2, $target_path2);

    $check = date("d-m-Y")."-".time();

    if($imagename == $check){
      $imagename = "";
    }

    if($imagename2 == $check){
      $imagename2 = "";
    }



    if (true) {
      if(mysqli_query($con, "INSERT INTO groupDes(groupname,groupdes,groupimg,groupcover,createdby) VALUES('" . $groupName . "','" . $groupDesc . "','" . $imagename . "','" . $imagename2 . "','" . $user . "')")){

          $get_group_1 = "SELECT groupid FROM groupDes WHERE createdby=$user ORDER BY groupid DESC";
          $run_get_group_1 = mysqli_query($con,$get_group_1);
          $row_get_group_1 = mysqli_fetch_array($run_get_group_1);

          $group_id = $row_get_group_1['groupid'];

          // echo "<script>alert($groupid)</script>";

          if(mysqli_query($con, "INSERT INTO groupmember(groupid,u_id) VALUES('" . $group_id . "','" . $user . "')")){
            header("location:home.php?msg='Group Created sucess'");
          } else {
            echo "<script>alert('Problem in Creating...Try Again latter...')</script>";
          }
        } else {
          echo "<script>alert('Problem in Creating...Try Again latter...')</script>";
        }
    }

}
?>

<?php
include("dbconnect.php");
$user = $_SESSION['usr_id'];

if (isset($_POST['postImage'])) {

  $error = false;

  $img_text = mysqli_real_escape_string($con, $_POST['img_text']);

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
    $target_path = "post_img/".$imagename;


    move_uploaded_file($temp_name, $target_path);

    $check = date("d-m-Y")."-".time();
    $onlyText = 0;
    if($imagename == $check){
      $onlyText = 1;
      $imagename = "";
    }
    $profileImage = 0;
    $group_post = 1;


  if (true) {
    if(mysqli_query($con, "INSERT INTO posts(u_id,img_text,image,profile_img,onlyText,group_post,group_id) VALUES('" . $user . "','" . $img_text . "','" . $imagename . "','" . $profileImage . "','" . $onlyText . "','" . $group_post . "','" . $group_id . "')")){
        header("location:viewGroup.php?group_id=$group_id");
      } else {
        echo "<script>alert('Problem in uploading...Try Again latter...')</script>";
      }
  }
}
?>


<?php
include("dbconnect.php");
$user = $_SESSION['usr_id'];

if (isset($_POST['postImageNav'])) {

  $error = false;

  $img_text = mysqli_real_escape_string($con, $_POST['img_text']);

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
    $target_path = "post_img/".$imagename;


    move_uploaded_file($temp_name, $target_path);

    $check = date("d-m-Y")."-".time();
    $onlyText = 0;
    if($imagename == $check){
      $onlyText = 1;
      $imagename = "";
    }
    $profileImage = 0;


  if (true) {
    if(mysqli_query($con, "INSERT INTO posts(u_id,img_text,image,profile_img,onlyText) VALUES('" . $user . "','" . $img_text . "','" . $imagename . "','" . $profileImage . "','" . $onlyText . "')")){
        echo "<script>alert('ok')</script>";
        header("location:home.php");
      } else {
        echo "<script>alert('Problem in uploading...Try Again latter...')</script>";
      }
  }
}
?>


<?php
include("dbconnect.php");
$user = $_SESSION['usr_id'];

    $getGroup = "SELECT * FROM groupdes WHERE groupId=$group_id";
    $run_getGroup = mysqli_query($con,$getGroup);
    $row_getGroup = mysqli_fetch_array($run_getGroup);

    $groupname = $row_getGroup['groupname'];
    $groupimg = $row_getGroup['groupimg'];
    $groupcover = $row_getGroup['groupcover'];

    if ($groupcover == "") {
      $groupcover = "groupCoverPhoto.png";
    }

?>

<?php
  if (isset($_POST['joinGroup'])) {
    if(mysqli_query($con, "INSERT INTO groupmember(groupid,u_id) VALUES('" . $group_id . "','" . $user . "')")){
      header("location:viewGroup.php?group_id=$group_id");
    }
  }
?>

<?php

    include("dbconnect.php");
    $user = $_SESSION['usr_id'];

    if (isset($_POST['search'])){
      $searchData = mysqli_real_escape_string($con, $_POST['search_value']);
      header("location:searchData.php?searchData=$searchData");
    }

?>

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

    <!-- My css -->
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
    <link rel="stylesheet" type="text/css" href="css/main_body.css">
    <link rel="stylesheet" type="text/css" href="css/view_profile.css">
    <link rel="stylesheet" type="text/css" href="css/view_group.css">
    <style type="text/css">
      .row{
        width: 100%;
      }
    </style>

  </head>
<body>

<?php if (isset($_SESSION['usr_id'])) {?>

<!-- navbar starts here -->
<div class="upper_nav">
  <div class="wrapper">
    <nav class="navbar navbar-expand-md fixed-top">
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active" style="">
            <a class="nav-link" href="home.php" style="color: #1DA1F2;">
              <i class="fas fa-home"></i>&nbsp;Home
            </a>
          </li>
          <li class="nav-item">
            <li class="nav-item dropdown navdrop">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fas fa-users"></i>&nbsp;Find friends </a>
            <ul class="dropdown-menu" role="menu" style="padding: 0;">
              <div class="friend_request_list">
                <div class="list_nav_bar">
                  <h5><a href="#">Friend Requests</a></h5>
                  <div class="request_list">
                    <!-- request list start -->
                    <?php get_requestList(); ?>
                    <!-- request list ends here -->
                  </div>
                  <h5><a href="">Friend Suggection</a></h5>
                  <div class="suggection_list_nav">
                    <!-- suggection list start -->
                    <?php get_suggectionList(); ?>
                    <!-- suggection list ends here -->
                  </div>
                </div>
              </div>
            </ul>
          </li>
          
          <li class="nav-item dropdown navdrop">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fas fa-birthday-cake"></i>&nbsp;Birthday </a>
            <ul class="dropdown-menu" role="menu" style="padding: 0;">
              <div class="message_list">
                <div class="list_message_area">
                  <h5><a href="#">Recent Birthday</a></h5>
                  <div class="message_area">
                    <!-- php -->
                    <?php
                      $day = date("j");
                      $month = date("n");
                      $year = date("Y");

                      $get_birthday = "SELECT * FROM personal_details WHERE day=$day AND month=$month";
                      $run_get_birthday = mysqli_query($con,$get_birthday);
                      while($row_get_birthday = mysqli_fetch_array($run_get_birthday)){

                        $u_id123 = $row_get_birthday['u_id'];
                        $name123 = $row_get_birthday['name'];
                        $birthYear = $row_get_birthday['year'];
                        $profile_pic123 = $row_get_birthday['profile_pic'];

                        $age = $year - $birthYear;

                        $get_birthdayFriend = "SELECT * FROM friends WHERE rec_id=$user AND friend_id=$u_id123";
                        $run_get_birthdayFriend = mysqli_query($con,$get_birthdayFriend);
                        $row_get_birthdayFriend = mysqli_fetch_array($run_get_birthdayFriend);

                        if($row_get_birthdayFriend>0){
                          echo "
                            <!-- birthday list area start here -->
                            <div class='row'>
                              <div class='col-md-2 list_profile_pic'>
                                <img src='profile_img/$profile_pic123'>
                              </div>
                              <div class='col-md-6 message_cont' style='padding: 0;'>
                                <h6 style='padding-top:10px;'><a href='view_profile.php?u_id=$u_id123'>$name123</a></h6>
                              </div>
                              <div class='col-md-2' style='padding-top:6px;;'>
                                <input type='button' value='$age&nbsp;years old' class='btn btn-sm confirm_btn'
                              </div>
                            </div>
                            <hr style='margin-top: 4px;margin-bottom: 4px;'>
                            <!-- birthday list area ends here -->
                          ";
                        }

                      }
                    ?>
                  </div>
                </div>
              </div>
            </ul>
          </li>
          <!-- end of dropdown -->

          <li class="nav-item">
            <li class="nav-item navdrop create">
              <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>&nbsp;Create </a>
            </li>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="width:548px;position: relative;left: -40px;top: -10px;">
                  <div class="modal-header" style="background-color: #f5f6f7;border-bottom: 1px solid #e5e5e5;border-radius: 3px 3px 0 0;color: #1d2129;font-weight: bold;line-height: 19px;padding: 10px 12px;">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="background: #fff;width: 100%;">
                    <div class="upperImageSec">
                      <div class="row">
                        <div class="col-md-2">
                          <img src="images/group.png">
                        </div>
                        <div class="col-md-10">
                          <p>
                            Groups are great for getting things done and staying in touch with just the people you want. Share photos and videos, have conversations, make plans and more.
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="createMainSec">
                        <form action="" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="exampleInputGroupName">Group Name</label>
                            <input type="text" name="groupName" class="form-control" placeholder="Enter Group Name">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputGroupDescription">Group Description</label>
                            <input type="text" name="groupDesc" class="form-control" placeholder="Enter Group Description">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputGroupIcon">Group Profile Image</label>
                            <input type="file" name="uploadedimage" class="form-control">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputCoverImage">Group Cover Image</label>
                            <input type="file" name="uploadedimage2" class="form-control">
                          </div>
                          <center>
                            <button class="btn logbuttonCreate" name="create">Create</button>
                          </center>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- modal ends here -->
          <!-- end of dropdown -->
          </li>
          <li style="padding-top: 7px;padding-left: 80px;">
            <?php
              if (isset($_GET['msg'])) {
                $msg = $_GET['msg'];
                echo "<span style='color:green;font-weight:600;'>".$msg."</span>";
              }
            ?>
          </li>
        </ul>
       <!-- right side elements -->
        <ul class="navbar-nav">
          <li class="nav-item search_bar">
            <form method="POST" action="">
              <input type="text" class="form-control form-area" name="search_value" placeholder="Search mynetwork">
              <input type="submit" name="search" style="display: none;">
            </form>
          </li>
          <li class="nav-item dropdown navdrop" style="padding-bottom: 4px;">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <img src="profile_img/<?php echo $profile_pic ?>">
              </a>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" style="padding: 0px;">
                <!-- account area -->
              <div class="account">
                <div class="row">
                  <div class="col-sm-5 col-md-5">
                    <div class="account_profile">
                      <img src="<?php echo 'profile_img/'.$profile_pic; ?>">
                    </div>
                  </div>
                  <div class="col-sm-7 col-md-7" style="padding: ;">
                    <div class="account_details">
                      <h5><?php name($name); ?></h5>
                      <h6><?php email($email); ?></h6>
                      <h6><a href="edit_profile.php?u_id=<?php echo $user ?>">
                        Edit profile
                      </a></h6>
                    </div>
                  </div>
                </div>  <!--End of row-->
                <div class="row">
                  <div class="col-md-12">
                    <hr style="margin: 15px 0px;width: 110%;">
                    <div class="settings">
                      <p>
                        <a href="view_profile.php?u_id=<?php echo $user ?>">
                          <img src="images/profile.png" class="common_icon">&nbsp;My Profile
                        </a>
                      </p>
                      <p>
                        <a href="viewUserFriends.php?u_id=<?php echo $user ?>">
                          <img src="images/friends.png" class="common_icon">&nbsp;Friends & peoples
                        </a>
                      </p>
                      <!-- <p>
                        <a href="#">
                          <img src="images/birthday.png" class="common_icon">
                          Birthdays
                        </a>
                      </p>
                      <p>
                        <a href="#">
                          <img src="images/settings.png" class="common_icon">
                          Settings & privacy
                        </a>
                      </p> -->
                    </div>
                    <hr style="margin: 15px 0px;width: 110%;">
                      <a href="#">
                        <center>
                          <a href="logout.php">
                            <input type="button" class="btn logout_btn" name="" value="Log out" style="padding-right: 0px;">
                          </a>
                        </center>
                      </a>
                    </div>
                </div>
              </div>
              <!-- account ends here -->
              </ul>
            <!-- end of dropdown -->
          </li>
          <li class="nav-item upload_btn">
            <a href="#">
              <input type="button" class="btn btn-default logbutton" name="" value="Upload" data-toggle="modal" data-target="#myModal">
            </a>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 548px;position: relative;left: -39px;top: 22px;">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Compose new Post </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="close_modal">&times;</span></button>
                  </div>
                  <div class="modal-body" style="background: #fff;">
                    <div class="modal_post_area">
                      <div class="row" style="margin-left: 35px;">
                        
                        <div class="col-xs-10 col-md-10" style="padding: 0;position: relative;left: -30px;">
                          
                          <div class='postGroup' style="border: 0px;margin-top: 0px;">
                        <div class='row' style='padding-top:13px;'>
                          <div class='col-md-1'></div>
                          <div class='col-md-11' style='padding-left: ;'>
                            <form method='POST' action='' enctype='multipart/form-data'>
                            <textarea class='status_text' name='img_text' style="width: 116%;" placeholder='Write Something Here...&#x0a;यहां कुछ लिखें ...'></textarea>
                            <hr style='margin: 0;'>
                          </div>
                          <div class='profilePicPart' style='height: 0;'>
                            <img src='profile_img/<?php echo $profile_pic ?>' style='position: relative;top: -55px;left: 9px;width: 40px;height: 40px;border-radius: 50%;padding-right: 2px;'>
                          </div>
                        </div>
                      <div class='row' style='width:101.2%;margin-left:;'>
                        <div class='col-md-12' style='padding: 0;margin-left: 6px;'>
                          <div class='bodyMenu'>
                            <div class='menu'>
                              <div class='row' style='margin: 0;padding: 0;'>
                                <div class='col-md-10 main_body_menu'>
                                  <button class='btn create-btn navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarHeader' aria-controls='navbarHeader' aria-expanded='false' aria-label='Toggle navigation'><span><img src='images/photosandvideos.png'>&nbsp;Images</span></button>&nbsp;&nbsp;<button class='btn create-btn' name=''><span><img src='images/create1.png'>&nbsp;Activity</span></button>
                                  <div class='collapse' id='navbarHeader'>
                                    <div class='wrapper main_nav_cont'>
                                      <div class='createCont'>
                                           <div class='form-group'>
                                            <input name='uploadedimage' type='file' class='' data-max-file-size='3MB' data-max-files='1' />
                                          </div>
                                          <div class='externalPost'>
                                            <div class='row'>
                                              <div class='col-md-12'>
                                                <input type='submit' name='postImageNav' class='btn logbutton4' value='Post'>
                                              </div>
                                            </div>
                                          </div>
                                        <!-- end of main image upload form -->
                                        <!--  -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-2 main_body_menu'>
                                  <button class='btn create-btn' name='postImageNav' style='background: #1DA1F2;padding-right:20px;'><span style='color: #fff;'>&nbsp;&nbsp;<i class='fas fa-share-square'></i>&nbsp;Share</span></button>
                                </div>
                                </form>
                                <!-- end of form -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- modal body ends here -->
                </div>
              </div>
            </div>
            <!-- end of modal -->
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>
<!-- ending of navbar -->

<!-- main body area strart here -->
  <div class="main_body">
    <div class="row" style="margin-right: 0;">
      <div class="col-md-9" style="margin-left:;">
        <div class="groupMainArea">
          <!-- group cover area start here -->
          <div class="groupCover">
            <img src="group_img/<?php echo $groupcover ?>" width="100%" height="330px">
            <div class="groupJoinSec">
              <div class="row">
                <div class="col-md-5 mainGroupName">
                  <h3><?php echo $groupname ?></h3>
                </div>
                <div class="col-md-3">
                  <div class="infoText">
                    <p>Only member can post...</p>
                  </div>
                </div>
                <div class="col-md-4">

                  <?php
                    $checkBtnName = "SELECT * FROM groupmember WHERE groupid=$group_id AND u_id=$user";
                    $run_checkBtnName = mysqli_query($con,$checkBtnName);
                    $row_checkBtnName = mysqli_fetch_array($run_checkBtnName);

                    if ($row_checkBtnName<=0) {
                      echo "
                        <form method='POST' action=''>
                          <button class='btn joingroupbtn' name='joinGroup'><span>Join group</span></button>
                        </form>
                      ";
                    } else{
                      echo "<button class='btn joingroupbtn'><span>Already Member</span></button>";
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <!-- group cover area ends here -->
          <!-- main body area start here -->
          <div class="mainGroupBodyArea">
            <div class="row" style="margin-left: 0px;">
              <div class="col-md-8" style="padding: 0;">
                <!-- inside body 1st big section start here -->
                <?php  
                  $checkBtnNameText = "SELECT * FROM groupmember WHERE groupid=$group_id AND u_id=$user";
                    $run_checkBtnNameText = mysqli_query($con,$checkBtnNameText);
                    $row_checkBtnNameText = mysqli_fetch_array($run_checkBtnNameText);

                    if ($row_checkBtnNameText>0) {
                    echo "
                      <div class='postGroup'>
                        <div class='row' style='padding-top:13px;'>
                          <div class='col-md-1'></div>
                          <div class='col-md-11' style='padding-left: ;'>
                            <form method='POST' action='' enctype='multipart/form-data'>
                            <textarea class='status_text' name='img_text' placeholder='Write Something Here...&#x0a;यहां कुछ लिखें ...'></textarea>
                            <hr style='margin: 0;'>
                          </div>
                          <div class='profilePicPart' style='height: 0;'>
                            <img src='profile_img/$profile_pic'>
                          </div>
                        </div>
                      <div class='row' style='width:101.2%;'>
                        <div class='col-md-12' style='padding: 0;margin-left: 6px;'>
                          <div class='bodyMenu'>
                            <div class='menu'>
                              <div class='row' style='margin: 0;padding: 0;'>
                                <div class='col-md-10 main_body_menu'>
                                  <button class='btn create-btn navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarHeader' aria-controls='navbarHeader' aria-expanded='false' aria-label='Toggle navigation'><span><img src='images/photosandvideos.png'>&nbsp;Images</span></button>&nbsp;&nbsp;<button class='btn create-btn' name=''><span><img src='images/create1.png'>&nbsp;Activity</span></button>
                                  <div class='collapse' id='navbarHeader'>
                                    <div class='wrapper main_nav_cont'>
                                      <div class='createCont'>
                                           <div class='form-group'>
                                            <input name='uploadedimage' type='file' class='' data-max-file-size='3MB' data-max-files='1' />
                                          </div>
                                          <div class='externalPost'>
                                            <div class='row'>
                                              <div class='col-md-12'>
                                                <input type='submit' name='postImage' class='btn logbutton4' value='Post'>
                                              </div>
                                            </div>
                                          </div>
                                        <!-- end of main image upload form -->
                                        <!--  -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class='col-md-2 main_body_menu'>
                                  <button class='btn create-btn' name='postImage' style='background: #1DA1F2;padding-right:20px;'><span style='color: #fff;'>&nbsp;&nbsp;<i class='fas fa-share-square'></i>&nbsp;Share</span></button>
                                </div>
                                </form>
                                <!-- end of form -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
                    ";
                  }
                ?>
                <!-- inside body 1st big section ends here -->
                <!-- news feed for group start here -->
                <div class="groupNewsFeddArea">
                  <?php 
                    getGroupNewsFeed();
                    echo "<br>";
                  ?>
                </div>
                <!-- news feed for group ends here -->
              </div>
              <div class="col-md-4" style="padding-right: 0;padding-left: 13px;">
                <!-- side small section for suggested group area start -->
                <div class="sideSmallSuggestedArea">
                  <h4>CREATE NEW GROUPS</h4>
                  <div class="row">
                    <div class="col-md-8">
                      <p class="intrpPara">
                        Groups make it easier than ever to share with friends, family and teammates.
                      </p>
                    </div>
                    <div class="col-md-4" style="padding: 0;">
                      <button type="button" class="btn createBtn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle"></i>&nbsp;Create</button>
                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content" style="width:548px;position: relative;left: -40px;top: -10px;">
                            <div class="modal-header" style="background-color: #f5f6f7;border-bottom: 1px solid #e5e5e5;border-radius: 3px 3px 0 0;color: #1d2129;font-weight: bold;line-height: 19px;padding: 10px 12px;">
                              <h5 class="modal-title" id="exampleModalLabel">Create New Group</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="background: #fff;width: 100%;">
                              <div class="upperImageSec">
                                <div class="row">
                                  <div class="col-md-2">
                                    <img src="images/group.png">
                                  </div>
                                  <div class="col-md-10">
                                    <p>
                                      Groups are great for getting things done and staying in touch with just the people you want. Share photos and videos, have conversations, make plans and more.
                                    </p>
                                  </div>
                                </div>
                              </div>
                              <div class="createMainSec">
                                  <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                      <label for="exampleInputGroupName">Group Name</label>
                                      <input type="text" name="groupName" class="form-control" placeholder="Enter Group Name">
                                    </div>

                                    <div class="form-group">
                                      <label for="exampleInputGroupDescription">Group Description</label>
                                      <input type="text" name="groupDesc" class="form-control" placeholder="Enter Group Description">
                                    </div>

                                    <div class="form-group">
                                      <label for="exampleInputGroupIcon">Group Profile Image</label>
                                      <input type="file" name="uploadedimage" class="form-control">
                                    </div>

                                    <div class="form-group">
                                      <label for="exampleInputCoverImage">Group Cover Image</label>
                                      <input type="file" name="uploadedimage2" class="form-control">
                                    </div>
                                    <center>
                                      <button class="btn logbuttonCreate" name="create">Create</button>
                                    </center>
                                  </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
            <!-- modal ends here -->
                    </div>
                  </div>
                </div>
                <!-- side smaill section for suggested group area ends  -->
                <div class="sGroups">
                  <!-- suggested pages start here -->
                  <div class='suggested_pages'>
                    <div class='content'>
                      <div class='row' style='margin: 0;'>
                        <div class='col-md-6 heading' style='padding-left: 3px;'>
                          <h4>Suggested Groups</h4>
                        </div>
                        <div class='col-md-2'></div>
                        <div class='col-md-4 viewall' style='padding-right: 5px;'>
                          <h4><a href='#'>Groups</a></h4>
                        </div>
                      </div>
                      <!-- slider -->
                      <div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
                          <div class='carousel-inner'>
                           
                            <?php getSuggestedGroupDetails(); ?>
                                
                          </div>
                        <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
                          <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                          <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
                          <span class='carousel-control-next-icon' aria-hidden='true'></span>
                          <span class='sr-only'>Next</span>
                        </a>
                      </div>
                    </div>
                  </div>
                  <!-- suggested pages ends here -->
                  <!-- copyright start -->
                  <div class="copyright">
                      <div class="content">
                        <p>
                          &copy;2018 mynetwork
                          All rights reserved
                        </p>
                      </div>
                  </div><br><br>
                  <!-- copyright ends -->
                </div>
              </div>
            </div>
          </div>
          <!-- main body area ends here -->
        </div>
      </div>
    <div class="col-md-1">
    </div>
    <div class="col-md-2">
      <!-- side bar for active friends starts here -->
      <div class="sideActiveUser" style="position: fixed;width: 16%;">
        <div class="upperHeading">
          <h4>CONTACTS</h4>
        </div>
        <div class="onlineArea">
          <?php
            getActiveUser();
          ?> 
        </div>
      </div>
      <!-- side bar for active friends ends here -->
    </div>
  </div>
<!-- main body area ends here -->



<!--if not login then-->
<?php } else { ?>

<?php
  echo "<script>window.open('../index.php','_self')</script>";
?>

<?php } ?>
<!--end of not login-->

    <noscript>
      <p>Please enable javascript on the browser!</p>
    </noscript>


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
