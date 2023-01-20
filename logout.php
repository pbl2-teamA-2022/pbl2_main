<!DOCTYPE html>
<html  lang="ja">
<head>
  <title>ログイン|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="group.css">
  <?php
  session_start();
  $_SESSION = array();
  if(isset($_COOKIE[session_name()])==true){
    setcookie(session_name(),'',time()-42000,'/');
  }
  session_destroy();
  ?>
</head>

<body>
  <header>
    <h4 class="title">交通費計算システム&emsp;&emsp;</h4>
  </header>
  <br>
  <div class="contener">
    <div align="center">
      <div style="padding: 50px; height: 400px; width: 300px; border: 1px solid #00b4d8;">
        <h1 align="center">
          <font color="#0096c7">
            ログアウト完了
          </font>
        </h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <input type="button" onclick="location.href='./index.php'" value="ログイン画面へ">
      </div>
    </div>
  </div>
</body>
</html>
