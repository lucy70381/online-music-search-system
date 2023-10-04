<?php
  session_start();
  if($_SESSION['success'] != true){
    sleep(2);
    echo "<script>alert('請登入會員');</script> "; 
    echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
  }
  $user=$_SESSION['user'];
  require_once("../connect_database.php");

  $sql2 = "SELECT email,password,cellphone,gender FROM Account WHERE id='$user'";
  if($result= mysqli_query($link, $sql2)){
    while($rs = $result->fetch_assoc()) {
      $email= $rs['email'];
      $pass= $rs['password'];
      $cellphone= $rs['cellphone'];
      $gender= $rs['gender'];
    }
  }
  $emailErr = $passwordErr = $cellphoneErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = test_input($_POST["password"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z0-9]*$/",$password)) {
      $password="";
      $passwordErr = "<br>Only letters and number allowed"; 
    }
    else if($pass!=$password){
      $password="";
      $passwordErr = "<br>The password is incorrect"; 
    }
    
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email="";
      $emailErr = "<br>Invalid email format"; 
    }
    
    $cellphone = test_input($_POST["cellphone"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$cellphone)) {
      $cellphone="";
      $cellphoneErr = "<br>Only number allowed"; 
    }
    $gender = test_input($_POST["gender"]);

    /*if (!empty($_POST["id"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["cellphone"]) && !empty($_POST["gender"]))*/
    if (!empty($password) && !empty($email) && !empty($cellphone) && !empty($gender)){
      $sql = "UPDATE Account SET email='$email', cellphone = '$cellphone', gender= '$gender' WHERE id='$user'";
      if (mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('已成功修改資料');</script> "; 
            echo "<meta http-equiv=REFRESH CONTENT=1;url=edit_profile.php>";
        mysqli_close($link);
      } else {
        echo "<script>alert('修改資料失敗');</script> ";
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
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
    <link href="https://fonts.googleapis.com/css?family=Lobster|Pinyon+Script" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Lobster|Pinyon+Script" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <style>
    .error {color: #FF0000; font-size: 20px; }
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
        <a href="overview.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-th-large fa-fw w3-margin-right"></i>OVERVIEW</a> 
        <?php 
          if($_SESSION['role'] == 2){
            echo "<a href='edit_song_info.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-pencil fa-fw w3-margin-right'></i>EDIT SONG INFO</a>";
            echo "<a href='manage_member.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-users fa-fw w3-margin-right'></i>MANAGE MEMBER</a>";
            echo "<a href='opinion.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-comments-o fa-fw w3-margin-right'></i>OPINION</a>";
          }
        ?>
        <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw w3-margin-right"></i>EDIT PROFILE</a> 
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
          <h1><b>Edit Profile</b></h1>
        </div>
      </header>
      
      <!-- 第一個圖片格子-->
      <div class="w3-container w3-padding-large w3-khaki" style="font-size: 20px">
        <div style="text-align:center">
          <form style="font-family: 'Lobster', cursive;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>Profile</h3>  
            　&nbsp&nbspUser: <input type="text" name="id" size="30" placeholder="Username" value="<?php echo $user;?>" readonly="readonly"><br><br>
            　&nbspE-mail: <input type="text" name="email" size="30" placeholder="E-mail" required value="<?php echo $email;?>">
            <span class="error"><?php echo $emailErr;?></span><br><br>
            Cellphone: <input type="tel" name="cellphone" size="30" placeholder="Cellphone" required value="<?php echo $cellphone;?>">
            <span class="error"><?php echo $cellphoneErr;?></span><br><br>
            Gender:
            <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> required value="female">Female
            <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> required value="male">Male</span><br><br>
            Password: <input type="password" name="password" size="30" placeholder="Password" required>
            <span class="error"><?php echo $passwordErr;?></span><br><br>
            <button class="w3-button w3-margin-bottom w3-padding" style='float: center;color:#56CA7F'>Submit</button><br><br>
          </form>
        </div>
      </div>
      <div class="w3-container w3-padding-large w3-gray" style="font-size: 20px">
        <h3>Change Profile Picture</h3>
        <div style="text-align:center">
          <p><img src="Profile_picture/<?php echo $picture;?>" class="w3-margin" style='height:300px;'></p>
          <form action="upload_pic.php" method="post" enctype="multipart/form-data">
            檔案名稱:<input type="file" name="file" id="file">
            <input type="submit" name="submit" value="上傳檔案"><br>
            <p style="color: red;">格式僅支援jpg、png，其餘不受理 (◔౪◔)</p>
          </form>
        </div>
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
