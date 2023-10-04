<?php    // 資料庫設定

    $servername = "";    // 資料庫位置

    $dbname = "";         // 資料庫名稱

    $username = "";           // 資料庫管理者帳號

    $password = "";               // 資料庫管理者密碼

    $link = mysqli_connect("$servername", "$username", "$password");

    if(!$link) die("無法對資料庫連線");      // 對資料庫連線

    mysqli_query($link,"SET NAMES utf8");    // 資料庫連線採 UTF8

    if (!@mysqli_select_db($link,$dbname)) { die("Connection failed"); }    // 選擇資料庫

?>