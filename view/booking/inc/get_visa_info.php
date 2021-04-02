<?php 
include_once('../../../model/model.php');

$group_id = $_POST['group_id'];

$visa_info_arr =array();
$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

$row_cost = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_group[tour_id]'"));

$visa_info_arr['visa_country_name'] = $row_cost['visa_country_name'];
$visa_info_arr['company_name'] = $row_cost['company_name'];

echo json_encode($visa_info_arr);
?>