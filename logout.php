<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])==true){
  setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>

<!DOCTYPE html>
<html  lang="ja">
<head>
  <meta charset="UTF-8"/>
  <title>ログアウト</title>
</head>

<body>
  ログアウト完了<br>
  <a href='login.php'>ログインページに戻る</a>
</body>
</html>
