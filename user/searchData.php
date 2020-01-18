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

    <!-- My css -->
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
    <link rel="stylesheet" type="text/css" href="css/main_body.css">
    <link rel="stylesheet" type="text/css" href="css/searchStyle.css">

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

<!-- division and main body area start -->
<div class="body_area">
  <div class="wrapper">
    <div class="row">
      <!-- main body start here -->
      <div class="col-sm-9 col-md-9" style="padding: 0px;">
        <div class="main_body_content"  style="margin-left: 5.3%;">
        		<nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-user"></i>&nbsp;People</a>
						<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false" style="margin-right: 0;"><i class="fas fa-users"></i>&nbsp;Group</a>
					</div>
				</nav>
				<div class="tab-content px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						<div class="mainSearchSec">
				<div class="row" style="margin-left: -8px;">
			<?php
			include("dbconnect.php");
			$user = $_SESSION['usr_id'];
      $sendRequest = false;
			  
			  if ($_GET['searchData']) {
			    $searchData = $_GET['searchData'];

			      $get = "SELECT * FROM personal_details WHERE name like '%$searchData%'";
			      $run_get = mysqli_query($con,$get);
			      while($row_get_user_send_friend_info = mysqli_fetch_array($run_get)){
			        // checking
			          $u_id = $row_get_user_send_friend_info['u_id'];
			          $name = $row_get_user_send_friend_info['name'];
			          $c_city = $row_get_user_send_friend_info['c_city'];
			          $p_city = $row_get_user_send_friend_info['p_city'];
			          $school = $row_get_user_send_friend_info['school'];
			          $college = $row_get_user_send_friend_info['college'];
			          $profile_pic = $row_get_user_send_friend_info['profile_pic'];
			          if ($college == "") {
			          	$college=$school;
			          }
			          $buttonData = "";
			          $getFriendData = "SELECT * FROM friends WHERE rec_id=$user AND friend_id=$u_id";
  				      $run_getFriendData = mysqli_query($con,$getFriendData);
  				      $row_run_getFriendData = mysqli_fetch_array($run_getFriendData);

  				      if($row_run_getFriendData >=1){
  				      	$buttonData = "Friends";
  				      }
  				      else{
  				      	$buttonData = "Add Friend";
                  $sendRequest = true;
  				      }

  				      if ($u_id == $user) {
  				      	$buttonData = "My Profile";
  				      }

			          echo "
			          	<div class='col-md-6' style='padding-right: 0;'>
							<!-- profile start here -->
							<div class='insideSecarchResult'>
								<div class='row'>   
									<div class='col-md-3 profileSection'>
										<img src='profile_img/$profile_pic'>
									</div>
									<div class='col-md-9 personalDetails'>
										<div class='row'>
											<div class='col-md-9'>
												<h3><a href='view_profile.php?u_id=$u_id'>$name</a></h3>
												<h5>$c_city</h5>
												<h6>$college</h6>
												<h6>Lives in <span>$c_city</span></h6>
												<h6>From <span>$p_city</span></h6>
											</div>
											<div class='col-md-3'>
												<div class='addFriend'>
                ";
                        // friend_request.php?reciver_id= echo $u_id&sender_id= echo $user";
                          if($sendRequest){
                            echo "
  													 <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'><button class='btn'>&nbsp;$buttonData&nbsp;</button></a>
                            ";
                          } else{
                            echo "
                              <a href=''><button class='btn'>&nbsp;$buttonData&nbsp;</button></a>
                              ";
                          }
                echo "
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- profile ends here -->
						</div>
			          ";
			      }

			  }
			?>
			
					
					<!-- end of col-md-6 -->
				</div>
			</div>
					</div>
					<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="min-height: 50px;">
            <?php
              echo "<div class='row' style='background:#fff;padding:10px;margin:0px;'>";
            ?>
				<?php
				if ($_GET['searchData']) {
					$buttonData2 = "";
				    $searchData = $_GET['searchData'];

				      $getGroup = "SELECT * FROM groupdes WHERE groupname like '%$searchData%'";
				      $run_getGroup = mysqli_query($con,$getGroup);
				      while($row_getGroup = mysqli_fetch_array($run_getGroup)){
					        $groupid = $row_getGroup['groupId'];
				          $groupname = $row_getGroup['groupname'];
				          $groupdes = $row_getGroup['groupdes'];
				          $groupimg = $row_getGroup['groupimg'];
				          $groupcover = $row_getGroup['groupcover'];


				          $getGroupMem = "SELECT * FROM groupmember WHERE groupid=$groupid AND u_id=$user";
					      $run_getGroupMem = mysqli_query($con,$getGroupMem);
					      $row_getGroupMem = mysqli_fetch_array($run_getGroupMem);

					      if($row_getGroupMem >=1){
					      	$buttonData2 = "Already Join";
					      }
					      else{
					      	$buttonData2 = "Add Group";
					      }


				          echo "
				          
				          	<div class='col-md-6' style='padding-right: 0;'>
								<!-- profile start here -->
								<div class='insideSecarchResult'>
									<div class='row'>   
										<div class='col-md-3 profileSection'>
											<img src='group_profile_img/$groupimg'>
										</div>
										<div class='col-md-9 personalDetails'>
											<div class='row'>
												<div class='col-md-9'>
													<h3><a href='viewGroup.php?group_id=$groupid'>$groupname</a></h3>
													<h5>$groupdes</h5>
												</div>
												<div class='col-md-3'>
													<div class='addFriend'>
														<button class='btn'>&nbsp;$buttonData2&nbsp;</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- profile ends here -->
							</div>
						
				          ";

				      }
			  	}
          echo "</div>";
				?>
					</div>
				</div>
        </div>
      </div>
      <!-- main body ends here -->
      <div class="col-sm-3 col-md-3" style="padding-right: 0px;">
        <!-- suggested pages start here -->
        <div class='suggested_pages'>
          <div class='content'>
            <div class='row' style='margin: 0;'>
              <div class='col-md-6 heading' style='padding-left: 3px;'>
                <h4>Suggested Groups</h4>
              </div>
              <div class='col-md-2'></div>
              <div class='col-md-4 viewall' style='padding-right: 5px;'>
                <h4><a href='#'>View all</a></h4>
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

        <!-- birthday start here -->
        <?php getBirthday(); ?>
        <!-- birthday ends here -->


        <!-- online section start here -->
       <!-- online section start here -->
        <section class="main_bottom_chat_section">
          <div>
            <button href="#collapse1" class="nav-toggle btn logbutton3">Friends and Peoples</button>
          </div>
          <div id="collapse1" style="display:none;">
          

          <!-- global chat -->
          
            <div id=''>
              <div class='chat_body'> 
                <div class='user' style="font-size: 13px;">For global chat click here</div>
              </div>
            </div><hr style="margin-top: 0px;border-bottom: 1px solid #7f8c8d;">


            <div class='msg_box' style='right:290px;display:none;'>
              <div class='msg_head'>Global Chat
                <div class='close'>x</div>
                </div>
                <div class='msg_wrap'>
                  <div class='msg_body' id='mainChat'>
                    
                    <div class='msg_push'></div>
                  </div>
                <div class='msg_footer'>
                  <form id='sendMsgFrm' method='POST' action=''>
                    <textarea class='msg_input' name='message' rows='2'></textarea>
                  </form>
                </div>
              </div>
            </div>


            <div class="peopleOnline">
              <h3>Friends and Peoples</h3>
            </div>
            <?php
              getActiveUserHomepage();
            ?>
          </div>
        </section>
        <!-- online section ends here -->
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>
</div>
<!-- division and main body area end -->


<!--if not login then-->
<?php } else { ?>

<?php
  echo "<script>window.open('../index.php','_self')</script>";
  header("location:../index.php");
?>

<?php } ?>
<!--end of not login-->

    <noscript>
      <p>Please enable javascript on the browser!</p>
    </noscript>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/main_body.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- filepond libery js -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
      FilePond.parse(document.body);
    </script>

    <script src="js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="js/navbar.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <!-- refresh a div  -->
    <script type="text/javascript">
     
    </script>
    

</body>
</html>
