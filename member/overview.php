<?php
  session_start();
  if($_SESSION['success'] != true){
    sleep(2);
    echo "<script>alert('請登入會員');</script> "; 
    echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
  }
  $user=$_SESSION['user'];
  require_once("../connect_database.php");
?>
<!DOCTYPE html>
<html>
<head>
<title>Online Music Search System</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
  body,h1,h2,h3,h4,h5,h6 {font-family: 'Raleway', sans-serif}
</style>
<body class="w3-light-grey w3-content" style="max-width:1600px">
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <?php 
      if(empty($_SESSION['pic'])){
        echo "<img src='Anonymous.jpg' style='width:45%;' class='w3-round'><br><br>";
        echo "<h4 ><b id='demo'></b></h4>";
      }
      else{
        $picture=$_SESSION['pic'];
        echo "<img src='Profile_picture/$picture' style='width:45%;' class='w3-round'><br><br>";
      }
    ?>
    <p class="w3-text-grey">Made by Lucy</p>
  </div>
  <div class="w3-bar-block">
    <a href="../../" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal"><i class="fa fa-home fa-fw w3-margin-right"></i>HOME</a> 
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-th-large fa-fw w3-margin-right"></i>OVERVIEW</a> 
    <?php 
      if($_SESSION['role'] == 2){
        echo "<a href='edit_song_info.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-pencil fa-fw w3-margin-right'></i>EDIT SONG INFO</a>";
        echo "<a href='manage_member.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-users fa-fw w3-margin-right'></i>MANAGE MEMBER</a>";
        echo "<a href='opinion.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-comments-o fa-fw w3-margin-right'></i>OPINION</a>";
      }
    ?>
    <a href="edit_profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw w3-margin-right"></i>EDIT PROFILE</a> 
    <a href="changePW.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-lock fa-fw w3-margin-right"></i>CHANGE PASSWORD</a>
    <a href='upload.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-upload fa-fw w3-margin-right'></i>UPLOAD</a>
    <a href='file_manager.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-download fa-fw w3-margin-right'></i>DOWNLOAD</a>
    <a href='../logout.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-user fa-fw w3-margin-right'></i>LOGOUT</a>"
  </div>
  <div class="w3-panel w3-large">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <i class="fa fa-instagram w3-hover-opacity"></i>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="portfolio">
    <a href="#">
    <?php 
      if(empty($_SESSION['pic'])){
        echo "<img src='image/Anonymous.jpg' style='width:65px;' class='w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity'>";
      }
      else{
        $picture=$_SESSION['pic'];
        echo "<img src='Profile_picture/$picture' style='width:65px;' class='w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity'>";
      }
    ?>
    </a>
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
      <h1><b>Account Overview</b></h1>
    </div>
  </header>
  
  <!-- 第一個圖片格子-->
  <div class="w3-container w3-padding-large w3-khaki w3-hover-yellow" style="font-size: 20px">
    <?php
      $sql2 = "SELECT email,cellphone,gender,role FROM Account WHERE id='$user'";
      if($result= mysqli_query($link, $sql2)){
        while($rs = $result->fetch_assoc()) {
          $email= $rs['email'];
          $cellphone= $rs['cellphone'];
          $gender= $rs['gender'];
          $role= $rs['role'];
        }
      }
    ?>
    <div class="w3-container" style="text-align: center;">
      <?php 
        if($role==0){
          echo"<h2 style='color: #56CA7F'>General Member</h2><hr>";
          echo "You are free account now. In the free version, you can not comment on the song, and can not use the music cloud function. Welcome you to upgrade to Premium members at any time.<hr>";
          echo "<iframe width='200' height='200' frameborder='0' src='free.gif'></iframe><br>";
          echo "<a href='upgrade.php'>
                  <button class='w3-button w3-margin-bottom w3-padding' style='float: center;color:#56CA7F;'>Upgrade</button>
                </a>";
        } 
        else if($role==1){
          echo"<h2 style='color: #56CA7F'>Premium Member</h2><hr>";
          echo "歡迎付費會員".$user."進入會員專區<br>";
          echo "<iframe width='230' height='230' frameborder='0' src='pro.gif'></iframe><br>";
        } 
        else if($role==2){
          echo"<h2 style='color: #56CA7F'>Administrator</h2><hr>";
          echo "歡迎管理員".$user."大大進入管理系統<br>";
          echo "<iframe width='350' height='300' frameborder='0' src='admin.gif'></iframe>";
        } 
      ?>
    </div>
    <!-- <div class="w3-third w3-container w3-gray" style="margin:32px">
      <h2 style="color: #56CA7F">Profile</h2>
      <p>Username: <?php echo $user;?></p>
      <p>Email: <?php echo $email;?></p>
      <p>Cellphone: <?php echo $cellphone;?></p>
      <p >Gender: <?php echo $gender;?></p>
    </div> -->
  </div>

  

<!-- End page content -->


<script>
	// Script to open and close sidebar
	var x
	function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
	}

	function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
	}
</script>
</body>
</html>
