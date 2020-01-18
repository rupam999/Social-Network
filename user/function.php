<?php
include("dbconnect.php");
global $con;


// for limited email
function email($email)
{
  $length = 25;
  if(strlen($email)<=$length)
  {
    echo $email;
  }
  else
  {
    $cut_email=substr($email,0,$length) . '...';
    echo $cut_email;
  }
}

// for limited name
function name($name)
{
  $length = 17;
  if(strlen($name)<=$length)
  {
    echo $name;
  }
  else
  {
    $cut_name=substr($name,0,$length) . '...';
    echo $cut_name;
  }
}

// for limited user id
function user_id($email)
{
  $length = 19;
  if(strlen($email)<=$length)
  {
    echo "@".$email;
  }
  else
  {
    $cut_user_id=substr($email,0,$length) . '...';
    echo "@".$cut_user_id;
  }
}

// home page suggested friends_list
function random_two_friends(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $countFriend = 0;
  $maxFiends = 0;
  $ultimateChecking = 0;

// if ($maxFiends < 2) {

  // user information
  // CALL home($user);
  $get_user_personal_info = "SELECT * FROM personal_details where u_id!='$user' ORDER BY RAND()";
  $run_user_personal_info = mysqli_query($con,$get_user_personal_info);
  while($row_user_personal_info = mysqli_fetch_array($run_user_personal_info)){

    $isNotPresent = true;

    $ultimateChecking = $row_user_personal_info['u_id'];

    $u_id = $row_user_personal_info['u_id'];
    $name = $row_user_personal_info['name'];
    $email = $row_user_personal_info['email'];
    $profile_pic = $row_user_personal_info['profile_pic'];
    $cover_pic = $row_user_personal_info['cover_pic'];


    // check already present in the friend list or not
    $get_user_send_friendreq_info = "SELECT * FROM friend_request";
    $run_get_user_send_friendreq_info = mysqli_query($con,$get_user_send_friendreq_info);
    while($row_get_user_send_friendreq_info = mysqli_fetch_array($run_get_user_send_friendreq_info)){
      // checking
      $friendreq_list = $row_get_user_send_friendreq_info['sender_id'];
      $receiver_id = $row_get_user_send_friendreq_info['receiver_id'];

      $isNotPresent = true;
      if ($friendreq_list == $u_id) {
        $isNotPresent = false;
      }
      else{
        $isNotPresent = true;
      }
      if ($receiver_id == $u_id) {
        $isNotPresent = false;
      }


      // check already present in the friend list or not
      $get_user_send_friend_info = "SELECT * FROM friends WHERE rec_id='$user'";
      $run_get_user_send_friend_info = mysqli_query($con,$get_user_send_friend_info);
      while($row_get_user_send_friend_info = mysqli_fetch_array($run_get_user_send_friend_info)){
        // checking
        $friend_list = $row_get_user_send_friend_info['friend_id'];

        if ($friend_list === $u_id) {
          $isNotPresent = false;
        }
        else{
          $isNotPresent = true;
        }


        // for user id of friends
        $length = 19;
        if(strlen($email)<=$length)
        {
          $user_id = $email;
        }
        else
        {
          $cut_user_id=substr($email,0,$length) . '...';
          $user_id = $cut_user_id;
        }

        // for name of friends
        $length = 17;
        if(strlen($name)<=$length)
        {
          $name = $name;
        }
        else
        {
          $cut_name=substr($name,0,$length) . '...';
          $name = $cut_name;
        }

        if($isNotPresent){
          $countFriend = getFriendsNumberAndDetailsFriend($u_id);
          $countPosts = getNoOPostPosts_1($u_id);
          $countPhotos = getNoOPostPhotos_1($u_id);
          echo "
      <div class='friends_list'>
        <div class='row'>
          <div class='col-md-3'>
            <img src='profile_img/$profile_pic' style='width: 50px;height: 48px;border-radius: 50%;'>
          </div>
          <div class='col-md-9 details_friend'>
            <div class='dropdown dropup'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><h3>$name</h3> </a>
              <ul class='dropdown-menu' role='menu' style='padding: 0;margin: 0;'>
                <div class='friend_profile'>
                  <div class='small_profile'>
                    <div class='upper_small_profile'>
                      <!-- cover photo area -->
                      <img src='cover_img/$cover_pic' height='95px' width='100%' class='friend_list_cover'>
                    </div>
                    <div class='body_small_profile'>
                      <div class='row'>
                        <div class='col-md-4' style='height: 65px;'>
                          <img src='profile_img/$profile_pic' style='width: 75px;height: 75px;'>
                        </div>
                        <div class='col-md-8 user_area'>
                          <h4>$name</h4>
                          <p>@$user_id</p>
                        </div>
                      </div>  <!--end of row -->
                      <div class='friends_list'>
                        <div class='row'>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Posts
                            </a></p>
                            <p class='value'>$countPosts</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Friends
                            </a></p>
                            <p class='value'>$countFriend</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Photos
                            </a></p>
                            <p class='value'>$countPhotos</p>
                          </div>
                        </div>  <!--end of row -->
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
            <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
            <button name='send_request' class='btn logbutton2'><i class='fas fa-user-plus'></i>&nbsp;Add Friend</button>&nbsp;<a href='view_profile.php?u_id=$u_id'><input type='button' value='View' class='btn logbutton2'></a>
          </div>
        </div>
        <hr>
      </div>
          ";
          goto out;
          // $maxFiends++;
        }
      }


    }


      // for user id of friends
        $length = 19;
        if(strlen($email)<=$length)
        {
          $user_id = $email;
        }
        else
        {
          $cut_user_id=substr($email,0,$length) . '...';
          $user_id = $cut_user_id;
        }

        // for name of friends
        $length = 17;
        if(strlen($name)<=$length)
        {
          $name = $name;
        }
        else
        {
          $cut_name=substr($name,0,$length) . '...';
          $name = $cut_name;
        }

      // startting personal_details
      if($isNotPresent){

        $countFriend = getFriendsNumberAndDetailsFriend($u_id);
        $countPosts = getNoOPostPosts_1($u_id);
        $countPhotos = getNoOPostPhotos_1($u_id);
          echo "
      <div class='friends_list'>
        <div class='row'>
          <div class='col-md-3'>
            <img src='profile_img/$profile_pic' style='width: 50px;height: 48px;border-radius: 50%;'>
          </div>
          <div class='col-md-9 details_friend'>
            <div class='dropdown dropup'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><h3>$name</h3> </a>
              <ul class='dropdown-menu' role='menu' style='padding: 0;margin: 0;'>
                <div class='friend_profile'>
                  <div class='small_profile'>
                    <div class='upper_small_profile'>
                      <!-- cover photo area -->
                      <img src='cover_img/$cover_pic' height='95px' width='100%' class='friend_list_cover'>
                    </div>
                    <div class='body_small_profile'>
                      <div class='row'>
                        <div class='col-md-4' style='height: 65px;'>
                          <img src='profile_img/$profile_pic' style='width: 75px;height: 75px;'>
                        </div>
                        <div class='col-md-8 user_area'>
                          <h4>$name</h4>
                          <p>@$user_id</p>
                        </div>
                      </div>  <!--end of row -->
                      <div class='friends_list'>
                        <div class='row'>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Posts
                            </a></p>
                            <p class='value'>$countPosts</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Friends
                            </a></p>
                            <p class='value'>
                              $countFriend
                            </p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Photos
                            </a></p>
                            <p class='value'>$countPhotos</p>
                          </div>
                        </div>  <!--end of row -->
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
            <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
            <button name='send_request' class='btn logbutton2'><i class='fas fa-user-plus'></i>&nbsp;Add Friend</button>&nbsp;<a href='view_profile.php?u_id=$u_id'><input type='button' value='View' class='btn logbutton2'></a>
          </div>
        </div>
        <hr>
      </div>
          ";
          goto out;
          // $maxFiends++;
        }
  }
  out:

  $get_user_personal_info = "SELECT * FROM personal_details where u_id!='$user' ORDER BY RAND()";
  $run_user_personal_info = mysqli_query($con,$get_user_personal_info);
  while($row_user_personal_info = mysqli_fetch_array($run_user_personal_info)){

    $isNotPresent = true;

    // $ultimateChecking = $row_user_personal_info['u_id'];

    $u_id = $row_user_personal_info['u_id'];
    $name = $row_user_personal_info['name'];
    $email = $row_user_personal_info['email'];
    $profile_pic = $row_user_personal_info['profile_pic'];
    $cover_pic = $row_user_personal_info['cover_pic'];

if($ultimateChecking != $u_id){


    // check already present in the friend list or not
    $get_user_send_friendreq_info = "SELECT * FROM friend_request";
    $run_get_user_send_friendreq_info = mysqli_query($con,$get_user_send_friendreq_info);
    while($row_get_user_send_friendreq_info = mysqli_fetch_array($run_get_user_send_friendreq_info)){
      // checking
      $friendreq_list = $row_get_user_send_friendreq_info['sender_id'];
      $receiver_id = $row_get_user_send_friendreq_info['receiver_id'];

      $isNotPresent = true;
      if ($friendreq_list == $u_id) {
        $isNotPresent = false;
      }
      else{
        $isNotPresent = true;
      }
      if ($receiver_id == $u_id) {
        $isNotPresent = false;
      }


      // check already present in the friend list or not
      $get_user_send_friend_info = "SELECT * FROM friends WHERE rec_id='$user'";
      $run_get_user_send_friend_info = mysqli_query($con,$get_user_send_friend_info);
      while($row_get_user_send_friend_info = mysqli_fetch_array($run_get_user_send_friend_info)){
        // checking
        $friend_list = $row_get_user_send_friend_info['friend_id'];

        if ($friend_list === $u_id) {
          $isNotPresent = false;
        }
        else{
          $isNotPresent = true;
        }


        // for user id of friends
        $length = 19;
        if(strlen($email)<=$length)
        {
          $user_id = $email;
        }
        else
        {
          $cut_user_id=substr($email,0,$length) . '...';
          $user_id = $cut_user_id;
        }

        // for name of friends
        $length = 17;
        if(strlen($name)<=$length)
        {
          $name = $name;
        }
        else
        {
          $cut_name=substr($name,0,$length) . '...';
          $name = $cut_name;
        }

        if($isNotPresent){
          $countFriend = getFriendsNumberAndDetailsFriend($u_id);
          $countPosts = getNoOPostPosts_1($u_id);
          $countPhotos = getNoOPostPhotos_1($u_id);
          echo "
      <div class='friends_list'>
        <div class='row'>
          <div class='col-md-3'>
            <img src='profile_img/$profile_pic' style='width: 50px;height: 48px;border-radius: 50%;'>
          </div>
          <div class='col-md-9 details_friend'>
            <div class='dropdown dropup'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><h3>$name</h3> </a>
              <ul class='dropdown-menu' role='menu' style='padding: 0;margin: 0;'>
                <div class='friend_profile'>
                  <div class='small_profile'>
                    <div class='upper_small_profile'>
                      <!-- cover photo area -->
                      <img src='cover_img/$cover_pic' height='95px' width='100%' class='friend_list_cover'>
                    </div>
                    <div class='body_small_profile'>
                      <div class='row'>
                        <div class='col-md-4' style='height: 65px;'>
                          <img src='profile_img/$profile_pic' style='width: 75px;height: 75px;'>
                        </div>
                        <div class='col-md-8 user_area'>
                          <h4>$name</h4>
                          <p>@$user_id</p>
                        </div>
                      </div>  <!--end of row -->
                      <div class='friends_list'>
                        <div class='row'>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Posts
                            </a></p>
                            <p class='value'>$countPosts</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Friends
                            </a></p>
                            <p class='value'>$countFriend</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Photos
                            </a></p>
                            <p class='value'>$countPhotos</p>
                          </div>
                        </div>  <!--end of row -->
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
            <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
            <button name='send_request' class='btn logbutton2'><i class='fas fa-user-plus'></i>&nbsp;Add Friend</button>&nbsp;<a href='view_profile.php?u_id=$u_id'><input type='button' value='View' class='btn logbutton2'></a>
          </div>
        </div>
        <hr>
      </div>
          ";
          goto out2;
          // $maxFiends++;
        }
      }


    }


      // for user id of friends
        $length = 19;
        if(strlen($email)<=$length)
        {
          $user_id = $email;
        }
        else
        {
          $cut_user_id=substr($email,0,$length) . '...';
          $user_id = $cut_user_id;
        }

        // for name of friends
        $length = 17;
        if(strlen($name)<=$length)
        {
          $name = $name;
        }
        else
        {
          $cut_name=substr($name,0,$length) . '...';
          $name = $cut_name;
        }

      // startting personal_details
      if($isNotPresent){

          $countFriend = getFriendsNumberAndDetailsFriend($u_id);
          $countPosts = getNoOPostPosts_1($u_id);
          $countPhotos = getNoOPostPhotos_1($u_id);

          echo "
      <div class='friends_list'>
        <div class='row'>
          <div class='col-md-3'>
            <img src='profile_img/$profile_pic' style='width: 50px;height: 48px;border-radius: 50%;'>
          </div>
          <div class='col-md-9 details_friend'>
            <div class='dropdown dropup'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'><h3>$name</h3> </a>
              <ul class='dropdown-menu' role='menu' style='padding: 0;margin: 0;'>
                <div class='friend_profile'>
                  <div class='small_profile'>
                    <div class='upper_small_profile'>
                      <!-- cover photo area -->
                      <img src='cover_img/$cover_pic' height='95px' width='100%' class='friend_list_cover'>
                    </div>
                    <div class='body_small_profile'>
                      <div class='row'>
                        <div class='col-md-4' style='height: 65px;'>
                          <img src='profile_img/$profile_pic' style='width: 75px;height: 75px;'>
                        </div>
                        <div class='col-md-8 user_area'>
                          <h4>$name</h4>
                          <p>@$user_id</p>
                        </div>
                      </div>  <!--end of row -->
                      <div class='friends_list'>
                        <div class='row'>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Posts
                            </a></p>
                            <p class='value'>$countPosts</p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Friends
                            </a></p>
                            <p class='value'>
                              $countFriend
                            </p>
                          </div>
                          <div class='col-md-4'>
                            <p><a href='#'>
                              Photos
                            </a></p>
                            <p class='value'>$countPhotos</p>
                          </div>
                        </div>  <!--end of row -->
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
            <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
            <button name='send_request' class='btn logbutton2'><i class='fas fa-user-plus'></i>&nbsp;Add Friend</button>&nbsp;<a href='view_profile.php?u_id=$u_id'><input type='button' value='View' class='btn logbutton2'></a>
          </div>
        </div>
        <hr>
      </div>
          ";
          goto out2;
          // $maxFiends++;
        }
  }

}
  out2:
  // } 
} //end of function


