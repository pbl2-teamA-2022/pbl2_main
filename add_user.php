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
        <form name="form" method="POST" action="add_user_submit.php" onsubmit="return check()">
          <font class="" style="padding-right: 100px;">ユーザー名</font><br>
          <input type="text" pattern="[0-9A-Za-z-_.]+" maxlength="64" name="user_name" placeholder="ユーザー名" required>
          <br>
          <font class="" style="padding-right: 70px;">メールアドレス</font><br>
          <input type="email" pattern="[0-9A-Za-z-_.]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="64" name="email" placeholder="メールアドレス" required>
          <br>
          <font class="" style="padding-right: 100px;">パスワード</font><br>
          <input type="password" pattern="[0-9A-Za-z]+" maxlength="64" name="password" placeholder="パスワード" required>
          <br>
          <font class="" style="padding-right: 50px;">パスワード(確認)</font><br>
          <input type="password" pattern="[0-9A-Za-z]+" maxlength="64" name="passcheck" placeholder="パスワード(確認)" required>
          <br>
          <br>
          <input type="button" onclick="location.href='./index.php'" value="戻る">
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="submit" value="登録">
        </form>
      </div>
      <br>
      <div class="box_login">
        <b>条件</b><br>
        ユーザー名&emsp;&emsp;&nbsp;:英数字と「-」(ハイフン)「_」(アンダーバー)「.」(ピリオド)のみ。最大64文字。<br>
        メールアドレス：@より前に「-」「_」「.」以外の記号を含むものは不可。最大64文字。<br>
        パスワード&emsp;&emsp;：英数字のみ。最大64文字。<br>
      </div>
    </div>
  </div>
</body>
</html>
