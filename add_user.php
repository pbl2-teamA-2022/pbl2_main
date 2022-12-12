<!DOCTYPE html>
<html lang="ja">
<head>
  <title>新規登録|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
  </style>
</head>

<body>
  <div align="center">
    <br>
    <br>
    <br>
    <br>
    <br>
    <font class="font1">交通費計算システム</font><br>
    <br>
    <div style="padding: 50px; height: 400px; width: 300px; border: 1px solid #00b4d8;">
      <h1 align="center">
        <font color="#0096c7">
          新規登録
        </font>
      </h1>
      <br>
      <br>
      <br>
      <form action="login_submit.php" method="POST">
        <font class="" style="padding-right: 70px;">メールアドレス</font><br>
        <input type="text" name="email" value="" placeholder="メールアドレス" require>
        <br>
        <font class="" style="padding-right: 100px;">パスワード</font><br>
        <input type="password" name="password" value="" placeholder="パスワード" require>
        <br>
        <font class="" style="padding-right: 100px;">パスワード(確認)</font><br>
        <input type="password" name="passcheck" value="" placeholder="パスワード(確認)" require>
        <br>
        <br>
        <input type="button" onclick="location.href='./login.php'" value="戻る">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" value="登録">
        
        </form>
    </div>
  </div>
</body>
</html>
