<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])==true){
  setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>

<!DOCTYPE html>
<html  lang="ja">
<head>
  <meta charset="UTF-8"/>
  <title>ログアウト|交通費計算システム</title>

  <style>
  body {
    background-image: url(mizuirohaikeiy3.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
  .font1{
    font-size: 30px;
    font-weight: bold;
  }
  .font2{
    font-size: 15px;
    padding-right: 100px;
  }
  </style>
</head>

<body>
  <div align="center">
    <br>
    <br>
    <br>
    <br>
    <br>
    <font class="font1">Goal-achieving support app</font><br>
    <br>
    <div style="padding: 50px; height: 400px; width: 300px; border: 1px solid #00b4d8;">
      <h1 align="center">
        <font color="#0096c7">
          ログアウト完了<br>&nbsp;
        </font>
      </h1>
      <br>
      <br>
      <br>
      <br>
      <a href='login.php'>ログインページに戻る</a>
    </div>
  </div>
</body>
</html>
