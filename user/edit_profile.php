<?php
  session_start();
?>
<?php
  include("dbconnect.php");
  include("function.php");
?>
<?php
  $user = $_SESSION['usr_id'];
  $get_user_personal_info = "SELECT * FROM personal_details where u_id='$user'";
  $run_user_personal_info = mysqli_query($con,$get_user_personal_info);
  $row_user_personal_info = mysqli_fetch_array($run_user_personal_info);

  $name = $row_user_personal_info['name'];
  $email = $row_user_personal_info['email'];
  $c_city = $row_user_personal_info['c_city'];
  $p_city = $row_user_personal_info['p_city'];
  $school = $row_user_personal_info['school'];
  $college = $row_user_personal_info['college'];
  $company = $row_user_personal_info['company'];
  $about_me = $row_user_personal_info['about_me'];
  $intersted = $row_user_personal_info['intersted'];
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
	if (isset($_POST['updateDetails'])) {

	  $name = mysqli_real_escape_string($con,$_POST['name']);
	  $email = mysqli_real_escape_string($con,$_POST['email']);
	  $c_city = mysqli_real_escape_string($con,$_POST['c_city']);
	  $p_city = mysqli_real_escape_string($con,$_POST['p_city']);
	  $school = mysqli_real_escape_string($con,$_POST['school']);
	  $college = mysqli_real_escape_string($con,$_POST['college']);
	  $company = mysqli_real_escape_string($con,$_POST['company']);
	  $about_me = mysqli_real_escape_string($con,$_POST['aboutyou']);
	  $intersted = mysqli_real_escape_string($con,$_POST['intersted']);	

	  $updateData = "UPDATE personal_details SET name='$name',email='$email',c_city='$c_city',p_city='$p_city',school='$school',college='$college',company='$company',about_me='$about_me',intersted='$intersted' WHERE u_id=$user";
	  $runUpdate = mysqli_query($con,$updateData);
	  if ($runUpdate) {
	  	$successmsg = "Successfully updated!";
	  } else{
	  	$errormsg = "Error in updating...Please try again later!";
	  }
	}
?>

<?php
	if (isset($_POST['uploadProfile'])) {
		// echo "<script>alert('jdajsjg')</script>";
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

			$check = date("d-m-Y")."-".time();
		 	if($imagename == $check){
		      $imagename = "";
		    }
		    $cat = 1;
		move_uploaded_file($temp_name, $target_path);

 		$update_p = "UPDATE personal_details set profile_pic='$imagename' where u_id='$user'";
 		$run_p = mysqli_query($con,$update_p);
 		if ($run_p) {
 			$insertIntoProfile = "INSERT INTO profile_image(u_id,name,category) VALUES('$user','$imagename','$cat')";
 			$run_insertIntoProfile = mysqli_query($con,$insertIntoProfile);
 			if ($run_insertIntoProfile) {
 				$insertIntoPost = "INSERT INTO posts(u_id,image,profile_img) VALUES('$user','$imagename','$cat')";
 				$run_insertIntoPost = mysqli_query($con,$insertIntoPost);
 				if ($run_insertIntoPost) {
 					$successmsg = "Successfully updated the profile image! Refresh the page to see this";
 				} else{
 					$errormsg = "Error in uploading...Please try again later!";
 				}
	  		}else{
			  	$errormsg = "Error in updating...Please try again later!";
 			}
 		}
	}
?>

