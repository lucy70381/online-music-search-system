<?php session_start();?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="favicon.ico">
		<style>
			.error {color: #FF0000;}
			h1 {font-size: 55px; color:yellow; font-family: 'Fredericka the Great', cursive;}
			body,h3,h4,h5,h6 {font-family: 'Raleway', sans-serif;}
		</style>
		<meta charset="utf-8">
		<title>Welcome</title>
		<style>
			body
			{
				font-size: 25px;
				background-image:url("image/welcome.png");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center;
				background-size: cover;
    
			}

			div
			{
				width: 16em;
				height: 350px;
				position: absolute;
				top: 50%;
				left: 50%;
				margin: -175px 0 0 -8em;
			}
		</style>
	</head>
	<body> 
		<?php
			if($_SESSION['success'] == true){
				echo "<script>alert('點擊後跳轉頁面');</script> "; 
				echo "<meta http-equiv=REFRESH CONTENT=3;url=./index.php>";
				
			}
			else{
				echo "<script>alert('尚未登入 請先登入');</script> "; 
				echo "<meta http-equiv=REFRESH CONTENT=1;url=login.php>";
			}
		?>
		<!-- <?php 
			//$id = $_GET["user"];
		?>  -->
			
	</body>
</html>