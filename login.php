<?php
	session_start();
	if(isset($_SESSION['success'])){
		if($_SESSION['success'] == true){
			sleep(5);
			echo "<script>alert('已登入 點擊後跳轉頁面');</script> "; 
			echo "<meta http-equiv=REFRESH CONTENT=1;url=../>";
		}
	}
	else{
		$_SESSION['success'] = false;
	}
	require_once("./connect_database.php");
?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
		<link href="https://fonts.googleapis.com/css?family=Lobster|Pinyon+Script" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Lobster|Pinyon+Script" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			.error {color: #FF0000;}
			h1 {font-size: 55px; color:yellow; font-family: 'Fredericka the Great', cursive;}
			body,h3,h4,h5,h6 {font-family: 'Raleway', sans-serif;}
		</style>
		<meta charset="utf-8">
		<title>Login</title>
		<style>
			body
			{
				font-size: 25px;
						background-image:url("image/windows7.jpg");
						background-repeat: no-repeat;
						background-attachment: fixed;
						background-position: center;
						background-size: cover;
			}

			div
			{
				width: 18em;
				height: 17.5em;
				position: absolute;
				top: 50%;
				left: 50%;
				margin: -8.75em 0 0 -9em;
			}
		</style>
		<audio id="bgMusic">
			<source src="Windows Error.wav" type="audio/wav">
		</audio>
	</head>
	<body>  
		<?php
			// define variables and set to empty values
			$idErr = $passwordErr = "";
			$id = $password = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$id = test_input($_POST["id"]);
				// check if name only contains letters and whitespace
				if (!preg_match(" /^[a-zA-Z0-9]*$/",$id)) {
					$id="";
					$idErr = "<br>Only letters and number allowed"; 
				}
			
				$password = test_input($_POST["password"]);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[a-zA-Z0-9]*$/",$password)) {
					$password="";
					$passwordErr = "<br>Only letters and number allowed"; 
				}
				
				if (!empty($id) && !empty($password)){
					$sql = "SELECT id, password,email,cellphone,gender,role,picture
							FROM Account
							WHERE id='$id' AND password='$password'";
					//$result = mysqli_query($link, $sql);
					if ($result= mysqli_query($link, $sql)) {
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								$_SESSION['success'] = true;
								$_SESSION['user']=$row["id"];
								$_SESSION['role']=$row["role"];
								$_SESSION['pic']=$row["picture"];
								echo "<script>alert(".$id."' 用戶登入成功');</script> "; 
								echo "<meta http-equiv=REFRESH CONTENT=1;url=welcome.php>";
								exit;
								 //echo " 用戶已登入<br>Email: " . $row["email"].  "<br>Cellphone: " . $row["cellphone"].  "<br>Gender: " . $row["gender"]. "<br>";
							}
						}
						else {
							echo "<script>document.getElementById('bgMusic').play();</script>";
							echo "<script>alert('帳號或密碼有誤');</script> "; 
							echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
							exit;
							//echo "Error: " . $sql . "<br>" . $conn->error;
						}
						mysqli_close($link);
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
		<div>
			<div style="text-align:center">
				<h1>Login</h1>
				<p></p>
				<form style="font-family: 'Lobster', cursive;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="text" name="id" size="25" placeholder="Username" required value="<?php echo $id;?>">
					<span class="error"><?php echo $idErr;?></span><br><br>
					<input type="password" name="password" size="25" placeholder="Password" required value="<?php echo $password;?>">
					<span class="error"><?php echo $passwordErr;?></span><br><br>
					<button class="w3-button w3-margin-bottom w3-padding" style="float: right;color:white;">Log in</button><br><br>
						<div style="text-align:center;font-family:'Raleway', sans-serif;font-size: 20px;"">
							Don't have an account?
							<a href="register.php" class="w3-button w3-margin-bottom w3-padding" style='color:green;'>Sign up</a>
						</div>
				</form>
		</div>
	</body>
</html>