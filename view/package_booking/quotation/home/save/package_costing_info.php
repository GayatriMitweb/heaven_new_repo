<?php 
include_once('../../../../../model/model.php');

$package_id_arr = $_POST['package_id_arr'];

$costing_info_arr =array();

for($i=0; $i<sizeof($package_id_arr); $i++){
	
	$sq_package = mysql_query("select * from custom_package_master where package_id='$package_id_arr[$i]'");
	
	while($row_transport = mysql_fetch_assoc($sq_package)){
		$arr1 = array(
			'adult_cost' => $row_transport['adult_cost'],
			'child_cost' => $row_transport['child_cost'],
			'infant_cost' => $row_transport['infant_cost'],
			'child_with' => $row_transport['child_with'],
			'child_without' => $row_transport['child_without'],
			'extra_bed' => $row_transport['extra_bed'],
			'package_name' => $row_transport['package_name'],
			'package_id' => $row_transport['package_id']
		);	
	}

	array_push($costing_info_arr, $arr1);

}
echo json_encode($costing_info_arr);
?>