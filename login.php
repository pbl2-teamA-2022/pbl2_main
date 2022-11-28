<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<body>
  交通費計算システム<br>
  ログイン画面<br>
  <form action="login_submit.php" method="POST">
    メールアドレス<br>
    <input type="text" name="email" value="" placeholder="メールアドレス"><br>
    パスワード<br>
    <input type="password" name="password" value="" placeholder="パスワード"><br>
    <input type="submit" name="submit" value="ログイン">
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" value="新規登録" onClick="location.href='signup.php'">
  </form>
</body>
</html>
