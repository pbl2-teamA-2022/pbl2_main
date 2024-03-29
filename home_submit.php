<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <title>交通費計算システム</title>
  <link rel="stylesheet" href="home.css">
  <script type="text/javascript" src="zepto.min.js"></script>
  <script type="text/javascript" src="function_list/make_route.js"></script>
  <script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzK1MNll10T76kaYCf3eFxhzmvbQ6Hf0c&libraries=geometry&language=ja"></script>
  <script type="text/javascript">
  var page_name = "home_submit.php";
  </script>
</head>

<body>
  <header>
    <h4 class="title">交通費計算システム&emsp;&emsp;</h4>
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
    <div class="left">
      <?php
      error_reporting(E_ALL ^ E_NOTICE);
      session_start();
      $ID = $_SESSION['ID'];
      if ($ID != null) {
        list($ID_email, $ID_password) = explode(",", $ID, 2);

        if ($_POST['send'] == '確認') {
          $date = date("Y/m/d-H:i:s"); //現在時間の取得
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
          $start_date = $start_year . "/" . $start_month . "/" . $start_day;

          $end_year = $_POST['end_year'];
          $end_month = $_POST['end_month'];
          $end_day = $_POST['end_day'];
          $end_date = $end_year . "/" . $end_month . "/" . $end_day;

          if ($group == "personal") { //個人ファイルに記入
            $filename = "data_user/" . $ID_email . ".txt";
          } else { //グループファイルに記入
            $filename = "data_group/" . $group . ".txt";
          }
          $fp = fopen($filename, 'a'); // fopenでファイルを開く
          fwrite($fp, $date . "," . $start_date . "," . $end_date . "," . $start . "," . $goal . "," . $rkyori . "," . $fee . "," . $times . "," . $memo . "," . $ID_email . "\n"); // fwriteで文字列を書き込む
          fclose($fp); // ファイルを閉じる

          echo ("記録が完了しました。");
          echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\"><br>");
        }

        else {
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
          $start_date = $start_year . "/" . $start_month . "/" . $start_day;
          $end_year = $_POST['end_year'];
          $end_month = $_POST['end_month'];
          $end_day = $_POST['end_day'];
          $end_date = $end_year . "/" . $end_month . "/" . $end_day;

          $start = htmlspecialchars($start, ENT_QUOTES, 'UTF-8');
          $goal = htmlspecialchars($goal, ENT_QUOTES, 'UTF-8');
          $rkyori = htmlspecialchars($rkyori, ENT_QUOTES, 'UTF-8');
          $fee = htmlspecialchars($fee, ENT_QUOTES, 'UTF-8');
          $money = htmlspecialchars($money, ENT_QUOTES, 'UTF-8');
          $times = htmlspecialchars($times, ENT_QUOTES, 'UTF-8');
          $group = htmlspecialchars($group, ENT_QUOTES, 'UTF-8');
          $memo = htmlspecialchars($memo, ENT_QUOTES, 'UTF-8');

          $start_date = htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8');
          $end_date = htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8');

          echo ("出発地点&emsp;：" . $start . "<br>");
          echo ("目的地点&emsp;：" . $goal . "<br>");
          echo ("走行距離&emsp;：" . $rkyori . "<br>");
          echo ("料金&emsp;&emsp;&emsp;：" . $money . "円(走行距離×ガソリン代(" . $fee . "円/m))<br>");
          echo ("開始日&emsp;&emsp;：" . $start_date . "<br>");
          echo ("終了日&emsp;&emsp;：" . $end_date . "<br>");
          echo ("回数&emsp;&emsp;&emsp;：" . $times . "回<br>");
          echo ("グループ&emsp;：" . $group . "<br><br>");
          echo ("<メモ><br>");
          echo ("<pre>".$memo."</pre>");
          echo ("<br>");

          echo ("<form action=\"home_submit.php\" method=\"POST\">");
          foreach ($_POST as $key => $val) {
            $val = htmlspecialchars($val);
            echo ("<input type=\"hidden\" name=\"" . $key . "\" value=\"" . $val . "\">");
          }
          echo ("<br><input type=\"submit\" name=\"send\" value=\"確認\"></form><br>");
          echo ("<input type=\"button\" value=\"homeに戻る\" onClick=\"location.href='home.php'\"><br>");

          //ルート情報
          echo ("<form name=\"form1\">");
          echo ("<input type=\"hidden\" name=\"start\" value=\"" . $start . "\">");
          echo ("<input type=\"hidden\" name=\"goal\" value=\"" . $goal . "\">");
          echo ("</form>");
          echo ("</div>");

          //地図の表示
          echo ("<div class=\"right\">");
          echo ("<div id=\"map_canvas\" style=\"float:left; left:5%; height:500px; width:100%; border:solid 1px;\"></div>");
          echo ("</div>");
          echo ("<script type=\"text/javascript\">");
          echo ("var map;");
          echo ("map = new google.maps.Map(document.getElementById(\"map_canvas\"), { zoom: zoom, center: { lat: cen_lat, lng: cen_lng }, mapTypeId: google.maps.MapTypeId.TERRAIN });");
          echo ("makeroute();");
          echo ("</script>");
        }
      }
      ?>
    </div>
  </div>
</body>
</html>
