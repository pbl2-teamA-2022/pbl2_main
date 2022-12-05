<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
  <title>交通費計算システム</title>
  <script type="text/javascript" src="zepto.min.js"></script>
  <script type="text/javascript" src="function_list/make_route.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzK1MNll10T76kaYCf3eFxhzmvbQ6Hf0c&libraries=geometry&language=ja">
  </script>
  <style>
  table{
    width: 80%;
    border-collapse: collapse;
    text-align: center;
  }
  table th {/*table内のtdに対して*/
    padding: 3px 10px;/*上下3pxで左右10px*/
  }
  table td {/*table内のtdに対して*/
    padding: 3px 10px;/*上下3pxで左右10px*/
  }
  </style>
  <script type="text/javascript">
    var server = "/home/g428miyo/public_html/pbl2";
    function make_group_selector(name, position){
      _d = new Date().getTime(); //キャッシュ回避のため日時を利用する
      $.get("function_list/search_group.php?"
      + "server=" + server
      + "&role=member"
      + "&ID_email=" + encodeURI(document.getElementById("ID_email").value)
      + "&cash=" + _d, function(data){
        //alert(data);
        var a = data.split(","); //改行で区切る
        var group_selector = "<select name=\""+ name + "\" id=\""+ name + "\">";
        group_selector += "<option value=\"personal\">personal";
        for(i = 0; i < a.length; i++){
          if(a[i] != ""){
            group_selector += "<option value=\"" + a[i] + "\">" + a[i];
          }
        }
        group_selector += "</select>";
        document.getElementById(position).innerHTML = group_selector;
      });
    }

    function make_table(){
      _d = new Date().getTime(); //キャッシュ回避のため日時を利用する
      var a;
      if(!document.getElementById("group1")){
        a = "personal";
      }
      else{
        a = encodeURI(document.getElementById("group1").value);
      }
      $.get("function_list/for_make_table.php?"
      + "server=" + server
      + "&ID_email=" + encodeURI(document.getElementById("ID_email").value)
      + "&group=" + a
      + "&cash=" + _d, function(data){
        //alert(data);
        var a = data.split("\n"); //改行で区切る
        var table = "<table>";
        table += "<tr>";
        table +=  "<th>登録日</th>";
        table +=  "<th>期間</th>";
        table +=  "<th>出発地点</th>";
        table +=  "<th>目的地点</th>";
        table +=  "<th>距離(m)</th>";
        table +=  "<th>円/m</th>";
        table +=  "<th>回数</th>";
        table +=  "<th>料金</th>";
        table +=  "<th>メモ</th>";
        table +=  "<th>名前</th>";
        table +=  "<th>削除</th>";
        table +=  "</tr>";
        for(i = 0; i < a.length-1; i++){
          var b = a[i].split(","); //カンマで区切る
          table += "<tr>";
          table += "<td>" + b[0] + "</td>";
          table += "<td>" + b[1] + "～" + b[2] + "</td>";
          table += "<td>" + b[3] + "</td>";
          table += "<td>" + b[4] + "</td>";
          table += "<td>" + b[5] + "</td>";
          table += "<td>" + b[6] + "</td>";
          table += "<td>" + b[7] + "</td>";
          table += "<td>" + Math.trunc(b[5]*b[6]*b[7]) + "</td>";
          table += "<td>" + b[8] + "</td>";
          table += "<td>" + b[9] + "</td>";
          table += "<td>" + "" + "</td>";
          table += "</tr>";
        }
        table += "</table>";
        document.getElementById("table").innerHTML = table;
      });
    }
    
    function check(){
      /*
      var group_name = document.form1.group_name.value;
      var group_password = document.form1.group_password.value;;
      //alert(group_name);
      if(group_name == ""){
        alert("グループ名を入力してください");
        return false;
      }
      else if(group_password == ""){
        alert("パスワードを入力してください");
        return false;
      }
      else{
        return true;
      }
      */
    }
  </script>
</head>
<body>
  <!-- この部分はブラウザに反映されません -->
  <h4>交通費計算システム</h4><br>
  <?php
  $ID_email = null;
  $ID_password = null;
  session_start();
  $ID = $_SESSION['ID'];
  if($ID == null){
    echo ("<b>ログインしてください</b>&emsp;");
    echo("<input type=\"button\" value=\"ログイン\" onClick=\"location.href='login.php'\"><br>");
  }
  else{
    list($ID_email, $ID_password) = explode(",",$ID,2);
    echo("<input type=\"hidden\" id=\"ID_email\" value=\"".$ID_email."\">");
    echo("<b>".$ID_email."</b>でログイン済み&emsp;");
    echo("<input type=\"button\" value=\"ログアウト\" onClick=\"location.href='logout.php'\"><br>");
  }
  ?>
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
    <select name="start_year"><script type="text/javascript">for(i=2022;i<=2023;i++){document.write("<OPTION>" + i)}</script></select>年
    <select name="start_month"><script type="text/javascript">for(i=1;i<=12;i++){document.write("<OPTION>" + i)}</script></select>月
    <select name="start_day"><script type="text/javascript">for(i=1;i<=31;i++){document.write("<OPTION>" + i)}</script></select>日<br>

    終了日&emsp;：
    <select name="end_year"><script type="text/javascript">for(i=2022;i<=2023;i++){document.write("<OPTION>" + i)}</script></select>年
    <select name="end_month"><script type="text/javascript">for(i=1;i<=12;i++){document.write("<OPTION>" + i)}</script></select>月
    <select name="end_day"><script type="text/javascript">for(i=1;i<=31;i++){document.write("<OPTION>" + i)}</script></select>日<br>

    回数&emsp;&emsp;：
    <input type="text" name="times" value="1"><br>

    グループ：
    <div id="group_selector" style="display: inline-block; _display: inline;"></div><br>

    メモ&emsp;&emsp;：<br>
    <textarea name="memo" rows=3 cols=40 placeholder="メモ"></textarea><br>

    <input type="reset" value="クリア" vaign="center">&nbsp;&nbsp;
    <input type="submit" value="内容を確認する">
  </form>
  <br>

  <!-- 地図の表示 -->
  <div id="map_canvas" style="float:left; left:0%; height:600px; width:60%; border:solid 1px;"></div>
  <script type="text/javascript">
    var map;
    //map = new google.maps.Map(document.getElementById("map_canvas"), {zoom:zoom, center:{lat:cen_lat, lng:cen_lng}, mapTypeId:google.maps.MapTypeId.ROADMAP});
    map = new google.maps.Map(document.getElementById("map_canvas"), {zoom:zoom, center:{lat:cen_lat, lng:cen_lng}, mapTypeId:google.maps.MapTypeId.TERRAIN});
  </script>

  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  グループ：<div id="group_selector1" style="display: inline-block; _display: inline;"></div>&emsp;
  <input type="button" value="決定" onclick="make_table()">&emsp;
  (料金は小数点以下切り捨て)&emsp;&emsp;&emsp;

  <input type="button" value="グループを作成する" onclick="location.href='make_group.php'">&emsp;
  <input type="button" value="グループに参加する" onclick="location.href='join_group.php'">&emsp;
  <input type="button" value="作成したグループの管理（未実装）" onclick=""><br><br>

  <form action="delete.php" method="POST">
    <div id="table"></div>
  </form>

  <script type="text/javascript">
    make_group_selector("group","group_selector");
    make_group_selector("group1","group_selector1");
    make_table();
  </script>
  <br><br>
</body>
</html>
