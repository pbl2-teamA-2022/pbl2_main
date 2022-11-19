<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
  <title>交通費計算システム</title>
  <script type="text/javascript" src="zepto.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzK1MNll10T76kaYCf3eFxhzmvbQ6Hf0c&libraries=geometry&language=ja">
  </script>
  <style>
  table{
    width: 80%;
    padding: 3px;
    border-collapse: collapse;
    border: solid 2px skyblue;/*表全体を線で囲う*/
    text-align: center;
  }
  table th {/*table内のtdに対して*/
    padding: 3px 10px;/*上下3pxで左右10px*/
    border: solid 2px skyblue;/*実線 1px 黒*/
    background: #EBFDFF;/*背景色*/
  }
  table td {/*table内のtdに対して*/
    padding: 3px 10px;/*上下3pxで左右10px*/
    border: dashed 1px skyblue;/*点線 1px 黒*/
  }
  </style>
  <script type="text/javascript">
    var server = "/home/g428miyo/public_html/pbl2";
    var map;
    var cen_lat = 33.849231; //地図の中心の緯度
    var cen_lng = 132.769846; //地図の中心の経度
    var zoom = 11; //地図の縮尺

    var dline = null; //出発地から目的地までの直線
    var rline = null; //出発地から目的地までの道路

    var start; //テキストに入力された出発地を格納
    var goal; //テキストに入力された目的地を格納
    var start_latlng;
    var goal_latlng;
    var startMarker;
    var goalMarker;
    var startMarker_img = "images/start.png";
    var goalMarker_img = "images/goal.png";

    var dService; //ルート検索に必要なやつ１
    var request; //ルート検索に必要なやつ２

    var dline = null; //現在地から観光ポイントまでの直線
    var rline = null; //現在地から観光ポイントまでの道路
    var dkyori = null; //直線距離
    var rkyori = null; //走行距離

    var fee = 0.01; //1mあたりのガソリン代
    var money = null;
  </script>

  <script type="text/javascript">
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
    echo ("ログインし直してください<br>");
  }
  else{
    list($ID_email, $ID_password) = explode(",",$ID,2);
    echo($ID_email."でログイン済み<br>");
    echo("<input type=\"hidden\" id=\"ID_email\" value=\"".$ID_email."\">");
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

  <form name="form2" action="home_submit.php" method="POST">
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

    グループ：<div id="group_selector" style="display: inline-block; _display: inline;"></div><br>
    メモ&emsp;&emsp;：<br>
    <textarea name="memo" rows=3 cols=40 placeholder="メモ"></textarea><br>
    <input type="reset" value="クリア" vaign="center">&nbsp;&nbsp;
    <input type="submit" value="内容を確認する">
  </form>
  <br>
  <!-- 地図の表示 -->
  <div id="map_canvas" style="float:left; left:0px; height:600px; width:60%; border:solid 1px;"></div>
  <!--<div id="map_canvas" style="float:left; left:20px; height:85%; width:60%; border:solid 1px;"></div> (課題11のコピペ)-->

  <script type="text/javascript">
    //map = new google.maps.Map(document.getElementById("map_canvas"), {zoom:zoom, center:{lat:cen_lat, lng:cen_lng}, mapTypeId:google.maps.MapTypeId.ROADMAP});
    map = new google.maps.Map(document.getElementById("map_canvas"), {zoom:zoom, center:{lat:cen_lat, lng:cen_lng}, mapTypeId:google.maps.MapTypeId.TERRAIN});
  </script>

  <!-- ルート検索 -->
  <script>
  function makeroute(){ //入力された出発地を緯度経度に変換
    start = document.form1.start.value;
    if(start  == ""){ //出発地が入力されていない
      alert("出発地が入力されていません。");
    }
    else if( document.form1.start.value.match(/^[0-9\., ]+$/) ){ //出発地に緯度・経度が入力されている
      var p = document.form1.start.value.split(",");
      start_latlng = new google.maps.LatLng(p[0], p[1]);
      //alert(start_latlng);
      makeroute1();
    }
    else{ //出発地に地名が入力されている
      new google.maps.Geocoder().geocode({address:start}, function(results,status){
        if( status == google.maps.GeocoderStatus.OK ){
          start_latlng = results[0].geometry.location;
          //alert(start_latlng);
          makeroute1();
        }
        else{
          alert( 'Faild：' + status + " (出発地が見つかりませんでした)");
        }
      });
    }
  }
  function makeroute1(){ //入力された目的地を緯度経度に変換
    goal = document.form1.goal.value;
    if(goal  == ""){ //目的地が入力されていない
      alert("目的地が入力されていません。");
    }
    else if( document.form1.start.value.match(/^[0-9\., ]+$/) ){ //目的地に緯度・経度が入力されている
      var p = document.form1.start.value.split(",");
      goal_latlng = new google.maps.LatLng(p[0], p[1]);
      //alert(goal_latlng);
      makeroute2();
    }
    else{ //目的地に地名が入力されている
      new google.maps.Geocoder().geocode({address:goal}, function(results,status){
        if( status == google.maps.GeocoderStatus.OK ){
          goal_latlng = results[0].geometry.location;
          //alert(goal_latlng);
          makeroute2();
        }
        else{
          alert( 'Faild：' + status + " (目的地が見つかりませんでした)");
        }
      });
    }
  }
  function makeroute2(){ //ルートを作成
    //マーカーの設置
    if( startMarker ){ startMarker.setMap(null) };
    startMarker = new google.maps.Marker({
    position:start_latlng, map:map, title:'スタート地点', icon:startMarker_img
    });
    if( goalMarker ){ goalMarker.setMap(null) };
    goalMarker = new google.maps.Marker({
    position:goal_latlng, map:map, title:'ゴール地点', icon:goalMarker_img
    });

    //ルート計算
    dService = new google.maps.DirectionsService();
    request = {origin:start_latlng, destination:goal_latlng, travelMode:google.maps.TravelMode.DRIVING};

    dService.route(request, function(response, status){
      if (status == google.maps.DirectionsStatus.OK) {
        var p, _dkyori, _rkyori = 0;
        var points = new Array((p = response.routes[0].overview_path).length);
        for (var i = 0; i < points.length; i++){
          points[i] = new google.maps.LatLng(p[i].lat(), p[i].lng());
        }

        //直線距離
        if( dline ) dline.setMap(null);
        dline = new google.maps.Polyline({path:[start_latlng, goal_latlng], strokeWeight:1, strokeColor:'#0000ff', strokeOpacity:"0.5"});
        dline.setMap(map);

        _dkyori = google.maps.geometry.spherical.computeDistanceBetween(start_latlng, goal_latlng);
        dkyori = Math.round(_dkyori);

        //ルート
        if( rline ) rline.setMap(null);
        rline = new google.maps.Polyline({path:points, strokeWeight:1, strokeColor:'#ff0000', strokeOpacity:"1.0"});
        rline.setMap(map);

        for(j = 1; j < points.length; j++){
          _rkyori += google.maps.geometry.spherical.computeDistanceBetween(points[j-1], points[j]);
        }
        rkyori = Math.round(_rkyori);

        money = rkyori * fee;

        document.getElementById('start').innerHTML = start;
        document.getElementById('goal').innerHTML = goal;
        document.getElementById('start_latlng').innerHTML = start_latlng;
        document.getElementById('goal_latlng').innerHTML = goal_latlng;
        document.getElementById('dkyori').innerHTML = dkyori;
        document.getElementById('rkyori').innerHTML = rkyori;
        document.getElementById('fee').innerHTML = "(" + fee + "円/m)";
        document.getElementById('money').innerHTML = money;
        document.form2.start.value = start;
        document.form2.goal.value = goal;
        //document.form2.start_latlng.value = start_latlng;
        //document.form2.goal_latlng.value = goal_latlng;
        //document.form2.dkyori.value = dkyori;
        document.form2.rkyori.value = rkyori;
        document.form2.fee.value = fee;
        document.form2.money.value = money;
      }
      else{
        alert("認識できませんでした。");
      }
    });
  }
  </script>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

  一覧<br>
  グループ：<div id="group_selector1" style="display: inline-block; _display: inline;"></div>&emsp;
  <input type="button" value="決定" onclick="make_table()">&emsp;
  (料金は小数点以下切り捨て)&emsp;&emsp;&emsp;
  <input type="button" value="グループを作成する" onclick="location.href='make_group.php'">&emsp;
  <input type="button" value="グループに参加する" onclick="location.href='join_group.php'">&emsp;
  <input type="button" value="作成したグループの管理（未実装）" onclick=""><br>
  <br>

  <form action="delete.php" method="POST">
    <div id="table"></div>
  </form>
  <br><br><br>

  <script type="text/javascript">
    make_group_selector("group","group_selector");
    make_group_selector("group1","group_selector1");
    make_table();
  </script>
</body>
</html>
