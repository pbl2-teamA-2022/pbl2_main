<?php
$server = $_GET['server'];
$ID_email = $_GET['ID_email'];
$group = $_GET['group'];
//echo($ID_email."/".$group.",");
if($ID_email == null){
  //echo ("ログインし直してください<br>");
}
else{
  if($group == "personal" ){
    $file_name = $server."/data_user/".$ID_email.".txt";
  }
  else{
    $file_name = $server."/data_group/".$group.".txt";
  }
  //echo($file_name);
  $f = file_get_contents($file_name);
  echo($f);
}
?>
