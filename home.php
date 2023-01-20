<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <title>交通費計算システム</title>
  <link rel="stylesheet" href="home.css">
  <script type="text/javascript" src="zepto.min.js"></script>
  <script type="text/javascript" src="function_list/server_address.js"></script>
  <script type="text/javascript" src="function_list/make_route.js"></script>
  <script type="text/javascript" src="function_list/make_group_selector.js"></script>
  <script type="text/javascript" src="function_list/make_table_for_home.js"></script>
  <script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzK1MNll10T76kaYCf3eFxhzmvbQ6Hf0c&libraries=geometry&language=ja">
    </script>
  <script type="text/javascript">
    var page_name = "home";
    function check() {
      var check_start = document.form2.start.value;
      var check_goal = document.form2.goal.value;
      var check_rkyori = document.form2.rkyori.value;
      var check_money = document.form2.money.value;
      var check_times = document.form2.times.value;
      if (check_start == "" || check_goal == "") {
        alert("ルートを検索してください。");
        return false;
      }
      else if (check_rkyori == "") {
        alert("距離が計算されていません。正しいルートが計算されていない可能性があります。");
        return false;
      }
      else if (check_money == "") {
        alert("料金が計算されていません。正しいルートが計算されていない可能性があります。");
        return false;
      }
      else if (check_times == "") {
        alert("回数を入力してください。");
        return false;
      }
      else {
        return true;
      }
    }
  </script>
</head>

<body>
  <!-- この部分はブラウザに反映されません -->
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
  <div class="contener">
    <div class="left">
      <form name="form1">
        出発地点&nbsp;:
        <input type="text" name="start" size="40"><br>
        目的地点&nbsp;:
        <input type="text" name="goal" size="40">
        <input type="button" value="ルート検索" onclick="makeroute()"><br>
        (例 1：松山駅、例 2：33.849231, 132.769846)<br>
      </form>
      <br>

      <form name="form2" method="POST" action="home_submit.php" onsubmit="return check()">
        出発地点：<span id="start"></span><span id="start_latlng"></span><br>
        目的地点：<span id="goal"></span><span id="goal_latlng"></span><br>
        直線距離 <span id="dkyori">0</span>m、走行距離 <span id="rkyori">0</span>m<br>
        料金&emsp;&emsp;：<span id="money">0</span>円（走行距離×ガソリン代<span id="fee"></span>）<br>

        <input type="hidden" name="start">
        <input type="hidden" name="goal">
        <!-- <input type="hidden" name="start_latlng"> -->
        <!-- <input type="hidden" name="goal_latlng"> -->
        <!-- <input type="hidden" name="dkyori"> -->
        <input type="hidden" name="rkyori">
        <input type="hidden" name="fee">
        <input type="hidden" name="money">

        開始日&emsp;：
        <select name="start_year">
          <script type="text/javascript">for (i = 2022; i <= 2023; i++) { document.write("<OPTION>" + i) }</script>
        </select>年
        <select name="start_month">
          <script type="text/javascript">for (i = 1; i <= 12; i++) { document.write("<OPTION>" + i) }</script>
        </select>月
        <select name="start_day">
          <script type="text/javascript">for (i = 1; i <= 31; i++) { document.write("<OPTION>" + i) }</script>
        </select>日<br>

        終了日&emsp;：
        <select name="end_year">
          <script type="text/javascript">for (i = 2022; i <= 2023; i++) { document.write("<OPTION>" + i) }</script>
        </select>年
        <select name="end_month">
          <script type="text/javascript">for (i = 1; i <= 12; i++) { document.write("<OPTION>" + i) }</script>
        </select>月
        <select name="end_day">
          <script type="text/javascript">for (i = 1; i <= 31; i++) { document.write("<OPTION>" + i) }</script>
        </select>日<br>

        回数&emsp;&emsp;：
        <input type="text" name="times" value="1"><br>

        グループ：
        <div id="group_selector" style="display: inline-block; _display: inline;"></div><br>

        メモ&emsp;&emsp;：<br>
        <textarea name="memo" rows=3 cols=40 placeholder="メモ"></textarea><br>

        <input type="reset" value="クリア" vaign="center">&nbsp;&nbsp;
        <input type="submit" value="内容を確認する">
      </form>
    </div>
    <br>
    <div class="right">
      <!-- 地図の表示 -->
      <div id="map_canvas" style="float:left; left:5%; height:500px; width:100%; border:solid 1px;"></div>
      <script type="text/javascript">
        var map;
        //map = new google.maps.Map(document.getElementById("map_canvas"), {zoom:zoom, center:{lat:cen_lat, lng:cen_lng}, mapTypeId:google.maps.MapTypeId.ROADMAP});
        map = new google.maps.Map(document.getElementById("map_canvas"), { zoom: zoom, center: { lat: cen_lat, lng: cen_lng }, mapTypeId: google.maps.MapTypeId.TERRAIN });
      </script>
    </div>

    <br><br><br>

    <div class="foot">
      グループ：<div id="group_selector1" style="display: inline-block; _display: inline;"></div>&emsp;
      <input type="button" value="決定" onclick="make_table()">&emsp;
      (料金は小数点以下切り捨て)&emsp;&emsp;&emsp;

      <input type="button" value="グループを作成する" onclick="location.href='make_group.php'">&emsp;
      <input type="button" value="グループに参加する" onclick="location.href='join_group.php'">&emsp;
      <input type="button" value="作成したグループの管理(未実装)" onclick="location.href='admin_group.php'"><br><br>
      <div id="table"></div>
      <br><br>
    </div>
  </div>

  <script type="text/javascript">
    make_group_selector("group", "group_selector");
    make_group_selector("group1", "group_selector1");
    make_table();
  </script><br>
  <div style="text-align: right;">
    <a href="#">ページトップに戻る</a>
  </div>
</body>
</html>
