<?php
$server = $_GET['server'];
$role = $_GET['role'];
$ID_email = $_GET['ID_email'];

if($ID_email == null){
  echo ("ログインし直してください<br>");
}
else{
  $file_name = $server."/text/group_pass.txt";
  //echo("<server=".$server."><役職=".$role."><Email=".$ID_email."><file_name=".$file_name.">");
  $f = file_get_contents($file_name);
  $line = explode("\n", $f);
  //print_r($line);

  for($i = 0; $i < count($line)-1; $i++){
    list($group_data0[$i],$group_data1[$i],$group_data2[$i],$group_data3[$i]) = explode(",", $line[$i], 4);
    //echo($group_data3[$i]."<br>");

    if($ID_email == $group_data2[$i]){
      $admin_group .= $group_data0[$i].",";
      $member_group .= ",".$group_data0[$i];
    }
    else{
      $group_data4[$i] =  explode("/", $group_data3[$i]);
      //print_r($group_data4[$i]."<br>");
      foreach($group_data4[$i] as $key => $val){
        //echo ($key."=".$val."<br>");
        if( $ID_email == $val ){
          $member_group  .= ",".$group_data0[$i];
        }
      }
    }
  }
  if( $role == "admin" ){
    echo($admin_group);
  }
  else if( $role == "member" ){
    echo($member_group);
  }
}
?>
