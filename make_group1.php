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
  session_start();
  $ID = $_SESSION['ID'];
  if($ID == null){
    echo ("ログインし直してください<br>");
  }
  else{
    list($ID_email,$ID_password) = explode(",",$ID,2);
    //echo($_email."でログイン済み<br>");

    $group_name = $_POST['group_name'];
    $group_password = $_POST['group_password'];
    echo("グループ名：".$group_name."<br>");
    echo("パスワード：".$group_password."<br>");

    //同じグループ名がすでに存在するかの確認
    $file_name = "text/group_pass.txt";
    $f = file_get_contents($file_name);
    //echo($f);
    $line = explode("\n", $f);

    $check = 0;
    for($i = 0; $i < count($line); $i++){
      list($group_data0[$i],$group_data1[$i],$group_data2[$i],$group_data3[$i]) = explode(",",$line[$i],4);
      //echo($group_name."=".$group_data0[$i]."<br>");
      if($group_name == $group_data0[$i]){
        $check = 1;
        break;
      }
    }

    if($check == 1){
      echo("すでにそのグループは存在しています。グループ名を変更してください。<br>");
    }
    else if($check == 0){
      //group_pass.txtにグループを追加
      $filename = 'text/group_pass.txt';
      $fp = fopen($filename, 'a'); // fopenでファイルを開く
      fwrite($fp, $group_name.','.$group_password.','.$ID_email.','."\n"); // fwriteで文字列を書き込む
      fclose($fp); // ファイルを閉じる
      //readfile($filename); // ファイルを出力する

      echo("グループが作成されました。<br>");
    }
  }
  ?>
  <input type="button" value="homeに戻る" onClick="location.href='home.php'">
</body>
</html>
