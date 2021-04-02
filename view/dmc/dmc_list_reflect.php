<?php

include "../../model/model.php";

$active_flag = $_POST['active_flag'];
$city_id = $_POST['city_id'];

$query = "select * from dmc_master where 1 ";
$array_s = array();
$temp_arr = array();
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($city_id!=""){
	$query .=" and city_id='$city_id' ";
}

$count = 0;
$sq_dmc = mysql_query($query);
while($row_dmc = mysql_fetch_assoc($sq_dmc)){
		$sq_gl = mysql_fetch_assoc(mysql_query("select * from gl_master where gl_id='$row_dmc[gl_id]'"));
		$bg = ($row_dmc['active_flag']=="Inactive") ? "danger" : "";
		$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_dmc[city_id]'"));
		$mobile_no = $encrypt_decrypt->fnDecrypt($row_dmc['mobile_no'], $secret_key);
		$email_id = $encrypt_decrypt->fnDecrypt($row_dmc['email_id'], $secret_key);
		$temp_arr = array("data" => array(
			(int)(++$count), $row_dmc['company_name'],$sq_city['city_name'],$mobile_no,$row_dmc['contact_person_name'],
			'
			<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="dmc_update_modal('.$row_dmc['dmc_id'] .')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
			
			<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="dmc_view_modal('. $row_dmc['dmc_id'].')" title="View Details"><i class="fa fa-eye"></i></button>
			
			'), "bg" => $bg);
		array_push($array_s,$temp_arr); 
}
//print_r($array_s);
echo json_encode($array_s);
?>