// profile upper cover and nav
function get_profile_Cover(){
include("dbconnect.php");

  if(isset($_GET['u_id'])){
  $u_id = $_GET['u_id'];

  $get_view_personal_info = "SELECT * FROM personal_details WHERE u_id=$u_id";
  $run_view_personal_info = mysqli_query($con,$get_view_personal_info);
  while($row_view_personal_info = mysqli_fetch_array($run_view_personal_info)){

  $u_id = $row_view_personal_info['u_id'];
  $name = $row_view_personal_info['name'];
  $email = $row_view_personal_info['email'];
  $c_city = $row_view_personal_info['c_city'];
  $p_city = $row_view_personal_info['p_city'];
  $college = $row_view_personal_info['college'];
  $school = $row_view_personal_info['school'];
  $profile_pic = $row_view_personal_info['profile_pic'];
  $cover_pic = $row_view_personal_info['cover_pic'];



  if ($profile_pic == "") {
    $profile_pic = "blank_profile2.png";
  }
  if ($cover_pic == "") {
    $cover_pic = "blank_cover.png";
  }


  // for name of friends
  $length = 17;
  if(strlen($name)<=$length)
  {
    $name = $name;
  }
  else
  {
    $cut_name=substr($name,0,$length) . '...';
    $name = $cut_name;
  }


  echo "

      <div class='cover_image'>
        <img src='cover_img/$cover_pic'>
      </div>
      <div class='nav_area'>
        <div class='row'>
          <div class='col-md-3 view_nav_menu profile_picture'>
            <img src='profile_img/$profile_pic'>
            <div class='view_profile_name'>
              <h4>$name</h4>
            </div>
          </div>
          <div class='col-md-2 view_nav_menu uparrow'>
            <a href='view_profile.php?u_id=$u_id'>
              <h5>Timeline</h5>
              <img src='images/uparrow.png'>
            </a>
          </div>
          <div class='col-md-2 view_nav_menu'>
            <a href='viewUserAbout.php?u_id=$u_id'>
              <h5>About</h5>
            </a>
          </div>
          <div class='col-md-2 view_nav_menu'>
            <a href='viewUserFriends.php?u_id=$u_id'>
              <h5>Friends</h5>
            </a>
          </div>
          <div class='col-md-2 view_nav_menu'>
            <a href='viewUserPhotos.php?u_id=$u_id'>
              <h5>Photos</h5>
            </a>
          </div>
          <div class='col-md-1'></div>
        </div>  <!--end of row-->
      </div>
  ";
  }
}
}

