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
    else{
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$no = test_input($_POST["no"]);
			}
			$sql2 = "SELECT album FROM Song WHERE No=$no";
			if($result= mysqli_query($link, $sql2)){
				if($rs = $result->fetch_assoc()) {
					$album=$rs['album'];
				}
			}
		$upload_folder = "../cover";
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
					$file=$album.".jpg";
				else if($_FILES["file"]["type"]=="image/png")
					$file=$album.".png";
				$rfile=str_replace("'","''",$file);
				
				if (copy($_FILES["file"]["tmp_name"],$upload_folder.'/'.$file)){
					$sql = "UPDATE Song SET cover= '$rfile' WHERE No=$no";
					if (mysqli_query($link, $sql) == TRUE) {
						echo "<script>alert('檔案上傳成功');</script> "; 
						mysqli_close($link);
						echo "<meta http-equiv=REFRESH CONTENT=0;url=edit_song_info.php>";
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				}
				else {
					echo "<script>alert('檔案上傳失敗');</script> "; 
				}
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