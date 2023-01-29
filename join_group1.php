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
    <div align="center">
      <div style="padding: 50px; height: 400px; width: 300px; border: 1px solid #00b4d8;">
        <h1 align="center">
          <font color="#0096c7">
            グループ参加
          </font>
        </h1>
        <?php
        session_start();
        $ID = $_SESSION['ID'];
        if ($ID == null){
          echo ("<br><br>");
          echo ("<h3>ログインしてください</h3><br>");
          echo ("<br><br>");
          echo ("<input type=\"button\" value=\"ログイン\" onClick=\"location.href='index.php'\"><br>");
        }
        else {
          list($ID_email, $ID_password) = explode(",", $ID, 2);
          $group_name = $_POST['group_name'];
          $group_password = $_POST['group_password'];
          $_group_name = htmlspecialchars($group_name, ENT_QUOTES, 'UTF-8');
          $_group_password = htmlspecialchars($group_password, ENT_QUOTES, 'UTF-8');

          $file_name = "text/group_pass.txt";
          $f = file_get_contents($file_name);
          $line = explode("\n", $f);

          $check = 0; //0=グループが存在しない, 1=パスワードが違う, 2=登録を実行, 11=管理人 , 12=メンバー
          for ($i = 0; $i < count($line); $i++) {
            list($group_data0[$i], $group_data1[$i], $group_data2[$i], $group_data3[$i]) = explode(",", $line[$i], 4);
            //echo($group_name."=".$group_data0[$i]."<br>");
            //echo($group_password."=".$group_data1[$i]."<br><br>");
            if ($_group_name == $group_data0[$i]) {
              if ($_group_password != $group_data1[$i]) {
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
                if(!$group_data3[$i]){
                  $line[$i] .= $ID_email;
                }else{
                  $line[$i] .= "/" . $ID_email;
                }
                $check = 2;
                break;
              }
            }
          }

          if ($check == 0) {
            echo ("<br><br><br>");
            echo ("グループが<br>見つかりませんでした。<br>");
            echo ("<br><br><br>");
            echo ("<input type=\"button\" value=\"戻る\" onClick=\"location.href='join_group.php'\">");
            echo ("&emsp;&emsp;&emsp;");
          } else if ($check == 1) {
            echo ("<br><br><br>");
            echo ("パスワードが違います。<br>");
            echo ("<br><br><br>");
            echo ("<input type=\"button\" value=\"戻る\" onClick=\"location.href='join_group.php'\">");
            echo ("&emsp;&emsp;&emsp;");
          } else if ($check == 2) {
            $f = fopen($file_name, 'w'); // fopenでファイルを開く
            for ($i = 0; $i < count($line); $i++) {
              if($line[$i] != ""){
                fwrite($f, $line[$i] . "\n");
              }
            }
            fclose($f);
            echo ("<br><br><br>");
            echo ("グループに参加しました。<br>");
            echo ("<br><br><br>");
          } else if ($check == 11) {
            echo ("<br><br><br>");
            echo ("あなたはこのグループの<br>管理人です。<br>");
            echo ("<br><br><br>");
          } else if ($check == 12) {
            echo ("<br><br><br>");
            echo ("グループにすでに<br>所属しています。<br>");
            echo ("<br><br><br>");
          }
          echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\">");
        }
        ?>
      </div>
    </div>
  </div>
</body>
