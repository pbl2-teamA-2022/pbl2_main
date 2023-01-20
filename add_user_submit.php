<!DOCTYPE html>
<html lang="ja">
<head>
  <title>登録完了|交通費計算システム</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            新規登録
          </font>
        </h1>
        <br>
        <?php
        function check_email($email){
          //読み込みモードでファイルを開く
          $fp = fopen("text/user_pass.txt", "r");
          //ファイルを１行ずつ取得する
          while($line = fgets($fp)){
            $trim = rtrim($line);
            list($_email,$_password,$_user_name) = explode(",",$trim,3);
            //echo($_email.$_password.$_user_name);
            if($email == $_email){
              echo ("<h3>入力されたメールアドレスは<br>既に登録されています。</h3>");
              echo ("<br><br><br>");
              echo ("<input type=\"button\" value=\"新規登録画面へ\" onClick=\"location.href='add_user.php'\">");
              echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
              echo ("<input type=\"button\" value=\"ログイン画面へ\" onClick=\"location.href='index.php'\">");
              fclose($fp);
              return false;
            }
          }
          fclose($fp);
          return true;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $passcheck = $_POST['passcheck'];
        $user_name = $_POST['user_name'];


        if(!strpos($email, '@')){
          echo ("<h3>メールアドレスが正しい形で<br>入力されていません。</h3>");
          echo ("<br><br><br>");
          echo ("<input type=\"button\" value=\"新規登録画面へ\" onClick=\"location.href='add_user.php'\">");
        }
        else{
          if(check_email($email)){
            $add = $email.','.$password.','.$user_name."\n";
            $fp = fopen("text/user_pass.txt", "a");
            fwrite($fp, $add);
            fclose($fp);
            echo ("<h3>新規アカウントの登録が<br>完了しました。</h3>");
            echo ("<h3>ログイン画面でログイン<br>してください。</h3>");
            echo ("<br>");
            echo ("<input type=\"button\" value=\"ログイン画面へ\" onClick=\"location.href='index.php'\">");
          }
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
