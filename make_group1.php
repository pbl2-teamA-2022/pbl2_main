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
            グループ作成
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

          echo ("<br>");
          echo ("<グループ名><br>");
          echo ($_group_name . "<br>");
          echo ("<パスワード><br>");
          echo ($_group_password . "<br>");
          echo ("<br>");

          //同じグループ名がすでに存在するかの確認
          $file_name = "text/group_pass.txt";
          $f = file_get_contents($file_name);
          $line = explode("\n", $f);

          $check = 0;
          for ($i = 0; $i < count($line); $i++) {
            list($group_data0[$i], $group_data1[$i], $group_data2[$i], $group_data3[$i]) = explode(",", $line[$i], 4);
            //echo($group_name."=".$group_data0[$i]."<br>");
            if ($_group_name == $group_data0[$i]) {
              $check = 1;
              break;
            }
          }

          if ($check == 1) {
            echo ("すでにそのグループは存在しています。グループ名を変更してください。<br>");
            echo ("<br>");
            echo ("<input type=\"button\" value=\"戻る\" onClick=\"location.href='make_group.php'\">");
            echo ("&emsp;&emsp;&emsp;");
            echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\">");
          }
          else if ($check == 0) {
            //group_pass.txtにグループを追加
            $filename = 'text/group_pass.txt';
            $fp = fopen($filename, 'a'); // fopenでファイルを開く
            fwrite($fp, $_group_name . ',' . $_group_password . ',' . $ID_email . ',' . "\n"); // fwriteで文字列を書き込む
            fclose($fp); // ファイルを閉じる
            //readfile($filename); // ファイルを出力する

            echo ("グループが作成されました。<br>");
            echo ("グループ名とパスワードをメンバーに伝えて招待してください。");
            echo ("<br><br>");
            echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\">");
          }
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