// profile view or view profile
function get_profile_view(){
include("dbconnect.php");

  if(isset($_GET['u_id'])){
  $u_id = $_GET['u_id'];

  $get_view_personal_info = "SELECT * FROM personal_details WHERE u_id=$u_id";
  $run_view_personal_info = mysqli_query($con,$get_view_personal_info);
  while($row_view_personal_info = mysqli_fetch_array($run_view_personal_info)){

  $u_id = $row_view_personal_info['u_id'];
  $name = $row_view_personal_info['name'];
  $email = $row_view_personal_info['email'];
  $c_city = $row_view_personal_info['c_city'];
  $p_city = $row_view_personal_info['p_city'];
  $college = $row_view_personal_info['college'];
  $school = $row_view_personal_info['school'];
  $company = $row_view_personal_info['company'];
  $profile_pic = $row_view_personal_info['profile_pic'];
  $cover_pic = $row_view_personal_info['cover_pic'];



  if ($profile_pic == "") {
    $profile_pic = "blank_profile2.png";
  }
  if ($cover_pic == "") {
    $cover_pic = "blank_cover.png";
  }


  // for name of friends
  $length = 17;
  if(strlen($name)<=$length)
  {
    $name = $name;
  }
  else
  {
    $cut_name=substr($name,0,$length) . '...';
    $name = $cut_name;
  }


  echo "
        <div class='second_sec'>
          <div class='row'>
            <div class='col-md-5'>
              <div class='basic_intro'>
                <div class='intro_heading'>
                  <div class='row'>
                    <div class='col-md-2' style='padding: ;'>
                      <img src='images/intro.png'>
                    </div>
                    <div class='col-md-8' style='padding-left: 0;'>
                      <h4>Intro</h4>
                    </div>
                  </div>  <!--end of row -->
                  <div class='row'>
                    <div class='information'>
                      <h3><i class='fas fa-suitcase'></i>&nbsp;
                        Works at 
                        <span style='color: #365899;text-transform:capitalize;'>
                          $company
                        </span>
                      </h3>
                      <h3><i class='fas fa-graduation-cap'></i>&nbsp;
                        Studied at
                        <span style='color: #365899;'>
                          $college
                        </span>
                      </h3>
                      <h3><i class='fas fa-graduation-cap'></i>&nbsp;
                        Went to <span style='color: #365899;'>$school</span>
                      </h3>
                      <h3><i class='fas fa-home'></i>&nbsp;
                       Lives in <span style='color: #365899;'>$p_city</span>
                      </h3>
                      <h3><i class='fas fa-map-marker-alt'></i>&nbsp;
                        From <span style='color: #365899;'>$c_city</span>
                      </h3>
                    </div>
                  </div>
                </div>
              </div>
          
  ";
  }
}
}

// photos of profile view
function getViewProfilePhotos(){
  include("dbconnect.php");

    echo "
      <!-- photos start -->
              <div class='photos_area'>
                <!-- photos end -->
                <div class='row'>
                  <div class='col-md-2' style='padding: ;'>
                    <img src='images/photos.png'>
                  </div>
                  <div class='col-md-8 upper_heading' style='padding-left: 0;'>
                    <h4>Photos</h4>
                  </div>
                  <div class='col-md-2'></div>
                </div>  <!-- end of row -->
                <div class='row'>
    ";
  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];
  }
  $get_view_photos = "SELECT * FROM posts WHERE u_id=$u_id AND profile_img=0 AND onlyText=0 ORDER BY post_id DESC LIMIT 0,9";
  $run_view_photos = mysqli_query($con,$get_view_photos);
  while($row_view_photos = mysqli_fetch_array($run_view_photos)){
    $image = $row_view_photos['image'];

        echo "
          <div class='col-md-4 userPostImage' style='padding:0;'>
            <img src='post_img/$image'>
          </div>
        ";
  }
  echo "
      </div>
    </div>
  ";
}

// friends of profile view
function getViewProfileFriends(){
include("dbconnect.php");

if(isset($_GET['u_id'])){
  $u_id = $_GET['u_id'];


  $countFriend = getFriendsNumberAndDetailsFriend($u_id);
    echo "
      <!-- friends start -->
        <div class='friends_area'>
          <!-- friends end -->
            <div class='row'>
              <div class='col-md-2' style='padding: ;'>
                <img src='images/small_friends.png'>
              </div>
              <div class='col-md-8 upper_heading' style='padding-left: 0;'>
                <h4><a href='#'>Friends </a>. $countFriend</h4>
              </div>
              <div class='col-md-2'></div>
              </div>  <!-- end of row -->
              <div class='sriend_listArea'>
              <div class='row' style='margin-left:0px;'>
      ";


  $get_view_friend_list = "SELECT * FROM friends WHERE rec_id=$u_id";
  $run_view_friend_list = mysqli_query($con,$get_view_friend_list);
  while($row_view_friend_list = mysqli_fetch_array($run_view_friend_list)){
    $friend_id = $row_view_friend_list['friend_id'];


    $get_view_friends_info = "SELECT * FROM personal_details WHERE u_id=$friend_id ORDER BY RAND() LIMIT 0,9";
    $run_view_friends_info = mysqli_query($con,$get_view_friends_info);
    while($row_view_friends_info = mysqli_fetch_array($run_view_friends_info)){

      $u_id = $row_view_friends_info['u_id'];
      $name = $row_view_friends_info['name'];
      $email = $row_view_friends_info['email'];
      $c_city = $row_view_friends_info['c_city'];
      $p_city = $row_view_friends_info['p_city'];
      $college = $row_view_friends_info['college'];
      $school = $row_view_friends_info['school'];
      $profile_pic = $row_view_friends_info['profile_pic'];
      $cover_pic = $row_view_friends_info['cover_pic'];



      if ($profile_pic == "") {
        $profile_pic = "blank_profile2.png";
      }
      if ($cover_pic == "") {
        $cover_pic = "blank_cover.png";
      }


      // for name of friends
      $length = 17;
      if(strlen($name)<=$length)
      {
        $name = $name;
      }
      else
      {
        $cut_name=substr($name,0,$length) . '...';
        $name = $cut_name;
      }


          echo"
              
                <div class='col-md-4' style='padding-left:0;'>
                  <div class='friend_profile'>
                    <a href='view_profile.php?u_id=$u_id'>
                      <img src='profile_img/$profile_pic'>
                    </a>
                  </div>
                  <div class='friendsNameHeading'>
                    <h4><a href='view_profile.php?u_id=$u_id'>$name</a></h4>
                  </div>
                </div>
          ";
    } 
  }
}
echo "
  </div>
  </div>
</div>
";
}


