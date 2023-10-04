<?php
  session_start();
  require_once("./connect_database.php");
  date_default_timezone_set('Asia/Taipei');
  if(!isset($_SESSION['success'])){
    $_SESSION['success'] = false;
  }
  if(empty($_GET['page'])){
    $page=1;
    $n=0;
  }
  else{
    $page=$_GET['page'];
    $n=6*$page-6;
  }
  if(!empty($_GET['search'])){
    $search=$_GET['search'];

  }
  else{
    $search="";
  }
  $i=$No=$user = $msg = $now = $emailErr = "";
  $song_name=$rname=$singer1=$singer2=$album=$ralbum=$year=$youtubeURL=$language="";
  if(!empty($_GET['i'])) $i="ORDER BY No DESC";
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = test_input($_POST["Name"]);
    $email = test_input($_POST["Email"]);
    $msg = test_input($_POST["Message"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email="";
      $emailErr = "Invalid email format";
      echo "<script>alert('Email輸入格式不正確');</script> "; 
      echo "<script> location.href=('#contact'); </script>";
    }
    if (!preg_match(" /^[a-zA-Z0-9]*$/",$user) && !preg_match(" /[\x{4e00}-\x{9fa5}]+/u",$user)) {
          $user="";
          echo "<script>alert('Name輸入格式不正確');</script> "; 
        }
    else if(!empty($user)&&!empty($email)&&!empty($msg)){
      $now=date('Y-m-d H:i:s');
      $sql = "INSERT INTO Opinion (name, email, message, send_time)
          VALUES ('$user', '$email', '$msg','$now')";
      if ($conn=mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('已送出意見');</script> "; 
        echo "<meta http-equiv=REFRESH CONTENT=0;url=../>";
        mysqli_close($link);
      } else {
        echo "<script>alert('Message格式錯誤');</script> "; 
        echo "<meta http-equiv=REFRESH CONTENT=0;url=../>";
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
            echo "<img src='image/Anonymous.jpg' style='width:45%;' class='w3-round'><br><br>";
            echo "<h4 ><b id='demo'></b></h4>";
          }
          else{
            $picture=$_SESSION['pic'];
            echo "<img src='member/Profile_picture/$picture' style='width:45%;' class='w3-round'><br><br>";
          }
        ?>
        <p class="w3-text-grey">Made by Lucy</p>
      </div>
      <div class="w3-bar-block">
        <a href="../" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal"><i class="fa fa-home fa-fw w3-margin-right"></i>HOME</a> 
        <a href="#portfolio" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-th-large fa-fw w3-margin-right"></i>TOP</a> 
        <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-info-circle fa-fw w3-margin-right"></i>ABOUT</a> 
        <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw w3-margin-right"></i>CONTACT</a>
        <?php 
          if($_SESSION['success'] == true){
            echo "<a href='member/overview.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-smile-o fa-fw w3-margin-right'></i>PROFILE</a>";
            echo "<a href='member/upload.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding' target='_blank'><i class='fa fa-upload fa-fw w3-margin-right'></i>UPLOAD</a>";
            echo "<a href='member/file_manager.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding' target='_blank'><i class='fa fa-download fa-fw w3-margin-right'></i>DOWNLOAD</a>";
            echo "<a href='logout.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-user fa-fw w3-margin-right'></i>LOGOUT</a>";
          }
          else
            echo "<a href='login.php' onclick='w3_close()' class='w3-bar-item w3-button w3-padding'><i class='fa fa-user fa-fw w3-margin-right'></i>LOGIN</a>";
        ?>
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
            echo "<img src='member/Profile_picture/$picture' style='width:65px;' class='w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity'>";
          }
        ?>
        </a>
        <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
        <div class="w3-container">
        <h1><b>Online Music Search System</b></h1>
        <div class="w3-section w3-bottombar w3-padding-16">
          <span class="w3-margin-right">Filter:</span> 
          <button class="w3-button w3-black" onclick="location.href = '../'">ALL</button>
          <button class="w3-button w3-white" onclick="location.href = '?search=Chinese'">
            <i class="fa fa-music w3-margin-right"></i>Chinese</button>
          <button class="w3-button w3-white w3-hide-small" onclick="location.href = '?search=English'">
            <i class="fa fa-music w3-margin-right"></i>English</button>
          <button class="w3-button w3-white w3-hide-small" onclick="location.href = '?search=Japanese'">
            <i class="fa fa-music w3-margin-right"></i>Japanese</button>
          <button class="w3-button w3-white w3-hide-small" onclick="location.href = '?search=Korean'">
            <i class="fa fa-music w3-margin-right"></i>Korean</button>
          <input style="float:right" type="search" name="search" placeholder="search" value="<?php echo $search?>" onkeypress="handle(event,this.value)">
        </div>
      </header>
      
      <!-- 第一個圖片格子-->
      <div class="w3-row-padding">
        <?php
          $sql2 = "SELECT No,name,singer1,singer2,album,year,cover,youtubeURL ,language
                    FROM Song 
                    WHERE name like '%$search%' OR singer1 like '%$search%' OR singer2 like '%$search%' OR album like '%$search%'
                          OR year like '%$search%' OR language like '%$search%' ".$i.
                    " limit $n, 3";
          if($result= mysqli_query($link, $sql2)){
            while($rs = $result->fetch_assoc()) {
              $No=$rs['No'];
              $song_name= $rs['name'];
              $singer1= $rs['singer1'];
              $cover= $rs['cover'];
        ?>
          <div class="w3-third w3-container w3-margin-bottom">
            <a href="archive.php?no=<?php echo $No;?>">
              <img src="cover/<?php echo $cover;?>" alt="<?php echo $song_name;?>" style="width:100%" class="w3-hover-opacity">
            </a>
            <div class="w3-container w3-white">
              <p style="text-align:center"><b><?php echo $singer1.' - '.$song_name;?></b></p>
            </div>
          </div>
          <?php
            $n++;
            }
          }
          else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
          }
        ?>
      </div>
      <!-- Second Photo Grid-->
      <div class="w3-row-padding">
        <?php
          $sql2 = "SELECT No,name,singer1,singer2,album,year,cover,youtubeURL ,language
                    FROM Song 
                    WHERE name like '%$search%' OR singer1 like '%$search%' OR singer2 like '%$search%' OR album like '%$search%'
                          OR year like '%$search%' OR language like '%$search%' ".$i.
                    " limit $n, 3";
          if($result= mysqli_query($link, $sql2)){
            while($rs = $result->fetch_assoc()) {
              $No=$rs['No'];
              $song_name= $rs['name'];
              $singer1= $rs['singer1'];
              $cover= $rs['cover'];
        ?>
          <div class="w3-third w3-container w3-margin-bottom">
            <a href="archive.php?no=<?php echo $No;?>">
              <img src="cover/<?php echo $cover;?>" alt="<?php echo $song_name;?>" style="width:100%" class="w3-hover-opacity">
            </a>
            <div class="w3-container w3-white">
              <p style="text-align:center"><b><?php echo $singer1.' - '.$song_name;?></b></p>
            </div>
          </div>
          <?php
            $n++;
            }
          }
          else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
          }
        ?>
      </div>

      <!-- Pagination -->
      <div class="w3-center w3-padding-32">
        <div class="w3-bar">
        <?php
          if(empty($search)){
          ?>
            <a href="?page=<?php echo $page-1;?>" class="w3-bar-item w3-button w3-hover-black">«</a>
            <a href="#" class="w3-bar-item w3-black w3-button"><?php echo $page;?></a>
            <a href="?page=<?php echo $page+1;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+1;?></a>
            <a href="?page=<?php echo $page+2;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+2;?></a>
            <a href="?page=<?php echo $page+3;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+3;?></a>
            <a href="?page=<?php echo $page+1;?>" class="w3-bar-item w3-button w3-hover-black">»</a>
    <?php }
          else{
          ?>
            <a href="?search=<?php echo $search;?>&page=<?php echo $page-1;?>" class="w3-bar-item w3-button w3-hover-black">«</a>
            <a href="#" class="w3-bar-item w3-black w3-button"><?php echo $page;?></a>
            <a href="?search=<?php echo $search;?>&page=<?php echo $page+1;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+1;?></a>
            <a href="?search=<?php echo $search;?>&page=<?php echo $page+2;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+2;?></a>
            <a href="?search=<?php echo $search;?>&page=<?php echo $page+3;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $page+3;?></a>
            <a href="?search=<?php echo $search;?>&page=<?php echo $page+1;?>" class="w3-bar-item w3-button w3-hover-black">»</a>
    <?php }?>
          
        </div>
      </div>

      <div class="w3-container w3-padding-large" style="margin-bottom:32px" id="about">
        <h4><b>About Us</b></h4>
        <p>We hope that the user can find the song he or she wants,and the user can sign up as a member that has some functions, such as: sign in to get points and use the points to exchange some presents!</p>
        <hr>
        <?php
          $cnum=$enum=$jnum=$knum=0;
          $sql4="SELECT COUNT(name) FROM Song WHERE 1";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) {
              $total=$row["COUNT(name)"]*1;
            }
          }
          if($total!=0){
            $sql4="SELECT COUNT(name) FROM Song WHERE language='Chinese'";
            if ($result4 = mysqli_query($link, $sql4)) {
              if($row = $result4->fetch_assoc()) {
                $chinese=$row["COUNT(name)"]*100/$total.'%';
                $cnum =  ' ('.$row["COUNT(name)"].')';
              }
            } 
            $sql4="SELECT COUNT(name) FROM Song WHERE language='English'";
            if ($result4 = mysqli_query($link, $sql4)) {
              if($row = $result4->fetch_assoc()) {
                $english=$row["COUNT(name)"]*100/$total.'%';
                $enum =  ' ('.$row["COUNT(name)"].')';
              }
            }
            $sql4="SELECT COUNT(name) FROM Song WHERE language='Japanese'";
            if ($result4 = mysqli_query($link, $sql4)) {
              if($row = $result4->fetch_assoc()) { 
                $japanese=$row["COUNT(name)"]*100/$total.'%';
                $jnum = ' ('.$row["COUNT(name)"].')';
              }
            }
            $sql4="SELECT COUNT(name) FROM Song WHERE language='Korean'";
            if ($result4 = mysqli_query($link, $sql4)) {
              if($row = $result4->fetch_assoc()) { 
                $korean=$row["COUNT(name)"]*100/$total.'%';
                $knum = ' ('.$row["COUNT(name)"].')';
              }
            }
          }
          else $chinese=$english=$japanese=$korean='0%';
        ?>
        <h4>The language of the song (<?php echo $total;?>)</h4>
        <!-- Progress bars / Skills -->
        <p>Chinese Song</p>
        <div class="w3-grey">
          <div class="w3-container w3-dark-grey w3-padding w3-center" style='width:<?php echo $chinese;?>'><?php echo $chinese.$cnum;?></div>
        </div>
        <p>English Song</p>
        <div class="w3-grey">
          <div class="w3-container w3-dark-grey w3-padding w3-center" style='width:<?php echo $english;?>'><?php echo $english.$enum;?></div>
        </div>
        <p>Japanese Song</p>
        <div class="w3-grey">
          <div class="w3-container w3-dark-grey w3-padding w3-center" style='width:<?php echo $japanese;?>'><?php echo $japanese.$jnum;?></div>
        </div>
        <p>Korean Song</p>
        <div class="w3-grey">
          <div class="w3-container w3-dark-grey w3-padding w3-center" style='width:<?php echo $korean;?>'><?php echo $korean.$knum;?></div>
        </div>
        <hr>
        
        <h4>Which one do you want to register?</h4>
        <!-- Pricing Tables -->
        <div class="w3-row-padding" style="margin:0 -16px">
          <div class="w3-third w3-margin-bottom">
            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
              <li class="w3-black w3-xlarge w3-padding-32">Basic</li>
              <li class="w3-padding-16">Song comment</li>
              <li class="w3-padding-16">Upgrade To Premium！！！</li>
              <li class="w3-padding-16">Upgrade To Premium！！！</li>
              <li class="w3-padding-16">Upgrade To Premium！！！</li>
              <li class="w3-padding-16">
                <h2>$ Free</h2>
                <span class="w3-opacity">per month</span>
              </li>
              <li class="w3-light-grey w3-padding-24">
              <a href="register-basic.php">
                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Sign Up</button></a>
              </li>
            </ul>
          </div>
          
          <div class="w3-third w3-margin-bottom">
            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
              <li class="w3-teal w3-xlarge w3-padding-32">Premium</li>
              <li class="w3-padding-16">Song comment</li>
              <li class="w3-padding-16">Edit Profile Picture</li>
              <li class="w3-padding-16">Music Cloud</li>
              <li class="w3-padding-16"><p></p></li>
              <li class="w3-padding-16">
                <h2>$ 25</h2>
                <span class="w3-opacity">per month</span>
              </li>
              <li class="w3-light-grey w3-padding-24">
              <a href="register-pre.php">
                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Sign Up</button></a>
              </li>
            </ul>
          </div>
          
          <div class="w3-third">
            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
              <li class="w3-black w3-xlarge w3-padding-32">Administrator</li>
              <li class="w3-padding-16">Manage Song</li>
              <li class="w3-padding-16">Manage Member</li>
              <li class="w3-padding-16">Music Cloud</li>
              <li class="w3-padding-16">View Comments</li>
              <li class="w3-padding-16">
                <h2>$ Unlimited</h2>
                <span class="w3-opacity">per month</span>
              </li>
              <li class="w3-light-grey w3-padding-24">
              <a href="register-premium.php">
                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Join</button></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      
      <!-- Contact Section -->
      <div class="w3-container w3-padding-large w3-grey">
        <h4 id="contact"><b>Contact Us</b></h4>
        <div class="w3-row-padding w3-center w3-padding-24" style="margin:0 -16px">
          <div class="w3-third w3-dark-grey">
            <p><i class="fa fa-envelope w3-xxlarge w3-text-light-grey"></i></p>
            <p>topic3360@email.com</p>
          </div>
          <div class="w3-third w3-teal">
            <p><i class="fa fa-map-marker w3-xxlarge w3-text-light-grey"></i></p>
            <p>Taipei, Taiwan</p>
          </div>
          <div class="w3-third w3-dark-grey">
            <p><i class="fa fa-phone w3-xxlarge w3-text-light-grey"></i></p>
            <p>0800-092-000</p>
          </div>
        </div>
        <hr class="w3-opacity">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="w3-section">
            <label>Name</label>
            <input class="w3-input w3-border" type="text" name="Name" required value="<?php echo $name;?>">
          </div>
          <div class="w3-section">
            <label>Email</label>
            <input class="w3-input w3-border" type="text" name="Email" required value="<?php echo $email;?>" placeholder="<?php echo $emailErr;?>">
          </div>
          <div class="w3-section">
            <label>Message</label>
            <input class="w3-input w3-border" type="text" name="Message" required value="<?php echo $msg;?>">
          </div>
          <button type="submit" class="w3-button w3-black w3-margin-bottom"><i class="fa fa-paper-plane w3-margin-right"></i>Send Message</button>
        </form>
      </div>
      
      <div class="w3-black w3-center w3-padding-24">Powered by Lucy</div>

    <!-- End page content -->
    </div>

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

      function handle(e,value){
        if(e.keyCode === 13){
            location.href = '?search='+value;
        }
      }
    </script>
  </body>
</html>
