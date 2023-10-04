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
      echo "<meta http-equiv=REFRESH CONTENT=1;url=overview.php>";
    }
	$upload_folder = "upload/".$_SESSION['user'];
	if(!empty($_POST['checkbox'])){
		$check=$_POST['checkbox'];
		foreach($check as $value){
			$sql="DELETE FROM File_Manager WHERE file_name='$value'";
				if (mysqli_query($link, $sql) == TRUE) {
					if(file_exists($upload_folder.'/'.$value)){
						unlink($upload_folder.'/'.$value);
					}	
			} 
			else echo 'Error: '.$sql;
		}
		mysqli_close($link);
		echo "<script>alert('檔案刪除成功');</script> "; 
		echo "<meta http-equiv=REFRESH CONTENT=0;url=file_manager.php>";
	}
    else if(!empty($_POST['delete'])){
			$delete=$_POST['delete'];
			foreach($delete as $value){
				$sql="DELETE FROM Account WHERE id='$value'";
				if (mysqli_query($link, $sql) == TRUE) {
				} 
				else echo 'Error: '.$sql;
			}
			mysqli_close($link);
			echo "<script>alert('會員刪除成功');</script> "; 
			echo "<meta http-equiv=REFRESH CONTENT=0;url=manage_member.php>";
    }
    else if(!empty($_POST['deleteNo'])){
			$deleteNo=$_POST['deleteNo'];
			foreach($deleteNo as $value){
			$sql="DELETE FROM Opinion WHERE No=$value";
				if (mysqli_query($link, $sql) == TRUE) {
				} 
				else echo 'Error: '.$sql;
			}
			mysqli_close($link);
			echo "<script>alert('意見刪除成功');</script> "; 
			echo "<meta http-equiv=REFRESH CONTENT=0;url=opinion.php>";
		}
		else{
			echo "<script>alert('無勾選任何資料');</script> "; 
			echo "<script>history.go(-1)</script>";
		}
?>