<?php
include_once('../../../../../model/model.php');

//Get selected currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$transport_id_arr = $_POST['transport_id_arr'];
$travel_date_arr = $_POST['travel_date_arr'];
$pickup_arr = $_POST['pickup_arr'];
$drop_arr = $_POST['drop_arr'];
$pickup_id_arr = $_POST['pickup_id_arr'];
$drop_id_arr = $_POST['drop_id_arr'];
$vehicle_count_arr = $_POST['vehicle_count_arr'];
$ppackage_id_arr = $_POST['ppackage_id_arr'];
$ppackage_name_arr = $_POST['ppackage_name_arr'];

$transport_info_arr = array();
$transport_info_arr1 = array();
for($i=0;$i<sizeof($transport_id_arr);$i++){
	
	$count=0;
	$from_date = get_date_db($travel_date_arr[$i]);
	$q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$transport_id_arr[$i]'"));

	$row_tariff_master1 = mysql_query("select * from b2b_transfer_tariff where vehicle_id='$transport_id_arr[$i]' order by tariff_id desc");	
	while($row_tariff_master = mysql_fetch_assoc($row_tariff_master1)){
		
		$tariff_count = mysql_num_rows(mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$pickup_id_arr[$i]' and drop_type = '$drop_id_arr[$i]' and pickup_location = '$pickup_arr[$i]' and drop_location = '$drop_arr[$i]' and (from_date <='$from_date' and to_date>='$from_date')"));
		if($tariff_count != 0){
			$sq_tariff1 = mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$pickup_id_arr[$i]' and drop_type = '$drop_id_arr[$i]' and pickup_location = '$pickup_arr[$i]' and drop_location = '$drop_arr[$i]' and (from_date <='$from_date' and to_date>='$from_date')");
			while($sq_tariff = mysql_fetch_assoc($sq_tariff1)){
				$count++;

				$currency_id = $row_tariff_master['currency_id'];
				$sq_from = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency_id'"));
				$from_currency_rate = $sq_from['currency_rate'];
				$tariff_data = json_decode($sq_tariff['tariff_data']);
				$total_cost = (($from_currency_rate / $to_currency_rate) * $tariff_data[0]->total_cost) * $vehicle_count_arr[$i];
				$arr1 = array(
					'bus_name' => $q_transport['vehicle_name'],
					'bus_id' => $q_transport['entry_id'],
					'package_name' => $ppackage_name_arr[$i],
					'package_id' => (int)($ppackage_id_arr[$i]),
					'total_cost'=> $total_cost,
					'skip'=>false
				);
				array_push($transport_info_arr, $arr1);
			}
		}
		else{
			//$skip = ($count == 0) ? false:true;
			$arr1 = array(
				'bus_name' => $q_transport['vehicle_name'],
				'bus_id' => $q_transport['entry_id'],
				'package_name' => $ppackage_name_arr[$i],
				'package_id' => (int)($ppackage_id_arr[$i]),
				'total_cost'=> 0,
				'skip'=>true
			);
			array_push($transport_info_arr, $arr1);
		}
	}
}
foreach ($transport_info_arr as $key => $element) {
    if (!$element['skip'] && $flag == 0) {
		array_push($transport_info_arr1, $transport_info_arr[$key]);
    }
}
echo json_encode($transport_info_arr1);
?>