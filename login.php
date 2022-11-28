<!DOCTYPE html>
<html lang="ja">
<head>
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
          ログイン画面
        </font>
      </h1>
      <br>
      <br>
      <br>
      <form action="login_submit.php" method="POST">
        <font class="" style="padding-right: 70px;">メールアドレス</font><br>
        <input type="text" name="email" value="" placeholder="メールアドレス">
        <br>
        <font class="" style="padding-right: 100px;">パスワード</font><br>
        <input type="password" name="password" value="" placeholder="パスワード">
        <br>
        <br>
        <br>
        <input type="submit" name="submit" value="ログイン">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="新規登録" onClick="location.href='signup.php'">
      </form>
    </div>
  </div>
</body>
</html>
