<?php
include "../../../../model/model.php";

$active_flag = $_POST['active_flag'];
$city_id = $_POST['city_id'];
$array_s = array();
$temp_arr = array();
$query = "select * from hotel_master where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($city_id!=""){
	$query .=" and city_id='$city_id' ";
}
$count = 0;
$sq_hotel = mysql_query($query);
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
	$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_hotel[city_id]'"));
	$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_hotel[gl_id]'"));
	$bg = ($row_hotel['active_flag']=="Inactive") ? "danger" : "";
	$mobile_no = $encrypt_decrypt->fnDecrypt($row_hotel['mobile_no'], $secret_key);
	$temp_arr = array("data" =>array(
		(int)(++$count), ucfirst($row_hotel['hotel_name']),ucfirst($sq_city['city_name']),$mobile_no,$row_hotel['contact_person_name'],
		'<button class="btn btn-info btn-sm" onclick="update_modal('.$row_hotel['hotel_id'] .')" data-toggle="tooltip" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
		<button class="btn btn-info btn-sm" onclick="view_modal('.$row_hotel['hotel_id'].')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'), "bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>