<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
  <title>交通費計算システム</title>
  <script>
  </script>
</head>
<body>
  <h4>交通費計算システム</h4><br>
  <?php
  session_start();
  $ID = $_SESSION['ID'];
  if($ID == null){
    echo ("ログインし直してください<br>");
  }
  else{
    list($ID_email,$ID_password) = explode(",",$ID,2);

    $group_name = $_POST['group_name'];
    $group_password = $_POST['group_password'];
    echo("グループ名：".$group_name."<br>");
    echo("パスワード：".$group_password."<br>");

    //グループ名とパスワードが一致するか確認
    $file_name = "text/group_pass.txt";
    $f = file_get_contents($file_name);
    $line = explode("\n", $f);

    $check = 0; //0=グループが存在しない, 1=パスワードが違う, 2=メンバー外, 11=管理人 , 12=メンバー
    for($i = 0; $i < count($line); $i++){
      list($group_data0[$i],$group_data1[$i],$group_data2[$i],$group_data3[$i]) = explode(",",$line[$i],4);
      //echo($group_name."=".$group_data0[$i]."<br>");
      //echo($group_password."=".$group_data1[$i]."<br><br>");
      if($group_name == $group_data0[$i]){
        if($group_password != $group_data1[$i]){
          $check = 1; //passwordが違う
          break;
        }
        else{
          //すでに登録しているかの確認
          //管理人かの確認
          if($ID_email == $group_data2[$i]){
            $check = 11;
            break;
          }

          //メンバーかの確認
          $members = explode("/", $group_data3[$i]);
          //print_r($members); //配列を全部見れるやつ
          //echo $members[0]; //配列を個々に見れるやつ
          foreach($members as $member) { //配列分繰り返すやつ
            //echo($member."<br>");
            if($ID_email == $member){
              $check = 12;
              break 2;
            }
          }
          $check = 2;
          break;
        }
      }
    }

    if($check == 0){
        echo("グループが見つかりませんでした。<br>");
      }
      else if($check == 1){
        echo("パスワードが違います。<br>");
      }
      else if($check == 11){
        echo("あなたはこのグループの管理人です。<br>");
        echo("グループメンバー：");
        print_r($members);
        echo("<br>");
        //ここにグループの情報を掲載予定

      }
      else if($check == 12){
        echo("あなたはこのグループの管理人ではありません。<br>");
      }
      else if($check == 2){
        echo("あなたはこのグループに所属していません。<br>");
      }
    }
    ?>

    <input type="button" value="戻る" onClick="location.href='home.php'">

</body>
</html>