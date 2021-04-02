<?php 
include_once('../../../model/model.php');
$array_s = array();
$temp_arr = array();
$count = 0;
$sq_vehicle = mysql_query("select * from b2b_transfer_master");
while($row_vehicle = mysql_fetch_assoc($sq_vehicle))
{
	$vehicle_data = json_decode($row_vehicle['vehicle_data']);
	$bg = ($row_vehicle['status']=="Inactive") ? "danger" : "";
	$temp_arr = array ("data"=>array(
		(int)(++$count),
		$row_vehicle['vehicle_type'],
		$row_vehicle['vehicle_name'],
		$row_vehicle['seating_capacity'],
		'<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="edit_modal('.$row_vehicle[entry_id] .')" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>'),"bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
?>