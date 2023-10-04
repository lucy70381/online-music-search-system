<?php
	session_start();
	require_once("../connect_database.php");
	date_default_timezone_set('Asia/Taipei');
	if($_SESSION['success'] != true){
      sleep(2);
      echo "<script>alert('請登入會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
    }
    else if($_SESSION['role']==0){
      sleep(2);
      echo "<script>alert('權限不足 請升級會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=0;url=upgrade.php>";
    }
    else{
			$user=$_SESSION['user'];
			$upload_folder = "Profile_picture";
			if(!is_dir($upload_folder) && !is_link($upload_folder)){ 
				if(!is_file($upload_folder)) { 
					mkdir($upload_folder); 
				}
			}
			if ($_FILES["file"]["error"] > 0){
				echo "Error: " . $_FILES["file"]["error"];
			}else{/*
				echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
				echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
				echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
				echo "暫存名稱: " . $_FILES["file"]["tmp_name"]."<br>";*/

				if($_FILES["file"]["type"]!="image/jpeg" && $_FILES["file"]["type"]!="image/png") {
					echo "<script>alert('圖片格式不正確！');</script> "; 
					if($_FILES["file"]["size"]>1024000)
						echo "<script>alert('圖片容量太大！');</script> "; 
				}
				else{
					if($_FILES["file"]["type"]=="image/jpeg")
						$file=$user.".jpg";
					else if($_FILES["file"]["type"]=="image/png")
						$file=$user.".png";
					if (copy($_FILES["file"]["tmp_name"],$upload_folder.'/'.$file)){
						$sql = "UPDATE Account SET picture= '$file' WHERE id = '$user'";
						if (mysqli_query($link, $sql) == TRUE) {
							$_SESSION['pic']=$file;
							echo "<script>alert('檔案上傳成功');</script> "; 
							mysqli_close($link);
							echo "<meta http-equiv=REFRESH CONTENT=1;url=edit_profile.php>";
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					}
					else {
						echo "<script>alert('檔案上傳失敗');</script> "; 
						echo "<script>window.close();</script>";
					}
				}
			}
    }
?>