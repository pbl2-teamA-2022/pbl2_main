<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <title>交通費計算システム</title>
  <link rel="stylesheet" href="group.css">
  <script>
    function check() {
      //処理
      var group_name = document.form1.group_name.value;
      var group_password = document.form1.group_password.value;
      //alert(group_name);
      if (group_name == "") {
        alert("グループ名を入力してください");
        return false;
      }
      else if (group_password == "") {
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
            グループ参加
          </font>
        </h1>
        <br>
        <form name="form1" method="POST" action="join_group1.php" onsubmit="return check()">
          <font class="">グループ名</font><br>
          <input type="text" pattern="[^,/]+" name="group_name" value="" placeholder="グループ名" required>
          <br>
          <font class="">パスワード</font><br>
          <input type="password" pattern="[0-9A-Za-z]+" name="group_password" value="" placeholder="パスワード" required>
          <br>
          <br>
          <br>
          <br>
          <input type="submit" name="submit" value="グループに参加">
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" value="homeに戻る" onClick="location.href='home.php'">
        </form>
      </div>
      <br>
    </div>
  </div>
</body>
