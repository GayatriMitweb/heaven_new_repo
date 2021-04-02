<?php
include "../../model/model.php";
$city_id = $_POST['city_id'];
$active_flag = $_POST['active_flag'];
$query = "select entry_id,city_id,currency_code,excursion_name,departure_point,duration from excursion_master_tariff where 1 ";
if($city_id != ''){
	$query .= " and city_id = '$city_id'";
}
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
$query .= ' order by entry_id desc';
$count = 0;
$sq_serv = mysql_query($query);
$array_s = array();
$temp_arr = array();
while($row_ser = mysql_fetch_assoc($sq_serv)){
	$bg='';
	if($row_ser['active_flag']=='Inactive'){
		$bg ='danger';
	}
	$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$row_ser[city_id]'"));
	$sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$row_ser[currency_code]'"));
	$bg = ($row_ser['active_flag']=="Inactive") ? "danger" : "";
	$temp_arr = array("data" =>array(
		(int)(++$count),
		$sq_city['city_name'],
		$row_ser['excursion_name'],
		$row_ser['departure_point'],
		$row_ser['duration'],
		$sq_currency['currency_code'],
		'<button class="btn btn-info btn-sm" onclick="update_modal('.$row_ser['entry_id'] .')" data-toggle="tooltip" title="Update Details"><i class="fa fa-pencil-square-o"></i></button><button class="btn btn-info btn-sm" onclick="time_slotupdate_modal('.$row_ser['entry_id'] .')" data-toggle="tooltip" title="Update Timing Slot Details"><i class="fa fa-pencil-square-o"></i></button>'), "bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}

echo json_encode($array_s);
?>