function make_table() {
  _d = new Date().getTime(); //キャッシュ回避のため日時を利用する
  var a;
  if (!document.getElementById("group1")) {
    a = "personal";
  }
  else {
    a = encodeURI(document.getElementById("group1").value);
  }
  $.get("function_list/make_table_submit_for_home.php?"
    + "server=" + server
    + "&ID_email=" + encodeURI(document.getElementById("ID_email").value)
    + "&group=" + a
    + "&cash=" + _d, function (data) {
      //alert(data);
      var a = data.split("\n"); //改行で区切る
      var table = "<table>";
      table += "<tr>";
      table += "<th>登録日</th>";
      table += "<th>期間</th>";
      table += "<th>出発地点</th>";
      table += "<th>目的地点</th>";
      table += "<th>距離(m)</th>";
      table += "<th>円/m</th>";
      table += "<th>回数</th>";
      table += "<th>料金</th>";
      table += "<th>メモ</th>";
      table += "<th>名前</th>";
      table += "<th>削除</th>";
      table += "</tr>";
      for (i = 0; i < a.length - 1; i++) {
        var b = a[i].split(","); //カンマで区切る
        table += "<tr>";
        table += "<td>" + b[0] + "</td>";
        table += "<td>" + b[1] + "～" + b[2] + "</td>";
        table += "<td>" + b[3] + "</td>";
        table += "<td>" + b[4] + "</td>";
        table += "<td>" + b[5] + "</td>";
        table += "<td>" + b[6] + "</td>";
        table += "<td>" + b[7] + "</td>";
        table += "<td>" + Math.trunc(b[5] * b[6] * b[7]) + "</td>";
        table += "<td>" + b[8] + "</td>";
        table += "<td>" + b[9] + "</td>";
        table += "<td>" + "" + "</td>";
        table += "</tr>";
      }
      table += "</table>";
      document.getElementById("table").innerHTML = table;
    });
}
