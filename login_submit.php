<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  交通費計算システム<br>
  ログイン画面<br>
  <?php
  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  function LoginError(){
    echo "メールアドレスもしくはパスワードが違います<br>";
  }

  LoginCheck();
  function LoginCheck(){
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ans = $email.','.$password;
    //echo($ans);

    //読み込みモードでファイルを開く
    $fp = fopen("text/user_pass.txt", "r");
    //ファイルを１行ずつ取得する
    while($line = fgets($fp)){
      $trim = rtrim($line);
      //console_log($trim);

      list($_email,$_password,$_user_name,$_group) = explode(",",$trim,4);
      $_ans = $_email.','.$_password;

      //console_log($ans);
      //console_log($_ans);
      if($_ans == $ans){
        $ID = $ans;
        $_SESSION['ID'] = $ID;
        header('Location: home.php');
        return;
      }
    }
    LoginError();
    fclose($fp);
  }
  ?>
  <input type="button" value="戻る" onClick="location.href='login.php'">
</body>
</html>
