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
      echo "<meta http-equiv=REFRESH CONTENT=1;url=upgrade.php>";
    }
    else{
			$upload_folder = "upload/".$_SESSION['user'];
			if(!is_dir($upload_folder) && !is_link($upload_folder)){ 
				if(!is_file($upload_folder)) { 
					mkdir($upload_folder); 
				}
			}
			if ($_FILES["file"]["error"] > 0){
				echo "Error: " . $_FILES["file"]["error"];
			}else{
				echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
				echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
				echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
				echo "暫存名稱: " . $_FILES["file"]["tmp_name"]."<br>";

				if (file_exists($upload_folder.'/'. $_FILES["file"]["name"])){
					echo "檔案已經存在，請勿重覆上傳相同檔案";
				}
				else{
					if($_FILES["file"]["type"]!="audio/mp3" && $_FILES["file"]["type"]!="audio/wav" && $_FILES["file"]["type"]!="audio/flac" && $_FILES["file"]["type"]!="audio/mpeg") {
						echo "<script>alert('音樂格式不正確');</script> "; 
						if($_FILES["file"]["size"]>1024000)
							echo "<script>alert('音樂容量太大!');</script> "; 
						echo "<script>window.close();</script>";
					}
					else{
						//iconv("utf-8", "big5", "");
						if (move_uploaded_file($_FILES["file"]["tmp_name"],$upload_folder.'/'.$_FILES["file"]["name"])){
							$user=$_SESSION['user'];
							$file=$_FILES["file"]["name"];
							$now=date('Y-m-d H:i:s');
							$sql = "INSERT INTO File_Manager (user, file_name,upload_time)
									VALUES ('$user', '$file','$now')";
							if (mysqli_query($link, $sql) == TRUE) {
								echo "<script>alert('檔案上傳成功');</script> "; 
								echo "<script>window.close();</script>";
								mysqli_close($link);
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
    }
?>