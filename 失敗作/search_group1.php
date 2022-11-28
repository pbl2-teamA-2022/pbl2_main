<?php
function search_group($ID_email, $n){
  $admin_group = null;
  $member_group = "personal";

  $file_name = "text/group_pass.txt";
  $f = file_get_contents($file_name);

  $line = explode("\n", $f);
  //print_r($line);

  for($i = 0; $i < count($line); $i++){
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
  if($n == 0){
    return $member_group;
  }
  else if($n == 1){
    return $admin_group;
  }
}
?>
