function make_group_selector(name, position) {
  _d = new Date().getTime(); //キャッシュ回避のため日時を利用する
  $.get("function_list/search_group.php?"
    + "server=" + server
    + "&role=member"
    + "&ID_email=" + encodeURI(document.getElementById("ID_email").value)
    + "&cash=" + _d, function (data) {
      //alert(data);
      var a = data.split(",");
      var group_selector = "<select name=\"" + name + "\" id=\"" + name + "\">";
      group_selector += "<option value=\"personal\">personal";
      for (i = 0; i < a.length; i++) {
        if (a[i] != "") {
          group_selector += "<option value=\"" + a[i] + "\">" + a[i];
        }
      }
      group_selector += "</select>";
      document.getElementById(position).innerHTML = group_selector;
    });
}
