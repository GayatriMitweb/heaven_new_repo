<?php
include "../../../model/model.php";
$cur_date = date('d-m-Y');
$cur_date = get_date_db($cur_date);
$query_count = mysql_num_rows(mysql_query("select * from hotel_inventory_master where valid_to_date < '$cur_date'"));
if($query_count>0){
  $query = "select * from hotel_inventory_master where valid_to_date < '$cur_date'";
  $sq_inv = mysql_query($query);
  while($row_inv = mysql_fetch_assoc($sq_inv)){
    $sq_update = mysql_query("update hotel_inventory_master set active_flag='Inactive' where entry_id='$row_inv[entry_id]'");
  }
}
$query = "select * from hotel_inventory_master where valid_to_date > '$cur_date'";
$sq_inv = mysql_query($query);
while($row_inv = mysql_fetch_assoc($sq_inv)){
  $sq_update = mysql_query("update hotel_inventory_master set active_flag='Active' where entry_id='$row_inv[entry_id]'");
}


?>