// profile view for who is not a friend
function profileViewForNotAFriend(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $code="";

  if(isset($_GET['u_id'])){
  $u_id = $_GET['u_id'];

    if ($u_id == $user) {
      profileViewAFriend();
      goto nextProfile;
    }

    $get_normal_view_friend_post = "SELECT * FROM profile_image WHERE u_id=$u_id";
    $run_normal_view_friend_post = mysqli_query($con,$get_normal_view_friend_post);
    while($row_normal_view_friend_post = mysqli_fetch_array($run_normal_view_friend_post)){
      $image_id = $row_normal_view_friend_post['image_id'];
      $image_name = $row_normal_view_friend_post['name'];
      $category = $row_normal_view_friend_post['category'];
      $date = $row_normal_view_friend_post['p_date'];


      $sqlData = "SELECT name FROM personal_details WHERE u_id=$u_id";
      $run_sqlData = mysqli_query($con,$sqlData);
      $row_sqlData = mysqli_fetch_array($run_sqlData);
      $name = $row_sqlData['name'];


      $time=strtotime($date);
      $year=date("Y",$time);

      $day=0;
      $month=0;

      $day = date("d",$time);
      $month = date("m",$time);

      $get_month = "SELECT * FROM month WHERE value=$month";
      $run_get_month = mysqli_query($con,$get_month);
      $row_get_month = mysqli_fetch_array($run_get_month);

      $monthWord = $row_get_month['name'];

       // genderss details
      $getGender = "SELECT gender FROM login WHERE id='$u_id'";
      $run_getGender = mysqli_query($con,$getGender);
      $row_getGender = mysqli_fetch_array($run_getGender);

      $gender = $row_getGender['gender'];
      if ($gender == "male") {
        $code = "his";
      } else{
        $code = "her";
      }

      if ($category == 1) {
        echo "
          <!--  -->
            <div class='noFriends_profile'>
                <div class='user_info_sec'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$image_name'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='#'>$name</a>
                        <span>updated <span>$code</span> profile picture</span>
                      </h4>
                      <h6>$day&nbsp;<span style='text-transform:uppercase;'>$monthWord</span>&nbsp;$year</h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <div class='cover_area'>
                    <img src='cover_img/$image_name'>
                  </div>
                  <div class='profile_area'>
                    <img src='profile_img/$image_name'>
                  </div>
                </div>
            </div>
            <span>&nbsp;</span>
        ";
      }

      if ($category == 2) {
        echo "
          <div class='noFriends_profile_cover'>
              <div class='user_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$image_name'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='#'>$name</a>
                        <span>updated <span>$code</span> cover picture</span>
                      </h4>
                      <h6>$day&nbsp;<span style='text-transform:uppercase;'>$monthWord</span>&nbsp;$year</h6>
                    </div>
                  </div>
              </div>
              <div class'only_cover_sec'>
                <img src='cover_img/$image_name' width='518px'>
              </div>
            </div>
            <span>&nbsp;</span>
        ";
      }

    }
  }
  nextProfile:
}


// profile view a friend
function profileViewAFriend(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];
$code="";

  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];


    $sqlForName = "SELECT name,profile_pic FROM personal_details WHERE u_id=$u_id";
    $runSql = mysqli_query($con,$sqlForName);
    $dataFriend = mysqli_fetch_array($runSql);
    $name = $dataFriend['name'];
    $profile_pic = $dataFriend['profile_pic'];

    $get_normal_view_friend_post = "SELECT * FROM posts WHERE u_id=$u_id ORDER BY post_id DESC";
    $run_normal_view_friend_post = mysqli_query($con,$get_normal_view_friend_post);
    while($row_normal_view_friend_post = mysqli_fetch_array($run_normal_view_friend_post)){
      $img_text = $row_normal_view_friend_post['img_text'];
      $image = $row_normal_view_friend_post['image'];
      $profile_img = $row_normal_view_friend_post['profile_img'];
      $onlyText = $row_normal_view_friend_post['onlyText'];
      // $date = $row_normal_view_friend_post['p_date'];

      // genderss details
      $getGender = "SELECT gender FROM login WHERE id='$u_id'";
      $run_getGender = mysqli_query($con,$getGender);
      $row_getGender = mysqli_fetch_array($run_getGender);

      $gender = $row_getGender['gender'];
      if ($gender == "male") {
        $code = "his";
      } else{
        $code = "her";
      }

      if ($profile_img == 1) {
        echo "
          <!--  -->
            <div class='noFriends_profile'>
                <div class='user_info_sec'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='#'>$name</a>
                        <span>updated <span>$code</span> profile picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <div class='cover_area'>
                    <img src='cover_img/$image'>
                  </div>
                  <div class='profile_area'>
                    <img src='profile_img/$image'>
                  </div>
                </div>
            </div>
            <span>&nbsp;</span>
        ";
      }

      if ($profile_img == 2) {
        echo "
          <div class='noFriends_profile_cover'  style='margin-top:13px;'>
              <div class='user_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='#'>$name</a>
                        <span>updated <span>$code</span> cover picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'only_cover_sec'>
                <img src='cover_img/$image' width='518px'>
              </div>
            </div>
            <span>&nbsp;</span>
        ";
      }

      if (($onlyText == 1) && ($profile_img == 0)){
        echo "
            <div class='newsFeed_onlyText'>
              <div class='onlyTextUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>post a new status</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'onlyTextSection'>
                <h3>$img_text</h3>
              </div>
            </div>
        ";
      }


      // normal photo post
      if (($onlyText == 0) && ($profile_img == 0)) {
        echo "
          <div class='allUserPost' style='width:100%;'>
            <div class='noFriends_profile'>
                <div class='user_info_sec' style='height:45px;'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>added a new photo</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <h4 style='font-size: 14px;font-weight: normal;line-height: 1.38;'>$img_text</h4>
                <div class='main_sec' style='height:100%;'>
                  <div class='postImage'>
                    <img src='post_img/$image' style='width:100%;'>
                  </div>
                </div>
            </div>
          </div>
        ";
      }




    }
  }

}


// to get the active user
function getActiveUser(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $get_active_list = "SELECT * FROM friends WHERE rec_id=$user";
  $run_get_active_list = mysqli_query($con,$get_active_list);
  while($row_get_active_list = mysqli_fetch_array($run_get_active_list)){

    $friend_id = $row_get_active_list['friend_id'];

    if ($user != $friend_id) {
      
      $get_activeLogin_list = "SELECT * FROM login WHERE id=$friend_id AND active=1";
      $run_get_activeLogin_list = mysqli_query($con,$get_activeLogin_list);
      $row_get_activeLogin_list = mysqli_fetch_array($run_get_activeLogin_list);

      if($row_get_activeLogin_list>0){
        $u_id = $row_get_activeLogin_list['id'];

          $get_activeLogin_details = "SELECT * FROM personal_details WHERE u_id=$u_id";
          $run_get_activeLogin_details = mysqli_query($con,$get_activeLogin_details);
          $row_get_activeLogin_detail = mysqli_fetch_array($run_get_activeLogin_details);

            $activeUserName = $row_get_activeLogin_detail['name'];
            $activeUserProfile = $row_get_activeLogin_detail['profile_pic'];


          echo "
              <div class='row section_online'>
                <div class='col-md-3 online_friends_profile_pic'>
                  <img src='profile_img/$activeUserProfile'>
                </div>
                <div class='col-md-6 online_name' style='padding-right:0;'>
                  <p>$activeUserName</p>
                </div>
                <div class='col-md-2 online_status'>
                  <img src='images/online.jpg' align='bottom-right'>
                </div>
              </div>  <!--end of row -->
        ";
      }
    }
  }

}


