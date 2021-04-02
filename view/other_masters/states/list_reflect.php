<?php
include "../../../model/model.php";
$array_s = array();
$temp_arr = array();
$query = "select * from state_master where 1 ";
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq)){
  $state_id = $row['id'];
  $state_name = $row['state_name'];
  $status = $row['active_flag'];
  $bg = ($row['active_flag']=="Inactive") ? "danger" : "";
      $temp_arr = array( "data" => array(
                    (int)($state_id),$state_name,$status,'<a data-toggle="tooltip" href="javascript:void(0)" onclick="state_master_update_modal(\''.$state_id.'\')" class="btn btn-info btn-sm" title="Update Details"><i class="fa fa-pencil-square-o"></i></a>'), "bg" => $bg
                  );
      array_push($array_s,$temp_arr); 
 }
echo json_encode($array_s);
?>