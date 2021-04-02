<?php
include "../../../model/model.php";
$count=0;
$array_s = array();
$temp_arr = array();
$query = "select * from city_master where 1 ";
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq)){
  $count++;
  $bg = ($row['active_flag']=="Inactive") ? "danger" : "";
  $city_id = $row['city_id'];
  $city_name = $row['city_name'];
  $status = $row['active_flag'];
      $temp_arr = array( "data" => array(
                    (int)($city_id),
                    $city_name,$status,
                    '<a href="javascript:void(0)" data-toggle="tooltip" onclick="city_master_update_modal(\''.$city_id.'\')" class="btn btn-info btn-sm" title="Edit Details"><i class="fa fa-pencil-square-o"></i></a>'), "bg" => $bg
                  );
      array_push($array_s,$temp_arr); 
 }
echo json_encode($array_s);
?>