// to get the about of the friends
function getfriendsAbout(){
include("dbconnect.php");
  $user = $_SESSION['usr_id'];

  echo "
      <div class='aboutSec'>
        <div class='upperInfo'>
          <div class='row'>
            <div class='col-md-1'>
              <img src='images/aboutProfile.png'>
            </div>
            <div class='col-md-11' style='margin-left: -50px;margin-top: 2px;'>
              <h3>About</h3>
            </div>
          </div>
        </div>
      </div>
          
    ";

  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];
    $get_get_basicInfo = "SELECT * FROM personal_details WHERE u_id=$u_id";
    $run_get_basicInfo = mysqli_query($con,$get_get_basicInfo);
    $row_get_basicInfo = mysqli_fetch_array($run_get_basicInfo);

    $name = $row_get_basicInfo['name'];
    $email = $row_get_basicInfo['email'];
    $day = $row_get_basicInfo['day'];
    $month = $row_get_basicInfo['month'];
    $year = $row_get_basicInfo['year'];
    $c_city = $row_get_basicInfo['c_city'];
    $p_city = $row_get_basicInfo['p_city'];
    $school = $row_get_basicInfo['school'];
    $college = $row_get_basicInfo['college'];
    $company = $row_get_basicInfo['company'];
    $about_me = $row_get_basicInfo['about_me'];

    $countFriend = getFriendsNumberAndDetailsFriend($u_id);

    if ($college == "") {
      $college = $school;
      $school = "";
    }

    echo "
      <div class='friendsAboutArea'>
            <div class='row'>
              <div class='col-md-3 sideMenu'>
                <div class='nav nav-tabs'>
                    
                    <a href='#overview' data-toggle='tab' class='active'>
                      <div class='sideMainNavArea'>
                        &nbsp;Overview
                      </div>
                    </a>
                    
                    <a href='#workEducation' data-toggle='tab'>
                      <div class='sideMainNavArea'>
                        Work and education
                      </div>
                    </a>

                    <a href='#livingPlace' data-toggle='tab'>
                      <div class='sideMainNavArea'>
                        Messages
                      </div>
                    </a>

                    <a href='#contactInfo' data-toggle='tab'>
                      <div class='sideMainNavArea'>
                        Contact and basic info
                      </div>
                    </a>
                    
                    <a href='#basicIntro' data-toggle='tab'>
                      <div class='sideMainNavArea'>
                        Settings
                      </div>
                    </a>

                </div>
            </div>
            <div class='col-md-9 allContentArea'>
                <div class='tab-content'>
                    <div class='tab-pane active' id='overview'>
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/work2.png' width='35px' height='37px' style='border-radius:50%;border:1px solid #d3d6db;'>
                        </div>
                        <div class='col-md-10 Information work'>
                          <h3>$company</h3>
                        </div>
                      </div>
                      <br> 
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/study.png'>
                        </div>
                        <div class='col-md-10 Information'>
                          <h3>Studied at <span>$college</span></h3>
                          <h4><span>Past: </span>$school</h4>
                        </div>
                      </div>
                      <br>
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/location.png' width='35px' height='37px' style='border-radius:50%;border:1px solid #d3d6db;'>
                        </div>
                        <div class='col-md-10 Information location'>
                          <h3>Lives In <span>$c_city</span></h3>
                          <h4><span>From: </span>$p_city</h4>
                        </div>
                      </div>
                      <br>
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/userFriends.png' width='35px' height='37px' style='border-radius:50%;border:1px solid #d3d6db;'>
                        </div>
                        <div class='col-md-10 Information friendsNo'>
                          <h3>$countFriend <span>Friends</span></h3>
                        </div>
                      </div>

                    </div>
                    <div class='tab-pane' id='workEducation'>
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/work2.png' width='35px' height='37px' style='border-radius:50%;border:1px solid #d3d6db;'>
                        </div>
                        <div class='col-md-10 Information work'>
                          <h3>$company</h3>
                        </div>
                      </div>
                      <br> 
                      <div class='row'>
                        <div class='col-md-1'>
                          <img src='images/study.png'>
                        </div>
                        <div class='col-md-10 Information'>
                          <h3>Studied at <span>$college</span></h3>
                          <h4><span>Past: </span>$school</h4>
                        </div>
                      </div>
                      <br>
                    </div>
                    <div class='tab-pane' id='livingPlace'>Messages Tab.</div>
                    <div class='tab-pane' id='contactInfo'>Settings Tab.</div>
                    <div class='tab-pane' id='basicIntro'>Settings Tab.</div>
                </div>
            </div>
            <div class='clearfix'></div>
            </div>
      </div>
    ";

  }  

}
// friends friends area
function getFriendsFriendsSec(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];

  echo "
    <div class='friendFriendsSection'>
      <img src='images/friendWithName.png'>
    </div>
    <div class='friendfriendBody'>
      <div class='row'>
  ";

  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];


    $get_friendsBasicInfo = "SELECT * FROM friends WHERE rec_id=$u_id";
    $run_get_friendsBasicInfo = mysqli_query($con,$get_friendsBasicInfo);
    while($row_get_friendsBasicInfo = mysqli_fetch_array($run_get_friendsBasicInfo)){
      $friend_id = $row_get_friendsBasicInfo['friend_id'];

      $get_friendsInfo = "SELECT * FROM personal_details WHERE u_id=$friend_id";
      $run_get_friendsInfo = mysqli_query($con,$get_friendsInfo);
      $row_get_friendsInfo = mysqli_fetch_array($run_get_friendsInfo);

      $u_id = $row_get_friendsInfo['u_id'];
      $name = $row_get_friendsInfo['name'];
      $profileImg = $row_get_friendsInfo['profile_pic'];

      $countFriend = getFriendsNumberAndDetailsFriend($u_id);

      echo "
            <!-- start of friends of friends section -->
            <div class='col-md-6 mainCont'>
              <div class='row'>
                <div class='col-md-3 profileSection'>
                  <img src='profile_img/$profileImg'>
                </div>
                <div class='col-md-8 profileSection'>
                  <div class='nameAndFriends'>
                    <h4><a href='view_profile.php?u_id=$u_id'>$name</a></h4>
                    <h6>$countFriend&nbsp;<span>friends</span></h6>
                  </div>
                </div>
              </div>
            </div>
            <!-- end of friends of friends section -->
      ";

    }
  }
  echo "
      </div>
    </div>
  ";
}


// friends photos area
function getFriendsPhotosSec(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];

  echo "
    <div class='friendPhotosSection'>
      <img src='images/friendsPhotoImages.png'>
    </div>
    <div class='friendPhotos'>
      <div class='row'  style='margin:0;'>
  ";

  if(isset($_GET['u_id'])){
    $u_id = $_GET['u_id'];

    $get_friendsPhotos = "SELECT * FROM posts WHERE u_id=$u_id AND profile_img=0 AND onlyText=0";
    $run_get_friendsPhotos = mysqli_query($con,$get_friendsPhotos);
    while($row_get_friendsPhotos = mysqli_fetch_array($run_get_friendsPhotos)){

      $image = $row_get_friendsPhotos['image'];

      echo "
            <!-- start of photos -->
            <div class='col-md-3 postPhotos' style='padding-right:0;'>
              <img src='post_img/$image'>
            </div>
            <!-- end of photos -->
      ";
    }

  }
  echo "
      </div>
    </div>
    <br>
  ";
}


