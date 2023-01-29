var cen_lat = 36.0165537287548; //地図の中心の緯度
var cen_lng = 137.9921457221503; //地図の中心の経度
var zoom = 6; //地図の縮尺

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

function makeroute(file_name){ //入力された出発地を緯度経度に変換
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
  else if( document.form1.goal.value.match(/^[0-9\., ]+$/) ){ //目的地に緯度・経度が入力されている
    var p = document.form1.goal.value.split(",");
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

      if( page_name == "home" ){
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
    }
    else{
      alert("認識できませんでした。");
    }
  });
}
