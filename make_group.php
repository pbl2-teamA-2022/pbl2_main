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
      var group_password = document.form1.group_password.value;;
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
  </header><br>
  <div class="contener">
    <div align="center">
      <div style="padding: 50px; height: 400px; width: 300px; border: 1px solid #00b4d8;">
        <h1 align="center">
          <font color="#0096c7">
            グループ作成
          </font>
        </h1>
        <form name="form1" method="POST" action="make_group1.php" onsubmit="return check()">
          <font class="">グループ名</font><br>
          <input type="text" name="group_name" value="" placeholder="グループ名">
          <br>
          <font class="">パスワード</font><br>
          <input type="password" name="group_password" value="" placeholder="パスワード">
          <br><br>
          <br><br>
          <input type="submit" name="submit" value="グループ作成">
          &nbsp;&nbsp;&nbsp;&nbsp;
          <input type="button" value="戻る" onClick="location.href='home.php'">
        </form>
      </div>
    </div>
  </div>
</body>