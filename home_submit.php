<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
  <title>交通費計算システム</title>
  <script>
  </script>
</head>
<body>
  <h4>交通費計算システム</h4><br>
  <?php
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  $ID = $_SESSION['ID'];
  if($ID == null){
    echo ("ログインし直してください<br>");
  }
  else{
    list($ID_email,$ID_password) = explode(",",$ID,2);
    //echo($_email."でログイン済み<br>");

    if( $_POST['send'] == '確認' ){
      $date = date("Y/m/d H:i:s");   //現在時間の取得
      $start = $_POST['start'];
      $goal = $_POST['goal'];
      $rkyori = $_POST['rkyori'];
      $fee = $_POST['fee'];
      $times = $_POST['times'];
      $group = $_POST['group'];
      $memo = $_POST['memo'];

      $start_year = $_POST['start_year'];
      $start_month = $_POST['start_month'];
      $start_day = $_POST['start_day'];
      $start_date = $start_year."/".$start_month."/".$start_day;

      $end_year = $_POST['end_year'];
      $end_month = $_POST['end_month'];
      $end_day = $_POST['end_day'];
      $end_date = $end_year."/".$end_month."/".$end_day;

      if($group == "personal" ){ //個人ファイルに記入
        $filename = "data_user/".$ID_email.".txt";
      }
      else{ //グループファイルに記入
        $filename = "data_group/".$group.".txt";
      }
      $fp = fopen($filename, 'a'); // fopenでファイルを開く
      fwrite($fp,$date.",".$start_date.",".$end_date.",".$start.",".$goal.",".$rkyori.",".$fee.",".$times.",".$memo.",".$ID_email."\n"); // fwriteで文字列を書き込む
      fclose($fp); // ファイルを閉じる

      echo("記録が完了しました。<br>");
    }

    else{
      $start = $_POST['start'];
      $goal = $_POST['goal'];
      $rkyori = $_POST['rkyori'];
      $fee = $_POST['fee'];
      $money = $_POST['money'];
      $times = $_POST['times'];
      $group = $_POST['group'];
      $memo = $_POST['memo'];

      $start_year = $_POST['start_year'];
      $start_month = $_POST['start_month'];
      $start_day = $_POST['start_day'];
      $start_date = $start_year."/".$start_month."/".$start_day;
      $end_year = $_POST['end_year'];
      $end_month = $_POST['end_month'];
      $end_day = $_POST['end_day'];
      $end_date = $end_year."/".$end_month."/".$end_day;

      echo("出発地点：".$start."<br>");
      echo("目的地点：".$goal."<br>");
      echo("走行距離：".$rkyori."<br>");
      echo("料金&emsp;：".$money."円(走行距離×ガソリン代(".$fee."円/m))<br>");
      echo("開始日：".$start_date."<br>");
      echo("終了日：".$end_date."<br>");
      echo("回数&emsp;：".$times."回<br>");
      echo("グループ：".$group."<br>");
      echo("メモ&emsp;：".$memo."<br>");

      echo '<form action="home_submit.php" method="POST">'."\n";
      foreach($_POST as $key => $val){
        $_val = htmlspecialchars($val);
        //echo "$key = $_val<br>\n";
        echo "<input type=\"hidden\" name=\"$key\" value=\"$_val\">\n";
      }
      echo '<br><input type="submit" name="send" value="確認"></form>'."\n";
    }
  }
  ?>
  <input type="button" value="homeに戻る" onClick="location.href='home.php'">
</body>
</html>