// to get the request list of friends
function get_requestList(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $zero = 0;

  $get_request_list = "SELECT * FROM friend_request WHERE receiver_id=$user AND response=$zero ORDER BY request_id ASC";
  $run_get_request_list = mysqli_query($con,$get_request_list);
  while($row_get_request_list = mysqli_fetch_array($run_get_request_list)){

  $request_id = $row_get_request_list['request_id'];
  $sender_id = $row_get_request_list['sender_id'];

  // user information
  $get_request_user_personal_info = "SELECT * FROM personal_details where u_id='$sender_id'";
  $run_get_request_user_personal_info = mysqli_query($con,$get_request_user_personal_info);
  $row_get_request_user_personal_info = mysqli_fetch_array($run_get_request_user_personal_info);

  $u_id = $row_get_request_user_personal_info['u_id'];
  $name = $row_get_request_user_personal_info['name'];
  $profile_pic = $row_get_request_user_personal_info['profile_pic'];


  echo "
      <div class='row'>
        <div class='col-md-2 list_profile_pic'>
          <img src='profile_img/$profile_pic'>
        </div>
        <div class='col-md-4 list_profile_pic' style='padding: 0;'>
          <h6><a href='view_profile.php?u_id=$u_id'>$name</a></h6>
        </div>
        <div class='col-md-6' style='padding-top:6px;'>
          <a href='confirm_request.php?reciver_id=$u_id&sender_id=$sender_id&request_id=$request_id'>
            <input type='submit' value='Confirm' class='btn btn-sm confirm_btn'></a>&nbsp;&nbsp;<input type='submit' value='Remove' class='btn btn-sm remove_btn'>
        </div>
      </div>
      <hr style='margin-top: 4px;margin-bottom: 4px;'>
  ";


  }

}
$GLOBALS['a'] = 0;
// suggection friend list on navbar
// to get the request list of friends
function get_suggectionList(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $GLOBALS['a'] = 0;

  getNext();

}
function getNext(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $a = 1;

if($a<=4){
  // user information
  $get_request_suggection_personal_info = "SELECT * FROM personal_details where u_id!='$user'";
  $run_get_request_suggection_personal_info = mysqli_query($con,$get_request_suggection_personal_info);
  while($row_get_request_suggection_personal_info = mysqli_fetch_array($run_get_request_suggection_personal_info)){

    $isNotPresent = true;

    $friendUltimateChecking = $row_get_request_suggection_personal_info['u_id'];

    $u_id = $row_get_request_suggection_personal_info['u_id'];
    $name = $row_get_request_suggection_personal_info['name'];
    $profile_pic = $row_get_request_suggection_personal_info['profile_pic'];



if($GLOBALS['a'] != $u_id){

    // check already present in the friend list or not
    $get_user_send_friendreq_info = "SELECT * FROM friend_request";
    $run_get_user_send_friendreq_info = mysqli_query($con,$get_user_send_friendreq_info);
    while($row_get_user_send_friendreq_info = mysqli_fetch_array($run_get_user_send_friendreq_info)){
      // checking
      $friendreq_list = $row_get_user_send_friendreq_info['sender_id'];
      $receiver_id = $row_get_user_send_friendreq_info['receiver_id'];

      $isNotPresent = true;
      if ($friendreq_list == $u_id || $receiver_id == $u_id) {
        $isNotPresent = false;
      }
      else{
        $isNotPresent = true;
      }


      // check already present in the friend list or not
      // $get_user_send_friend_info = "SELECT * FROM friends WHERE rec_id='$user'";
      // $run_get_user_send_friend_info = mysqli_query($con,$get_user_send_friend_info);
      // while($row_get_user_send_friend_info = mysqli_fetch_array($run_get_user_send_friend_info)){
      //   // checking
      //   $friend_list = $row_get_user_send_friend_info['friend_id'];

      //   if ($friend_list == $u_id) {
      //     $isNotPresent = false;
      //   }
      //   else{
      //     $isNotPresent = true;
      //   }

        if($isNotPresent){
          echo "
            <div class='row'>
              <div class='col-md-2 list_profile_pic'>
                <img src='profile_img/$profile_pic'>
              </div>
              <div class='col-md-4 list_profile_pic' style='padding: 0;'>
                <h6><a href='view_profile.php?u_id=$u_id'>$name</a></h6>
              </div>
              <div class='col-md-6' style='padding-top:6px;'>
                <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
                  <input type='submit' value='Add Friend' class='btn btn-sm confirm_btn'></a>
              </div>
            </div>
            <hr style='margin-top: 4px;margin-bottom: 4px;'>
          ";
          $a++;
          goto nextID;
        }
      // }


    }

      // startting personal_details
      if($isNotPresent){
          echo "
            <div class='row'>
              <div class='col-md-2 list_profile_pic'>
                <img src='profile_img/$profile_pic'>
              </div>
              <div class='col-md-4 list_profile_pic' style='padding: 0;'>
                <h6><a href='view_profile.php?u_id=$u_id'>$name</a></h6>
              </div>
              <div class='col-md-6' style='padding-top:6px;'>
                <a href='friend_request.php?reciver_id=$u_id&sender_id=$user'>
                  <input type='submit' value='Add Friend' class='btn btn-sm confirm_btn'></a>&nbsp;&nbsp;<input type='submit' value='Delete' class='btn btn-sm remove_btn'>
              </div>
            </div>
            <hr style='margin-top: 4px;margin-bottom: 4px;'>
          ";
          $a++;
          goto nextID;
        }

  }

  nextID:
}

}

}
// }

//for normal profile friend list
function getFriendsNumberAndDetails(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $acept = 1;
  $count = 0;


  $get_user_friend_info = "SELECT * FROM friends where rec_id='$user'";
  $run_get_user_friend_info = mysqli_query($con,$get_user_friend_info);
  while($row_get_user_friend_info = mysqli_fetch_array($run_get_user_friend_info)){
    $count++;
  }
  echo "$count";
}

//for small profile friend list
function getFriendsNumberAndDetailsFriend($u_id){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $acept = 1;
  $count = 0;


  $get_user_friend_info = "SELECT * FROM friends where rec_id='$u_id'";
  $run_get_user_friend_info = mysqli_query($con,$get_user_friend_info);
  while($row_get_user_friend_info = mysqli_fetch_array($run_get_user_friend_info)){
    $count++;
  }
  return $count;
}


// my newsFeed area
function myNewsFeed(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];


  $getMyNewsFeedContent = "SELECT * FROM posts ORDER BY post_id DESC";
  $run_getMyNewsFeedContent = mysqli_query($con,$getMyNewsFeedContent);
  while($row_getMyNewsFeedContent = mysqli_fetch_array($run_getMyNewsFeedContent)){
    $u_id = $row_getMyNewsFeedContent['u_id'];
    $img_text = $row_getMyNewsFeedContent['img_text'];
    $image = $row_getMyNewsFeedContent['image'];
    $profile_img = $row_getMyNewsFeedContent['profile_img'];
    $onlyText = $row_getMyNewsFeedContent['onlyText'];
    $group_post = $row_getMyNewsFeedContent['group_post'];
    $group_id = $row_getMyNewsFeedContent['group_id'];
    $date = $row_getMyNewsFeedContent['date'];


    // user details
    $getUser = "SELECT * FROM personal_details WHERE u_id='$u_id'";
    $run_getUser = mysqli_query($con,$getUser);
    $row_getUser = mysqli_fetch_array($run_getUser);

    $name = $row_getUser['name'];
    $profile_pic2 = $row_getUser['profile_pic'];
    $cover_pic = $row_getUser['cover_pic'];


    // genderss details
    $getGender = "SELECT gender FROM login WHERE id='$u_id'";
    $run_getGender = mysqli_query($con,$getGender);
    $row_getGender = mysqli_fetch_array($run_getGender);

    $gender = $row_getGender['gender'];
    if ($gender == "male") {
      $code = "his";
    } else{
      $code = "her";
    }


    $profile_pic = $row_getUser['profile_pic'];
    if ($profile_pic == "") {
      $profile_pic = "blank_profile2.png";
    }

    $getGroupUser = "SELECT u_id from groupmember WHERE u_id=$user AND groupid=$group_id";
    $run_getGroupUser = mysqli_query($con,$getGroupUser);
    $row_data = mysqli_fetch_array($run_getGroupUser);

    if($row_data>0){

      // group post
      if ($group_id !=0 && $group_post !=0) {
        $getUserGroup = "SELECT groupname FROM groupdes WHERE groupId='$group_id'";
        $run_getUserGroup = mysqli_query($con,$getUserGroup);
        $row_getUserGroup = mysqli_fetch_array($run_getUserGroup);

        $groupname = $row_getUserGroup['groupname'];
        // newsfeed area for group

        if (($onlyText == 0) && ($group_post == 1) && ($profile_img == 0) && ($group_id != 0)) {
          // photo of user in group
          echo "
            <div class='allUserPost'>
              <div class='noFriends_profile'>
                  <div class='user_info_sec'>
                    <div class='row'>
                      <div class='col-md-1'>
                        <img src='profile_img/$profile_pic2'>
                      </div>
                      <div class='col-md-11 name_info'>
                        <h4>
                          <a href='view_profile.php?u_id=$u_id'>$name</a>
                          <span>added a new photo in <span><a href='viewGroup.php?group_id=$group_id' style='color:#365899;'>$groupname</a></span></span>
                        </h4>
                        <h6></h6>
                      </div>
                    </div>
                  </div>
                  <div class='main_sec'>
                    <h4>$img_text</h4>
                    <div class='postImage'>
                      <img src='post_img/$image'>
                    </div>
                  </div>
              </div>
            </div>
          ";
        }
        if(($onlyText == 1) && ($group_post == 1) && ($profile_img == 0) && ($group_id != 0)){
          // only text in the group
          echo "
            <div class='newsFeed_onlyText'>
                <div class='onlyTextUser_info_sec_cover'>
                    <div class='row'>
                      <div class='col-md-1 newsFeedCoverImage'>
                        <img src='profile_img/$profile_pic2'>
                      </div>
                      <div class='col-md-11 newsFeedName_info'>
                        <h4>
                          <a href='view_profile.php?u_id=$u_id'>$name</a>
                          <span>post a new status in <span><a href='viewGroup.php?group_id=$group_id' style='color:#365899;'>$groupname</a></span></span>
                        </h4>
                        <h6></h6>
                      </div>
                    </div>
                </div>
                <div class'onlyTextSection'>
                  <h3>$img_text</h3>
                </div>
              </div>
          ";
        }

      }
    }


    // cheking if a member of a group or not


    // check is in friend list or not
    $getMyFriendList = "SELECT * FROM friends WHERE rec_id=$user";
    $run_getMyFriendList = mysqli_query($con,$getMyFriendList);
    while($row_getMyFriendList = mysqli_fetch_array($run_getMyFriendList)){
      $friend_id = $row_getMyFriendList['friend_id'];

      // check for profile image
      if (($friend_id == $u_id) && ($profile_img == 1) && ($group_post == 0)){
        echo "
            <div class='newsFeedProfileSection'>
                <div class='newsFeedUser_info_sec'>
                  <div class='row'>
                    <div class='col-md-1 useerProfilePicture'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedname_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>updated <span>$code</span> profile picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <div class='newsFeedcover_area'>
                    <img src='cover_img/$cover_pic'>
                  </div>
                  <div class='newsFeedprofile_area'>
                    <img src='profile_img/$image'>
                  </div>
                </div>
            </div>
        ";
      }


      // if cover photo
    if (($friend_id == $u_id) && ($profile_img == 2) && ($group_post == 0)){
      echo "
            <div class='newsFeed_profile_cover'>
              <div class='newsFeedUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>updated <span>$code</span> cover picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'newsFeedonly_cover_sec'>
                <img src='cover_img/$image' width='100%'>
              </div>
            </div>
      ";
    }

      // For only Text
      if (($friend_id == $u_id) && ($onlyText == 1) && ($group_post == 0)){
        echo "
            <div class='newsFeed_onlyText'>
              <div class='onlyTextUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>post a new status</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'onlyTextSection'>
                <h3>$img_text</h3>
              </div>
            </div>
        ";
      }


      // normal photo post
      if (($friend_id == $u_id) && ($profile_img == 0) && ($onlyText == 0) && ($group_post == 0)) {
        echo "
          <div class='allUserPost'>
            <div class='noFriends_profile'>
                <div class='user_info_sec'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>added a new photo</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <h4>$img_text</h4>
                  <div class='postImage'>
                    <img src='post_img/$image'>
                  </div>
                </div>
            </div>
          </div>
        ";
      }
    }


    // start of own section
    // if profile photo
    if (($user == $u_id) && ($profile_img == 1) && ($onlyText == 0) && ($group_post == 0)){
        echo "
            <div class='newsFeedProfileSection'>
                <div class='newsFeedUser_info_sec'>
                  <div class='row'>
                    <div class='col-md-1 useerProfilePicture'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedname_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>updated <span>$code</span> profile picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <div class='newsFeedcover_area'>
                    <img src='cover_img/$cover_pic'>
                  </div>
                  <div class='newsFeedprofile_area'>
                    <img src='profile_img/$image'>
                  </div>
                </div>
            </div>
        ";
    }


    // if cover photo
    if (($user == $u_id) && ($profile_img == 2) && ($onlyText == 0) && ($group_post == 0)){
      echo "
            <div class='newsFeed_profile_cover'>
              <div class='newsFeedUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>updated <span>$code</span> cover picture</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'newsFeedonly_cover_sec'>
                <img src='cover_img/$image' width='100%'>
              </div>
            </div>
      ";
    }


    // For only Text
      if (($user == $u_id) && ($onlyText == 1) && ($group_post == 0)){
        echo "
            <div class='newsFeed_onlyText'>
              <div class='onlyTextUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>post a new status</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'onlyTextSection'>
                <h3>$img_text</h3>
              </div>
            </div>  
        ";
      }


    // if normal photo
    if (($user == $u_id) && ($profile_img == 0) && ($onlyText == 0) && ($group_post == 0)) {
        echo "
          <div class='allUserPost'>
            <div class='noFriends_profile'>
                <div class='user_info_sec'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic2'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>added a new photo</span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <h4>$img_text</h4>
                  <div class='postImage'>
                    <img src='post_img/$image'>
                  </div>
                </div>
            </div>
          </div>
          
        ";
    }
  }

}


