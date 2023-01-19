<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ログイン|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="group.css">
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
        <?php
        function LoginError(){
          echo ("<h3>メールアドレスもしくは<br>パスワードが違います</h3>");
          echo ("<br><br>");
          echo ("<input type=\"button\" value=\"ログイン画面へ\" onClick=\"location.href='login.php'\">");
        }

        LoginCheck();
        function LoginCheck(){
          session_start();
          $email = $_POST['email'];
          $password = $_POST['password'];
          $ID = $email.','.$password;

          //読み込みモードでファイルを開く
          $fp = fopen("text/user_pass.txt", "r");
          //ファイルを１行ずつ取得する
          while($line = fgets($fp)){
            $trim = rtrim($line);
            list($_email,$_password,$_user_name) = explode(",",$trim,3);
            if($email == $_email && $password == $_password){
              fclose($fp);
              $_SESSION['ID'] = $ID;
              header('Location: home.php');
              return;
            }
          }
          LoginError();
          fclose($fp);
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
