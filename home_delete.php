<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <meta charset="UTF-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <title>交通費計算システム</title>
  <link rel="stylesheet" href="group.css">
  <script type="text/javascript" src="zepto.min.js"></script>
</head>

<body>
  <header>
    <h4 class="title">削除確認画面&emsp;&emsp;</h4>
    <div class="head">
      <?php
      $ID_email = null;
      $ID_password = null;
      session_start();
      $ID = $_SESSION['ID'];
      if ($ID == null) {
        echo ("<b>ログインしてください</b>&emsp;");
        echo ("<input type=\"button\" value=\"ログイン\" onClick=\"location.href='index.php'\"><br>");
      } else {
        list($ID_email, $ID_password) = explode(",", $ID, 2);
        echo ("<input type=\"hidden\" id=\"ID_email\" value=\"" . $ID_email . "\">");
        echo ("<b>" . $ID_email . "</b>でログイン済み&emsp;");
        echo ("<input type=\"button\" value=\"ログアウト\" onClick=\"location.href='logout.php'\"><br>");
      }
      ?>
    </div>
  </header>
  <br>
  <br>
  <div class="contener">
  <?php
  if( $_POST['send'] == '削除' ){
    function delete($server, $ID_email, $group, $text){
      $ans = "削除できませんでした。<br><br>";
      if ($group == "personal") { $file_name = "data_user/" . $ID_email . ".txt";}
      else { $file_name = "data_group/" . $group . ".txt";}

      //行数の総数をカウント
      $fp = fopen($file_name, 'r'); // fopenでファイルを開く
      for( $count = 0; fgets( $fp ); $count++ );
      fclose($fp);

      //ファイルの内容を配列に格納する
      $file_data = file($file_name);

      for($i=0; $i<=$count; $i++){
        $trim = rtrim($file_data[$i]);
        if($trim == $text){
          unset($file_data[$i]);
          $ans = "削除しました。<br><br>";
        }
      }
      file_put_contents($file_name, $file_data);
      echo ($ans);
    }


    function check_user($server, $ID_email, $name, $group, $text){
      if($ID_email == $name){
        //echo ("ユーザー一致<br>");
        delete($server, $ID_email, $group, $text);
        return true;
      }
      else{
        //echo ("ユーザー不一致<br>");
        return false;
      }
    }

    function check_admin($server, $ID_email, $group, $text){
      $f = fopen($server."/text/group_pass.txt", "r"); //読み込みモードでファイルを開く
      while($line = fgets($f)){ //ファイルを１行ずつ取得する
        $trim = rtrim($line);
        list($_group, $_group_password, $_admin, $_member) = explode(",",$trim,4);
        if($group == $_group){
          if($ID_email == $_admin){
            //echo ("管理人です<br>");
            delete($server, $ID_email, $group, $text);
            fclose($f);
            return true;
          }
          else{
            //echo ("管理人ではないです<br>");
            fclose($f);
            return false;
          }
        }
      }
      echo ("グループが存在しません。<br><br>");
      fclose($f);
    }


    //本文
    $server = $_POST['server'];
    $name = $_POST['name'];
    $group = $_POST['group'];
    $text = $_POST['text'];

    if($group == "personal"){
      if(!check_user($server, $ID_email, $name, $group, $text)){
        echo ("削除する権限がありません。<br><br>");
      }
    }
    else{
      if(!check_user($server, $ID_email, $name, $group, $text)){
        if(!check_admin($server, $ID_email, $group, $text)){
          echo ("削除する権限がありません。<br><br>");
        }
      }
    }
  }

  else{
    $server = $_POST['server'];
    $date = $_POST['date'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $start = $_POST['start'];
    $goal = $_POST['goal'];
    $rkyori = $_POST['rkyori'];
    $fee = $_POST['fee'];
    $times = $_POST['times'];
    $memo = $_POST['memo'];
    $name = $_POST['name'];
    $group = $_POST['group'];

    $text = $date.",".$start_date.",".$end_date.",".$start.",".$goal.",".$rkyori.",".$fee.",".$times.",".$memo.",".$name;

    $date = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
    $start_date = htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8');
    $end_date = htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8');
    $start = htmlspecialchars($start, ENT_QUOTES, 'UTF-8');
    $goal = htmlspecialchars($goal, ENT_QUOTES, 'UTF-8');
    $rkyori = htmlspecialchars($rkyori, ENT_QUOTES, 'UTF-8');
    $fee = htmlspecialchars($fee, ENT_QUOTES, 'UTF-8');
    $times = htmlspecialchars($times, ENT_QUOTES, 'UTF-8');
    $memo = htmlspecialchars($memo, ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $group = htmlspecialchars($group, ENT_QUOTES, 'UTF-8');

    //echo ($text."<br>");
    echo ("名前&emsp;：" . $name . "<br>");
    echo ("グループ：" . $group . "<br>");
    echo ("登録日：" . $date . "<br><br>");
    echo ("出発地点：" . $start . "<br>");
    echo ("目的地点：" . $goal . "<br>");
    echo ("走行距離：" . $rkyori . "<br>");
    echo ("料金&emsp;：" . $rkyori*$fee . "円(走行距離×ガソリン代(" . $fee . "円/m))<br>");
    echo ("開始日：" . $start_date . "<br>");
    echo ("終了日：" . $end_date . "<br>");
    echo ("回数&emsp;：" . $times . "回<br>");
    echo ("メモ&emsp;：" . $memo . "<br>");


    echo ("<form action=\"home_delete.php\" method=\"POST\">");
    echo ("<input type=\"hidden\" name=\"server\" value=\"$server\">");
    echo ("<input type=\"hidden\" name=\"name\" value=\"$name\">");
    echo ("<input type=\"hidden\" name=\"group\" value=\"$group\">");
    echo ("<input type=\"hidden\" name=\"text\" value=\"$text\">");
    echo ("<br>");

    session_start();
    $ID = $_SESSION['ID'];
    if ($ID != null) {
      echo ("<input type=\"submit\" name=\"send\" value=\"削除\"></form><br>");
    }
  }
  echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\"><br>");
  ?>
  <br>
  <br>
  </div>
</body>
</html>