// get numberof posts
function getNoOPostPosts(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $count=0;
  $get_noOfPost = "SELECT * FROM posts WHERE u_id=$user AND profile_img=0";
  $run_get_noOfPost = mysqli_query($con,$get_noOfPost);
  while($row_get_noOfPost = mysqli_fetch_array($run_get_noOfPost)){
    $count++;
  }
  echo "$count";
}


// get numberof photos
function getNoOPostPhotos(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $count=0;
  $get_noOfPost2 = "SELECT * FROM posts WHERE u_id=$user AND profile_img=0 AND onlyText=0";
  $run_get_noOfPost2 = mysqli_query($con,$get_noOfPost2);
  while($row_get_noOfPost2 = mysqli_fetch_array($run_get_noOfPost2)){
    $count++;
  }
  echo "$count";
}


// get numberof posts
function getNoOPostPosts_1($uid){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $count=0;
  $get_noOfPost = "SELECT * FROM posts WHERE u_id=$uid AND profile_img=0";
  $run_get_noOfPost = mysqli_query($con,$get_noOfPost);
  while($row_get_noOfPost = mysqli_fetch_array($run_get_noOfPost)){
    $count++;
  }
  return $count;
}


// get numberof photos
function getNoOPostPhotos_1($uid){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $count=0;
  $get_noOfPost2 = "SELECT * FROM posts WHERE u_id=$uid AND profile_img=0 AND onlyText=0";
  $run_get_noOfPost2 = mysqli_query($con,$get_noOfPost2);
  while($row_get_noOfPost2 = mysqli_fetch_array($run_get_noOfPost2)){
    $count++;
  }
  return $count;
}


// suggested groups
function getSuggestedGroupDetails(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $countMember = 0;
  $active = "active";

  $get_group = "SELECT * FROM groupdes WHERE createdby!=$user ORDER BY groupid DESC";
  $run_get_group = mysqli_query($con,$get_group);
  while($row_get_group = mysqli_fetch_array($run_get_group)){

    $groupid = $row_get_group['groupId'];
    $groupname = $row_get_group['groupname'];
    $groupdes = $row_get_group['groupdes'];
    $groupimg = $row_get_group['groupimg'];
    $groupcover = $row_get_group['groupcover'];


    $get_groupMember = "SELECT * FROM groupmember WHERE u_id=$user AND groupid=$groupid";
    $run_get_groupMember = mysqli_query($con,$get_groupMember);
    $row_get_groupMember = mysqli_fetch_array($run_get_groupMember);

    // no of people join this group
    $countMember = 0;
    $get_groupMemberNo = "SELECT * FROM groupmember WHERE groupid=$groupid";
    $run_get_groupMemberNo = mysqli_query($con,$get_groupMemberNo);
    while($row_get_groupMemberNo = mysqli_fetch_array($run_get_groupMemberNo)){
      $countMember++;
    }

    if ($row_get_groupMember<=0){

      echo " 
                <div class='carousel-item $active'>
                  <div class='card mb-4 shadow-sm' style='margin-bottom: 0;'>
                    <div class='card-body'>
                        <div class='numberOfLiks'>
                          <h5>$countMember <span>people join this.</span></h5>
                          <hr style='margin: 2px 0px;'>
                        </div>
                        <div class='row'>
                          <div class='col-md-3 groupProfile'>
                            <img src='group_profile_img/$groupimg'>
                          </div>
                          <div class='col-md-9 groupName' style='padding-left: 7px;'>
                            <h3><a href='viewGroup.php?group_id=$groupid' style='color:#365899;'>$groupname</a></h3>
                            <p class='card-text'>$groupdes</p>
                          </div>
                        </div>
                      </div>
                    <img class='card-img-top' src='group_img/$groupcover'>
                    <div class='joinNow'>
                      <form method='POST' action=''>
                      <input type='text' name='group_id' value='$groupid' style='display:none;'>
                        <button class='btn' name='join_group'><span><i class='fas fa-sign-in-alt'></i>&nbsp;Join Now</span></button>
                      </form>
                    </div>
                  </div>
                <!-- content for cuarsol -->
                </div> 
      ";
      $active = "";
    }
  }

}


