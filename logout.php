<?php
	session_start();
	session_unset();
	session_destroy();
?>
<html>
	<head>
		<link rel="shortcut icon" href="favicon.ico">
		<meta charset="utf-8">
		<title>Logout</title>
		<style>
			body
			{
				font-size: 25px;
				background-image:url("image/logout.png");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position: center;
				background-size: cover;
    
			}
		</style>
	</head>
	<body> 
		<?php
			sleep(2);
			echo "<script>alert('點擊後跳轉至首頁');</script> "; 
			echo "<meta http-equiv=REFRESH CONTENT=3;url=./index.php>";
		?>
	</body>
</html>