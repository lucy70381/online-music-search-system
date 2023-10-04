<?php
  session_start();
  require_once("connect_database.php");
  date_default_timezone_set('Asia/Taipei');
  if(empty($_GET["no"]))
    $n=1;
  else
    $n=$_GET["no"];
  $name=$rname=$singer1=$singer2=$album=$ralbum=$year=$youtubeURL=$language="";
  $sql3 = "SELECT name,singer1,singer2,album,year,cover,youtubeURL,CTR FROM Song WHERE No='$n'";
  if ($result3 = mysqli_query($link, $sql3)) {
    if($row = $result3->fetch_assoc()) {
      $name=$row["name"];
      $singer1=$row["singer1"];
      $singer2=$row["singer2"];
      $album=$row["album"];
      $year=$row["year"];
      $cover=$row["cover"];
      $youtubeURL=$row["youtubeURL"];
      $CTR=$row["CTR"]+1;
      $rname=str_replace("'","''",$name);
    }
  } else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
  }
  $sql5="UPDATE Song SET CTR = $CTR WHERE No='$n'";
  mysqli_query($link, $sql5);
  $sql2="SELECT user,comment,comment_time FROM Score WHERE song_name='$rname'";
  $comment = $rank = "";
  if(isset($_SESSION['user'])){
    $user=$_SESSION["user"];
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_SESSION['success'] == true){
      $comment = test_input($_POST["Comment"]);
      $rank = test_input($_POST["rank"]);
      $now=date('Y-m-d');
      $sql = "INSERT INTO Score (song_name,user, rank, comment, comment_time)
          VALUES ('$rname','$user', '$rank', '$comment', '$now')";
      if (mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('已評論成功');</script> "; 
        mysqli_close($link);
        echo "<meta http-equiv=REFRESH CONTENT=0;url=?no=".$n;
      } 
      else {
        $sql = "UPDATE Score SET rank='$rank', comment='$comment',comment_time='$now' WHERE user='$user'";
        if (mysqli_query($link, $sql) == TRUE) {
          echo "<script>alert('已成功修改先前的評論');</script> "; 
          mysqli_close($link);
          echo "<meta http-equiv=REFRESH CONTENT=0;url=?no=".$n;
        }
      }
    }
    else{
      sleep(2);
      echo "<script>alert('請登入會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=login.php>";
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
        }
        else{
          $picture=$_SESSION['pic'];
          echo "<img src='member/Profile_picture/$picture' style='width:45%;' class='w3-round'><br><br>";
        }
      ?>
      
      <h4 ><b id="demo"></b></h4>
      <p class="w3-text-grey">Made by Lucy</p>
    </div>
    <div class="w3-bar-block">
      <a href="../" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal"><i class="fa fa-home fa-fw w3-margin-right"></i>Home</a> 
      <a href="#portfolio" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal"><i class="fa fa-youtube fa-fw w3-margin-right"></i>VIDEO</a> 
      <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-info-circle fa-fw w3-margin-right"></i>ABOUT</a> 
      <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment fa-fw w3-margin-right"></i>COMMENT</a>
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
        <button class="w3-button w3-white" onclick="location.href = '../?search=Chinese'">
          <i class="fa fa-music w3-margin-right"></i>Chinese</button>
        <button class="w3-button w3-white w3-hide-small" onclick="location.href = '../?search=English'">
          <i class="fa fa-music w3-margin-right"></i>English</button>
        <button class="w3-button w3-white w3-hide-small" onclick="location.href = '../?search=Japanese'">
          <i class="fa fa-music w3-margin-right"></i>Japanese</button>
        <button class="w3-button w3-white w3-hide-small" onclick="location.href = '../?search=Korean'">
          <i class="fa fa-music w3-margin-right"></i>Korean</button>
        <input style="float:right" type="search" name="search" placeholder="search" value="<?php echo $search?>" onkeypress="handle(event,this.value)">
      </div>
    </header>
    
    <!-- 第一個圖片格子-->
    <div class="w3-row-padding">
      <div style="position:relative;height:0;padding-bottom:56.25%">
          <iframe width="640" height="360" 
            src="https://www.youtube.com/embed/<?php echo $youtubeURL;?>?rel=0" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen>
          </iframe>
      </div>
    </div>

    <!-- Pagination -->
    <div class="w3-center w3-padding-32">
      <div class="w3-bar">
        <a href="archive.php?no=<?php echo $n-1;?>" class="w3-bar-item w3-button w3-hover-black">«</a>
        <a href="#" class="w3-bar-item w3-black w3-button"><?php echo $n;?></a>
        <a href="archive.php?no=<?php echo $n+1;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $n+1;?></a>
        <a href="archive.php?no=<?php echo $n+2;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $n+2;?></a>
        <a href="archive.php?no=<?php echo $n+3;?>" class="w3-bar-item w3-button w3-hover-black"><?php echo $n+3;?></a>
        <a href="archive.php?no=<?php echo $n+1;?>" class="w3-bar-item w3-button w3-hover-black">»</a>
      </div>
    </div>

    <div class="w3-container w3-padding-large" style="margin-bottom:32px">
      <div class="w3-half">
        <img width="300" height="300" src="cover/<?php echo $cover;?>">
      </div>
      <div class="w3-half" style="font-size: 20px">
        <h2 id="about"><b><?php echo $name;?></b></h2>
        <?php 
          if(empty($singer2))
            echo "<p>Singer: ".$singer1."</p>";
          else{
            echo "<p>Singer1: ".$singer1."</p>";
            echo "<p>Singer2: ".$singer2."</p>";
          }
        ?>
        <p>Album: <?php echo $album;?></p>
        <p>Year: <?php echo $year;?></p>
        <p></p>
        <p style="text-align: right">Page View: <?php echo $CTR;?></p>
      </div>
    </div>
    <div class="w3-container w3-padding-large" style="margin-bottom:32px">
    <?php
        $sql4="SELECT COUNT(rank) FROM Score WHERE song_name='$rname'";
        if ($result4 = mysqli_query($link, $sql4)) {
          if($row = $result4->fetch_assoc()) {
            $total=$row["COUNT(rank)"]*1;
          }
        }
        if($total!=0){
          $sql4="SELECT COUNT(rank) FROM Score WHERE rank=5 AND song_name='$rname'";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) {
              $num5=$row["COUNT(rank)"]*100/$total.'%';
            }
          } 
          $sql4="SELECT COUNT(rank) FROM Score WHERE rank=4 AND song_name='$rname'";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) {
              $num4=$row["COUNT(rank)"]*100/$total.'%';
            }
          }
          $sql4="SELECT COUNT(rank) FROM Score WHERE rank=3 AND song_name='$rname'";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) { 
              $num3=$row["COUNT(rank)"]*100/$total.'%';
            }
          }
          $sql4="SELECT COUNT(rank) FROM Score WHERE rank=2 AND song_name='$rname'";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) {
              $num2=$row["COUNT(rank)"]*100/$total.'%';
            }
          }
          $sql4="SELECT COUNT(rank) FROM Score WHERE rank=1 AND song_name='$rname'";
          if ($result4 = mysqli_query($link, $sql4)) {
            if($row = $result4->fetch_assoc()) {
              $num1=$row["COUNT(rank)"]*100/$total.'%';
            }
          }
        }
        else $num5=$num4=$num3=$num2=$num1='0%';
      ?>
      <h4><?php echo $total;?> people have scored this song</h4>
      <p>Perfect</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-padding w3-center" style='width:<?php echo $num5;?>'><?php echo $num5;?></div>
      </div>
      <p>Good</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-padding w3-center" style="width:<?php echo $num4;?>"><?php echo $num4;?></div>
      </div>
      <p>So so</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-padding w3-center" style="width:<?php echo $num3;?>"><?php echo $num3;?></div>
      </div>
      <p>Not good</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-padding w3-center" style="width:<?php echo $num2;?>"><?php echo $num2;?></div>
      </div>
      <p>Bad</p>
      <div class="w3-grey">
        <div class="w3-container w3-dark-grey w3-padding w3-center" style="width:<?php echo $num1;?>"><?php echo $num1;?></div>
      </div>
    </div>
    
    <!-- Contact Section -->
    <div class="w3-container w3-padding-large w3-grey">
      <h4 id="contact"><b>Comment</b></h4>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="w3-section">
          <p>Leave comments</p>
          <input class="w3-input w3-border" type="text" name="Comment" required value="<?php echo $comment;?>">
        </div>
        <input type="radio" name="rank" required <?php if (isset($rank) && $rank==5) echo "checked";?> value=5>Perfect
        <input type="radio" name="rank" required <?php if (isset($rank) && $rank==4) echo "checked";?> value=4>Good
        <input type="radio" name="rank" required <?php if (isset($rank) && $rank==3) echo "checked";?> value=3>So so
        <input type="radio" name="rank" required <?php if (isset($rank) && $rank==2) echo "checked";?> value=2>Not good
        <input type="radio" name="rank" required <?php if (isset($rank) && $rank==1) echo "checked";?> value=1>Bad
        <button style="float:right" class="w3-button w3-black w3-margin-bottom"><i class="fa fa-paper-plane w3-margin-right"></i>Send Comment</button>
      </form><br>
      <hr class="w3-opacity">
      <h4>Other people's comments</h4>
      
      <table style="width: 100%" border="1px">
        <thead>
          <tr>
            <th>User</th>
            <th>Comment</th>
            <th>Time</th>
          </tr>
        </thead> 
        <tbody>
        <?php
        if($result2= mysqli_query($link, $sql2)){
          while($rs = $result2->fetch_assoc()) {
            ?>
            <tr>
              <td width='10%'><?php echo $rs['user']?></td>
              <td width='76%'><?php echo $rs['comment']?></td>
              <td width='10%'><?php echo $rs['comment_time']?></td>
            </tr>
        <?php
          }
        }
        else {
          echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        ?>
        </tbody>
      </table>
    </div>
<!-- End page content -->

    <script>
      // Script to open and close sidebar
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
            location.href = '../?search='+value;
        }
      }
    </script>

</body>
</html>
