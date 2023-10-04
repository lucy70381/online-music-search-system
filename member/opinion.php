<?php
    session_start();
    require_once("../connect_database.php");
    if($_SESSION['success'] != true){
      sleep(2);
      echo "<script>alert('請登入會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
    }
    else if($_SESSION['role']!=2){
      sleep(2);
      echo "<script>alert('權限不足 僅有管理員可進入');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=overview.php>";
    }
	$user=$_SESSION['user'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Online Music Search System</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../favicon.ico">
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
    <a href="edit_profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw w3-margin-right"></i>EDIT PROFILE</a> 
    <a href="changePW.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-lock fa-fw w3-margin-right"></i>CHANGE PASSWORD</a>
    <a href='upload.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-upload fa-fw w3-margin-right'></i>UPLOAD</a>
    <a href='#' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-download fa-fw w3-margin-right'></i>DOWNLOAD</a>
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
      <h1><b>Manage Opinion</b></h1>
    </div>
  </header>
  
  <!-- 第一個圖片格子-->
  <div class="w3-container w3-padding-large w3-khaki" style="font-size: 20px">
    <div class="w3-container">
      <div style="text-align:center">
        <form method="post" name="form1" id="form1" action="delete.php">
          <table border="1px" style="margin:32px">
            <thead>
              <tr>
              <th>Delete</th>
              <th>Name</th>
              <th>E-mail</th>
              <th>Message</th>
              <th>Time</th>
              <th>State</th>
            </tr>
            </thead> 
            <tbody>
              <?php
                $sql="SELECT * FROM Opinion WHERE 1";
                if($result= mysqli_query($link, $sql)){
                  while($rs = $result->fetch_assoc()) {
                    $No= $rs['No'];
                    $name= $rs['name'];
                    $email= $rs['email'];
                    $message= $rs['message'];
                    $send_time= $rs['send_time'];
                    if($rs['state']==0)
                      $state='Unread';
                    else if($rs['state']==1)
                      $state='Read';
                  ?>
                  <tr>
                    <td width='5%' style="text-align: center;"><input type="checkbox" name="deleteNo[]" value="<?php echo $No;?>" id="<?php echo $No;?>"></td>
                    <td width='15%'><?php echo $name;?></td>
                    <td width='15%'><?php echo $email;?></td>
                    <td style="text-align: center; color: red" width='40%'><?php echo $message;?></td>
                    <td width='40%'><?php echo $send_time;?></td>
                    <td width='86%'>
                      <select size=1 name="select" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="<?php echo "edit.php?No=".$No.'&state=0'?>" <?php if($state=='Unread') echo "selected";?>>Unread
                        <option value="<?php echo "edit.php?No=".$No.'&state=1'?>" <?php if($state=='Read') echo "selected"?>>Read
                      </select>
                    </td>
                  </tr>
                <?php
                  }
                }
                else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                }
              ?>
            </tbody>
          </table>
          <button style="font-family: 'Lobster', cursive;color:#56CA7F;" class="w3-button w3-margin-bottom w3-padding">Delete</button>
        </form>
      </div>
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