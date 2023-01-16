<?php 
    //php操作
    /*
    メールアドレスが正しい形か確認(@が入力されているか)
    ↓
    メールアドレスがすでに登録されていないか確認
    ↓
    登録
    */

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passcheck = $_POST['passcheck'];
    function passCheck(){
      echo '<h1 align="center">
      <font color="#0096c7">
        エラー
      </font>
    </h1>
    <br>
    <br>
    <br>
    <h3>パスワードが一致していません。</h3>
    <input type="button" value="戻る" onClick="history.back()">';
      exit;
    }
    function console_log( $data ){
            echo '<script>';
            echo 'console.log('. json_encode( $data ) .')';
            echo '</script>';
        }

    function wrongAddress(){
      echo '<body>
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
          エラー
        </font>
      </h1>
      <br>
      <br>
      <br>
      <h3>メールアドレスが正しい形で入力されていません。</h3>
      <input type="button" value="戻る" onClick="history.back()">
          </form>
        </div>
      </div>
    </body>';
      exit;
    }
    function sameAddress(){
      echo '<body>
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
          エラー
        </font>
      </h1>
      <br>
      <br>
      <br>
      <h3>入力されたアドレスは既に登録されています。</h3>
      <input type="button" value="戻る" onClick="history.back()">
          </form>
        </div>
      </div>
    </body>';
      exit;
    }
    if($password != $passcheck){
      passCheck();
    }
    if(!strpos($email, '@')){
      wrongAddress();
      exit;
    }
    $fp = fopen("text/user_pass.txt", "r");
    //ファイルを１行ずつ取得する
    while($line = fgets($fp)){
      $trim = rtrim($line);
      //console_log($trim);

      list($_email,$_password,$_user_name,$_group) = explode(",",$trim,4);
      if($_email == $email){
        sameAddress();
        exit;
      }
      
    }
    fclose($fp);
    $_add = $email.','.$password.','.$username.",0\n";

    $fp = fopen("text/user_pass.txt", "a");
    fwrite($fp, $_add);
    fclose($fp);
    

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title>登録完了|交通費計算システム</title>
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
          新規登録完了
        </font>
      </h1>
      <br>
      <br>
      <br>
      <h3>新規アカウントの登録が完了しました。</h3>
      <h4>ログイン画面でログインしてください。</h4>
        <input type="button" value="ログイン画面へ" onClick="location.href='login.php'">
      </form>
    </div>
  </div>
</body>
</html>