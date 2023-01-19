<!DOCTYPE html>
<html lang="ja">
<head>
  <title>新規登録|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="stylesheet" href="group.css">

  <script type="text/javascript">
  function check() {
    var user_name = document.form.user_name.value;
    var email = document.form.email.value;
    var password = document.form.password.value;
    var passcheck = document.form.passcheck.value;

    if (user_name == "") {
      alert("ユーザー名を入力してください");
      return false;
    }
    else if (email == "") {
      alert("メールアドレスを入力してください");
      return false;
    }
    else if (password == "") {
      alert("パスワードを入力してください");
      return false;
    }
    else if (password　!= passcheck) {
      alert("パスワードが一致しません");
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
      <div style="padding:50px; height:400px; width:300px; border:1px solid #00b4d8;">
        <h1 align="center">
          <font color="#0096c7">
            新規登録
          </font>
        </h1>
        <br>
        <br>
        <br>
        <form name="form" method="POST" action="add_user_submit.php" onsubmit="return check()">
          <font class="" style="padding-right: 100px;">ユーザー名</font><br>
          <input type="text" name="user_name" value="" placeholder="ユーザー名" require>
          <br>
          <font class="" style="padding-right: 70px;">メールアドレス</font><br>
          <input type="text" name="email" value="" placeholder="メールアドレス" require>
          <br>
          <font class="" style="padding-right: 100px;">パスワード</font><br>
          <input type="password" name="password" value="" placeholder="パスワード" require>
          <br>
          <font class="" style="padding-right: 50px;">パスワード(確認)</font><br>
          <input type="password" name="passcheck" value="" placeholder="パスワード(確認)" require>
          <br>
          <br>
          <input type="button" onclick="location.href='./login.php'" value="戻る">
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="submit" value="登録">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
