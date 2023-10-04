<?php 
	session_start();
	require_once("../connect_database.php");
	date_default_timezone_set('Asia/Taipei');
	if($_SESSION['success'] != true){
      sleep(2);
      echo "<script>alert('請登入會員');</script> "; 
      echo "<meta http-equiv=REFRESH CONTENT=1;url=../login.php>";
  }
  else if($_SESSION['role']!=0){
    sleep(2);
    echo "<script>alert('您不需升級');</script>"; 
    echo "<meta http-equiv=REFRESH CONTENT=1;url=overview.php>";
  }
  else{
    $id=$_GET['id'];
    $code=$_GET['code'];
    if($id!=""&&$code=="I3360B"){
      $sql="UPDATE Account SET role=1 WHERE id='$id'";
      if (mysqli_query($link, $sql) == TRUE) {
        echo "<script>alert('成功升級會員');</script>"; 
        $_SESSION['role']=1;
      }
      else
        echo "<script>alert('資料有誤');</script>"; 
      echo "<meta http-equiv=REFRESH CONTENT=0;url=overview.php>";
    }
    else{
      echo "請在網址末端輸入通關密碼，升級付費會員"; 
    }
  }
	mysqli_close($link); 
?>