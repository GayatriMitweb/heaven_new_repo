<?php
include_once('../../../../../model/model.php');
$package_id_arr = $_POST['package_id_arr'];
$from_date = $_POST['from_date'];

$train_info_arr = array();
for($i=0; $i<sizeof($package_id_arr); $i++){

	$sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id='$package_id_arr[$i]'"));		
	$sq_count = mysql_num_rows(mysql_query("select * from custom_package_hotels where package_id = '$package_id_arr[$i]'"));
	if($sq_count==0){
		for($j=0;$j<3;$j++){
			$arr = array(
				'city_id' => '',
				'hotel_id1' => '',
				'city_name' => '',
				'hotel_name' => '',
				'hotel_type' => '',
				'total_days' => '',			
				'package_name' => $sq_package['package_name'],
				'hotel_cost' => '',
				'extra_bed_cost' => '',
				'package_id' => $sq_package['package_id']
			);
			array_push($train_info_arr, $arr);
		}
	}
	else{
		
		$sq_train = mysql_query("select * from custom_package_hotels where package_id='$package_id_arr[$i]'");
		while($row_train = mysql_fetch_assoc($sq_train)){
			
			$sq_hotel_id = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id = '$row_train[hotel_name]'"));
			$hotel_name1 = $sq_hotel_id['hotel_name'];
			$sq_city_id = mysql_fetch_assoc(mysql_query("select * from city_master where city_id = '$row_train[city_name]'"));
			$city_name1 = $sq_city_id['city_name'];
			$from_date = date('Y-m-d',strtotime($from_date));

			$arr = array(
				'city_id' => $row_train['city_name'],
				'hotel_id1' => $row_train['hotel_name'],
				'city_name' => $city_name1,
				'hotel_name' => $hotel_name1,
				'hotel_type' => $row_train['hotel_type'],
				'total_days' => $row_train['total_days'],
				'package_name' => $sq_package['package_name'],
				'hotel_cost' => 0,
				'extra_bed_cost' => 0,
				'package_id' => $sq_package['package_id']
			);
		array_push($train_info_arr, $arr);
		}
	}
}
echo json_encode($train_info_arr);
?>