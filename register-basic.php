<?php
	require_once("connect_database.php");
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
			.error {color: #FF0000; font-size: 20px; }
			h1 {font-size: 55px; color:yellow; font-family: 'Fredericka the Great', cursive;}
			body,h3,h4,h5,h6 {font-family: 'Raleway', sans-serif;}
		</style>
		<meta charset="utf-8">
		<title>Register</title>
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
				width: 16em;
				height: 600px;
				position: absolute;
				top: 50%;
				left: 50%;
				margin: -300px 0 0 -8em;
			}
		</style>
	</head>
	<body>  

		<?php
			// define variables and set to empty values
			$idErr = $emailErr = $passwordErr = $cellphoneErr = $genderErr = "";
			$id = $email = $password = $cellphone = $gender = "";

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
				if (!empty($id) && !empty($password) && !empty($email) && !empty($cellphone) && !empty($gender)){
					$sql = "INSERT INTO Account (id, password,email,cellphone,gender,role,picture)
						VALUES ('$id', '$password', '$email', '$cellphone', '$gender',0,'default.png')";
					if (mysqli_query($link, $sql) == TRUE) {
						echo "<script>alert('已成功加入會員');</script> "; 
						echo "<meta http-equiv=REFRESH CONTENT=1;url=login.php>";
						mysqli_close($link);
					} else {
						echo "<script>alert('此用戶名已被註冊');</script> ";
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
		<div style="text-align:center">
			<h1>Register</h1>
			<p></p>
			<form style="font-family: 'Lobster', cursive;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
				<input type="text" name="id" size="25" placeholder="Username" required value="<?php echo $id;?>">
				<span class="error"><?php echo $idErr;?></span><br><br>
				<input type="password" name="password" size="25" placeholder="Password" required value="<?php echo $password;?>">
				<span class="error"><?php echo $passwordErr;?></span><br><br>
				<input type="text" name="email" size="25" placeholder="E-mail" required value="<?php echo $email;?>">
				<span class="error"><?php echo $emailErr;?></span><br><br>
				<input type="tel" name="cellphone" size="25" placeholder="Cellphone" required value="<?php echo $cellphone;?>">
				<span class="error"><?php echo $cellphoneErr;?></span><br><br>
				<span style="font-size:20px; font-family: 'Raleway', sans-serif;">Gender:
				<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> required value="female">Female
				<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> required value="male">Male</span>
				<span class="error"><?php echo $genderErr;?></span>
				<button class="w3-button w3-margin-bottom w3-padding" style='float: right;color:white'>Sign up</button>
			</form>
		</div>
	</body>
</html>