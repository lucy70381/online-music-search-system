<?php
  session_start();
  if($_SESSION['success'] != true){
    sleep(2);
    echo "<script>alert('請登入會員');</script> "; 
    echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
  }
  $user=$_SESSION['user'];
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta charset="utf-8">
		<title>Upgrade</title>
	</head>
	<body>  
		<div class="w3-row-padding" style="margin:8%">	      
      <div class="w3-half w3-margin-bottom">
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
            <a href="upgrade-pre.php?id=<?php echo $user?>&code=">
              <button class="w3-button w3-teal w3-padding-large w3-hover-black">Upgrade</button></a>
            </li>
          </ul>
      </div>
      
      <div class="w3-half">
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
    <div style="text-align:center">
      <button class="w3-button w3-teal w3-padding-large w3-hover-black" onclick="history.go(-2)">Back</button> or 
      <button class="w3-button w3-teal w3-padding-large w3-hover-black" onclick="window.close()">Close</button>
    </div>
	</body>
</html>