// no of people's birthday today
function noOfPeopleBirthday(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $count = 0;

  $day = date("j");
  $month = date("n");
  $year = date("Y");

  $get_birthday = "SELECT * FROM personal_details WHERE day=$day AND month=$month";
  $run_get_birthday = mysqli_query($con,$get_birthday);
  while($row_get_birthday = mysqli_fetch_array($run_get_birthday)){
    $u_id = $row_get_birthday['u_id'];

    $get_birthdayFriend = "SELECT * FROM friends WHERE rec_id=$user AND friend_id=$u_id";
    $run_get_birthdayFriend = mysqli_query($con,$get_birthdayFriend);
    $row_get_birthdayFriend = mysqli_fetch_array($run_get_birthdayFriend);

    if($row_get_birthdayFriend>0){
      $count++;
    }
  }
  return $count;
}

// get birthday information
function getBirthday(){
  include("dbconnect.php");
  $user = $_SESSION['usr_id'];
  $numberOfBirthday = 0;
  $complete = 1;

  $day = date("j");
  $month = date("n");
  $year = date("Y");

  $get_birthday = "SELECT * FROM personal_details WHERE day=$day AND month=$month";
  $run_get_birthday = mysqli_query($con,$get_birthday);
  while($row_get_birthday = mysqli_fetch_array($run_get_birthday)){

    $u_id = $row_get_birthday['u_id'];
    $name = $row_get_birthday['name'];
    $birthYear = $row_get_birthday['year'];

    $age = $year - $birthYear;

    $get_birthdayFriend = "SELECT * FROM friends WHERE rec_id=$user AND friend_id=$u_id";
    $run_get_birthdayFriend = mysqli_query($con,$get_birthdayFriend);
    $row_get_birthdayFriend = mysqli_fetch_array($run_get_birthdayFriend);

    $numberOfBirthday = noOfPeopleBirthday();
    $numberOfBirthday = $numberOfBirthday - 1;
    if($numberOfBirthday>0){
      $check = "and&nbsp;<span style='cursor:pointer;' data-toggle='modal' data-target='#birthday'>$numberOfBirthday&nbsp;other's birthday today</span>";
    } else{
      $check = "have birthday today";
    }
    
    if($row_get_birthdayFriend>0){
        if($complete == 1){
          echo "
              <div class='birthday'>
                <div class='content'>
                  <h4>
                    <img src='images/birthday_reminder.png'>&nbsp;<span><a href='view_profile.php?u_id=$u_id'>$name </a></span><span style='color: #2C3A47;'> $check </span>
                  </h4>
                </div>
              </div>
          ";
        }

        if ($complete == 1) {
          echo "
            <div class='modal fade' id='birthday' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title' id='exampleModalLabel'><img src='images/birthday_reminder.png'>&nbsp;&nbsp;Birthday</h5>
                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                        </div>
                        <div class='modal-body' style='background:#fff;border-color:#fff;'>
          ";
        }
        $complete = 0;
        echo "
            <div class='birthdayName'>
              <div class='row'>
                <div class='col-md-8'>
                  <h3 style='font-size:13px;'><span><a href='view_profile.php?u_id=$u_id'>$name</a></span>&nbsp;'s birthday is today</h3>
                </div>
                <div class='col-md-4'>
                  <h3 style='font-size:13px;'><span style='padding-left:20px;'>$age</span>&nbsp;Years old</h3>
                </div>
              </div>
            </div>    
        ";

    }

  }

  echo "
                </div>
              </div>
            </div>
          </div>
  ";
}


// to get the news feed for group
function getGroupNewsFeed(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  if(isset($_GET['group_id'])){
    $group_id = $_GET['group_id'];

    $getGroupNewsFeedContent = "SELECT * FROM posts WHERE group_post=1 AND group_id=$group_id ORDER BY post_id DESC";
    $run_getGroupNewsFeedContent = mysqli_query($con,$getGroupNewsFeedContent);
    while($row_getGroupNewsFeedContent = mysqli_fetch_array($run_getGroupNewsFeedContent)){
      $u_id = $row_getGroupNewsFeedContent['u_id'];
      $img_text = $row_getGroupNewsFeedContent['img_text'];
      $image = $row_getGroupNewsFeedContent['image'];
      $onlyText = $row_getGroupNewsFeedContent['onlyText'];
      $date = $row_getGroupNewsFeedContent['date'];

      $getGroupPostCust = "SELECT name,profile_pic FROM personal_details WHERE u_id=$u_id";
      $run_getGroupPostCust = mysqli_query($con,$getGroupPostCust);
      $row_getGroupPostCust = mysqli_fetch_array($run_getGroupPostCust);

      $name = $row_getGroupPostCust['name'];
      $profile_pic = $row_getGroupPostCust['profile_pic'];

      $getGroupDetails = "SELECT groupname FROM groupdes WHERE groupId=$group_id";
      $run_getGroupDetails = mysqli_query($con,$getGroupDetails);
      $row_getGroupDetails = mysqli_fetch_array($run_getGroupDetails);

      $groupname = $row_getGroupDetails['groupname'];

      if ($onlyText == 0) {
        // photo
        echo "
          <div class='allUserPost'>
            <div class='noFriends_profile'>
                <div class='user_info_sec'>
                  <div class='row'>
                    <div class='col-md-1'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 name_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>added a new photo in <span><a href='viewGroup.php?group_id=$group_id' style='color:#365899;'>$groupname</a></span></span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
                </div>
                <div class='main_sec'>
                  <h4>$img_text</h4>
                  <div class='postImage'>
                    <img src='post_img/$image'>
                  </div>
                </div>
            </div>
          </div>
        ";
      }
      else{
        // only text
        echo "
          <div class='newsFeed_onlyText'>
              <div class='onlyTextUser_info_sec_cover'>
                  <div class='row'>
                    <div class='col-md-1 newsFeedCoverImage'>
                      <img src='profile_img/$profile_pic'>
                    </div>
                    <div class='col-md-11 newsFeedName_info'>
                      <h4>
                        <a href='view_profile.php?u_id=$u_id'>$name</a>
                        <span>post a new status in <span><a href='viewGroup.php?group_id=$group_id' style='color:#365899;'>$groupname</a></span></span>
                      </h4>
                      <h6></h6>
                    </div>
                  </div>
              </div>
              <div class'onlyTextSection'>
                <h3>$img_text</h3>
              </div>
            </div>
        ";
      }

    }
  }

}


// get active user homepage
function getActiveUserHomepage(){
include("dbconnect.php");
$user = $_SESSION['usr_id'];

  $get_active_list = "SELECT * FROM friends WHERE rec_id=$user";
  $run_get_active_list = mysqli_query($con,$get_active_list);
  while($row_get_active_list = mysqli_fetch_array($run_get_active_list)){

    $friend_id = $row_get_active_list['friend_id'];

    if ($user != $friend_id) {
      
      $get_activeLogin_list = "SELECT * FROM login WHERE active=1 AND id!=$user AND id=$friend_id";
      $run_get_activeLogin_list = mysqli_query($con,$get_activeLogin_list);
      $row_get_activeLogin_list = mysqli_fetch_array($run_get_activeLogin_list);

      if($row_get_activeLogin_list>0){
          $u_id = $row_get_activeLogin_list['id'];

            $get_activeLogin_details = "SELECT * FROM personal_details WHERE u_id=$u_id";
            $run_get_activeLogin_details = mysqli_query($con,$get_activeLogin_details);
            $row_get_activeLogin_details = mysqli_fetch_array($run_get_activeLogin_details);

              $activeUserName = $row_get_activeLogin_details['name'];
              $activeUserId = $row_get_activeLogin_details['u_id'];
              $activeUserProfile = $row_get_activeLogin_details['profile_pic'];

              echo "
                <div class='poupChatUser'>
                  <div class='row'>
                    <div class='col-md-1' style='padding-top:8px;'>
                      <div class='online'>&nbsp;</div>
                    </div>
                    <div class='col-md-10' style='padding-left:0px;'>
                      &nbsp;<a href='javascript:void(0);'onClick=window.open('popupChat.php?u_id=$activeUserId','Ratting','resizable=1,scrollbars=no,width=300,height=420,0,status=0,');>$activeUserName</a>
                    </div>
                  </div>
                </div>
              ";

      }
    }
  }
  
}


?>