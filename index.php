<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ログイン|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="group.css">
  <script type="text/javascript">
  function check() {
    var email = document.form.email.value;
    var password = document.form.password.value;

    if (email == "") {
      alert("メールアドレスを入力してください");
      return false;
    }
    else if (password == "") {
      alert("パスワードを入力してください");
      return false;
    }
    else {
      return true;
    }
  }
  </script>
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
            ログイン画面
          </font>
        </h1>
        <br>
        <br>
        <form name="form" method="POST" action="login_submit.php" onsubmit="return check()">
          <font class="" style="padding-right: 70px;">メールアドレス</font><br>
          <input type="text" name="email" value="" placeholder="メールアドレス" require>
          <br>
          <font class="" style="padding-right: 100px;">パスワード</font><br>
          <input type="password" name="password" value="" placeholder="パスワード" require>
          <br>
          <br>
          <br>
          <input type="submit" name="submit" value="ログイン">
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" value="新規登録" onClick="location.href='add_user.php'">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