<?php
	if (isset($_POST['uploadCover'])) {
		// echo "<script>alert('jdajsjg')</script>";
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
		$target_path = "cover_img/".$imagename;

			$check = date("d-m-Y")."-".time();
		 	if($imagename == $check){
		      $imagename = "";
		    }
		    $cat = 2;
		move_uploaded_file($temp_name, $target_path);

 		$update_p = "UPDATE personal_details set cover_pic='$imagename' where u_id='$user'";
 		$run_p = mysqli_query($con,$update_p);
 		if ($run_p) {
 			$insertIntoProfile = "INSERT INTO profile_image(u_id,name,category) VALUES('$user','$imagename','$cat')";
 			$run_insertIntoProfile = mysqli_query($con,$insertIntoProfile);
 			if ($run_insertIntoProfile) {
 				$insertIntoPost = "INSERT INTO posts(u_id,image,profile_img) VALUES('$user','$imagename','$cat')";
 				$run_insertIntoPost = mysqli_query($con,$insertIntoPost);
 				if ($run_insertIntoPost) {
 					$successmsg = "Successfully updated the profile image! Refresh the page to see this";
 				} else{
 					$errormsg = "Error in uploading...Please try again later!";
 				}
	  		}else{
			  	$errormsg = "Error in updating...Please try again later!";
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

    if (isset($_POST['search'])){
      $searchData = mysqli_real_escape_string($con, $_POST['search_value']);
      header("location:searchData.php?searchData=$searchData");
    }

?>

<?php

    include("dbconnect.php");
    $user = $_SESSION['usr_id'];

    if (isset($_POST['create'])){
      header("location:searchData.php?searchData=$searchData");
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
    if (isset($_POST['join_group'])) {
      $group_id = mysqli_real_escape_string($con,$_POST['group_id']);
      if(mysqli_query($con, "INSERT INTO groupmember(groupid,u_id) VALUES('" . $group_id . "','" . $user . "')")){
          header("location:home.php?msg='Sucessfuly added to the group'");
      } else {
        echo "<script>alert('Problem in Creating...Try Again latter...')</script>";
      }
        echo "<script>alert('hello')</script>";
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

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <!-- My css -->
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
    <link rel="stylesheet" type="text/css" href="css/main_body.css">
    <link rel="stylesheet" type="text/css" href="css/edit_profile.css">
    <style type="text/css">
      .row{
        width: 100%;
      }
    </style>

  </head>
<body>

<?php if (isset($_SESSION['usr_id'])) {?>

<!-- navbar starts here -->
<div class="upper_nav" style="margin-bottom: 50px;">
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
                          
                          <div class='postGroup'>
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
    <div class="row" style="margin: 0;">
      <div class="col-md-12" style="padding: 0px;">
        <!-- edit profile start here -->
        <div class="editProfile">
        	<div class="jumbotron main_cont" style="background-image: url(&quot;../images/main-bg.jpg&quot;);height: 575px;margin-bottom: 0px;">
      <div class="in_main_cont">
        <div class="wrapper" style="margin-left: 2%;margin-right: .1%;">
          <div class="row">
            <div class="col-sm-12 col-md-12">
              <!-- start of login register area -->
              <div>
                <div class="card card-default card-nav-tabs" style="background: rgba(0,0,0,0.8);">
                  <div class=" card-header-primary">
                    <div class="nav-tabs-navigation">
                      <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs" style="border: 0px;">
                          <li class="nav-item col-md-12" style="padding: 0px;">
                            <a class="nav-link active show nav_log_reg" href="#register" data-toggle="tab" style="border-radius: 0px;"><i class="material-icons"></i>
                              <p style="margin-bottom: 0px;">Update your profile</p>
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
                  <div class="card-body">
                    <div class="tab-content text-center">
                      <div class="tab-pane active show" id="register">
                        <!--  -->
                        <div class="container-fluid" style="padding: 0px;">
                          <div class="div-pad" style="margin-left: 0px;">
    						<!-- main content start here -->
    						<div class="profileArea">
    							<div class="row" style="margin: 0px;">
    								<div class="col-md-2" style="padding: 0px;">
    									<div class="profileImageArea">
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
    										<img src="profile_img/<?php echo $profile_pic ?>" id="output_image" class="img-circle img-thumbnail">
    										<form method="POST" action="" enctype="multipart/form-data">
    											<div style="margin: 10px auto;">
    												<input type="file" onchange="preview_image(event)" name="uploadedimage">
    											</div>
    											<input type="submit" name="uploadProfile" class="btn logbutton2" value="upload new profile" style="padding-top: 4px;">
    										</form><br><br>
    										<form method="POST" action="" enctype="multipart/form-data">
    											<div style="margin: 10px auto;">
    												<label for="exampleInputCoverImage" style="padding-left: 0px;">Cover image : </label>
    												<input type="file" name="uploadedimage">
    											</div>
    											<input type="submit" name="uploadCover" class="btn logbutton2" value="upload new cover" style="padding-top: 4px;">
    										</form>
    									</div>
    								</div>
    								<div class="col-md-10">
    						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputName">Full Name</label>
                                    <input type="text" class="form-control" aria-describedby="nameHelp" value="<?php echo $name; ?>" name="name" placeholder="Enter Name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">E-mail id</label>
                                    <input type="email" class="form-control" aria-describedby="emailHelp" value="<?php echo $email; ?>" name="email" placeholder="Enter email">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCity">Add Current City</label>
                                    <input type="text" class="form-control" aria-describedby="cityHelp" value="<?php echo $c_city; ?>" name="c_city" placeholder="Enter Current City">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputAbouYou">About yourself</label>
                                    <textarea class="form-control" aria-describedby="aboutHelp" name="aboutyou" rows="5" placeholder="Write about yourself..."><?php echo $about_me; ?></textarea>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="exampleInputCity">Add Pernament City</label>
                                    <input type="text" class="form-control" aria-describedby="cityHelp" value="<?php echo $p_city; ?>" name="p_city" placeholder="Enter Pernament City">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputSchool">Add School</label>
                                    <input type="text" value="<?php echo $school; ?>" class="form-control" aria-describedby="schoolHelp" name="school" placeholder="Enter School">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCollege">Add College</label>
                                    <input type="text" value="<?php echo $college; ?>" class="form-control" aria-describedby="collegeHelp" name="college" placeholder="Enter College">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCompany">Add Company</label>
                                    <input type="text" class="form-control" aria-describedby="companyHelp" value="<?php echo $company; ?>" name="company" placeholder="Enter Company">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputCompany">Your intersest</label>
                                    <select class="form-control" required aria-describedby="companyHelp" name="intersted">
                                    	<option>Intersted In</option>
                                    	<option value="male">Male</option>
                                    	<option value="female">Female</option>
                                    	<option value="both">Both</option>
                                    </select>
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
                                  <button type="submit" name="updateDetails" class="btn btn-primary logbutton2">Save & Continue</button>
                                </div>
                              </div>
                            </form>
    								</div>
    							</div> <!-- end of row -->
    						</div>
    						<!-- main content ends here -->
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
        </div>
        <!-- edit profile ends here -->
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
