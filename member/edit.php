<?php 
	session_start();
	require_once("../connect_database.php");
	date_default_timezone_set('Asia/Taipei');
	if($_SESSION['success'] != true){
      sleep(2);
      echo "<script>alert('請登入會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
  }
  else if($_SESSION['role']!=2){
    sleep(2);
    echo "<script>alert('權限不足 僅有管理員可進入');</script>"; 
    echo "<meta http-equiv=REFRESH CONTENT=1;url=overview.php>";
  }
  else{
    $id=$_GET['id'];
    $role=$_GET['role'];
    $No=$_GET['No'];
    $state=$_GET['state'];
    if($id!=""&&$role!=""){
      $sql="UPDATE Account SET role=$role WHERE id='$id'";
      if (mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('會員資料修改成功');</script>"; 
      }
      else
        echo "<script>alert('資料有誤');</script>"; 
      echo "<meta http-equiv=REFRESH CONTENT=0;url=manage_member.php>";
    }
    else if($No!=""&&$state!=""){
      $sql="UPDATE Opinion SET state=$state WHERE No=$No";
      if (mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('狀態修改成功');</script>"; 
      }
      else
        echo "<script>alert('資料有誤');</script>";
      echo "<meta http-equiv=REFRESH CONTENT=0;url=opinion.php>";
    }
    else{
      echo "<script>alert('資料不齊全');</script>"; 
      echo "<script>history.go(-1)</script>";
    }
  }
	mysqli_close($link); 
?>