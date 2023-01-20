<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <title>交通費計算システム</title>
  <link rel="stylesheet" href="group.css">
  <script>
  </script>
</head>

<body>
  <header>
    <h4 class="title">交通費計算システム&emsp;&emsp;</h4>
  </header>
  <br>
  <div class="contener">
    <?php
    session_start();
    $ID = $_SESSION['ID'];
    if ($ID != null) {
      list($ID_email, $ID_password) = explode(",", $ID, 2);

      $group_name = $_POST['group_name'];
      $group_password = $_POST['group_password'];
      echo ("グループ名：" . $group_name . "<br>");
      echo ("パスワード：" . $group_password . "<br>");

      $file_name = "text/group_pass.txt";
      $f = file_get_contents($file_name);
      $line = explode("\n", $f);

      $check = 0; //0=グループが存在しない, 1=パスワードが違う, 2=登録を実行, 11=管理人 , 12=メンバー
      for ($i = 0; $i < count($line); $i++) {
        list($group_data0[$i], $group_data1[$i], $group_data2[$i], $group_data3[$i]) = explode(",", $line[$i], 4);
        //echo($group_name."=".$group_data0[$i]."<br>");
        //echo($group_password."=".$group_data1[$i]."<br><br>");
        if ($group_name == $group_data0[$i]) {
          if ($group_password != $group_data1[$i]) {
            $check = 1; //passwordが違う
            break;
          } else {
            //管理人かの確認
            if ($ID_email == $group_data2[$i]) {
              $check = 11;
              break;
            }

            //メンバーかの確認
            $members = explode("/", $group_data3[$i]);
            foreach ($members as $member) {
              if ($ID_email == $member) {
                $check = 12;
                break 2;
              }
            }
            //合格！
            $line[$i] .= "/" . $ID_email;
            $check = 2;
            break;
          }
        }
      }

      if ($check == 0) {
        echo ("グループが見つかりませんでした。<br>");
        echo ("<input type=\"button\" value=\"戻る\" onClick=\"location.href='join_group.php'\"><br>");
      } else if ($check == 1) {
        echo ("パスワードが違います。<br>");
        echo ("<input type=\"button\" value=\"戻る\" onClick=\"location.href='join_group.php'\"><br>");
      } else if ($check == 2) {
        $f = fopen($file_name, 'w'); // fopenでファイルを開く
        foreach ($line as $_line) {
          fwrite($f, $_line . "\n");
        }
        fclose($f);
        echo ("グループに参加しました。<br>");
      } else if ($check == 11) {
        echo ("あなたはこのグループの管理人です。<br>");
      } else if ($check == 12) {
        echo ("グループにすでに所属しています。<br>");
      }
    }
    ?>
    <input type="button" value="homeに戻る" onClick="location.href='home.php'">
  </div>
</body>