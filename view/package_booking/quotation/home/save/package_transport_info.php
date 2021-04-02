<?php
include_once('../../../../../model/model.php');

//Get selected currency rate
global $currency;
$sq_to = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency'"));
$to_currency_rate = $sq_to['currency_rate'];

$package_id_arr = $_POST['package_id_arr'];
$from_date = get_date_db($_POST['from_date']);
$transport_info_arr = array();

for($i=0; $i<sizeof($package_id_arr); $i++){
	
	$sq_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id='$package_id_arr[$i]'"));
	$sq_transport = mysql_query("select * from custom_package_transport where package_id='$package_id_arr[$i]'");

	while($row_transport = mysql_fetch_assoc($sq_transport)){

		$row_tariff_master1 = mysql_query("select * from b2b_transfer_tariff where 1 and vehicle_id='$row_transport[vehicle_name]' order by tariff_id desc");
		while($row_tariff_master = mysql_fetch_assoc($row_tariff_master1)){
			$currency_id = $row_tariff_master['currency_id'];
			$sq_from = mysql_fetch_assoc(mysql_query("select currency_rate from roe_master where currency_id='$currency_id'"));
			$from_currency_rate = $sq_from['currency_rate'];
			$tariff_count = mysql_num_rows(mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$row_transport[pickup_type]' and drop_type = '$row_transport[drop_type]' and pickup_id = '$row_transport[pickup_id]' and drop_id = '$row_transport[drop_id]' and (from_date <='$from_date' and to_date>='$from_date')"));
			if($tariff_count != 0){
				$sq_tariff = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_tariff_entries where tariff_id='$row_tariff_master[tariff_id]' and pickup_type = '$row_transport[pickup_type]' and drop_type = '$row_transport[drop_type]' and pickup_id = '$row_transport[pickup_id]' and drop_id = '$row_transport[drop_id]' and (from_date <='$from_date' and to_date>='$from_date')"));
				$tariff_data = json_decode($sq_tariff['tariff_data']);
				$total_cost = $tariff_data[0]->total_cost;
				break;
			}else{
				$total_cost = 0;
				break;
			}
		}
		$q_transport = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id='$row_transport[vehicle_name]'"));
		// Pickup
		if($row_transport['pickup_type'] == 'city'){
			$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_transport[pickup]'"));
			$pickup = $row['city_name'];
			$pickup_id = $row['city_id'];
		}
		else if($row_transport['pickup_type'] == 'hotel'){
			$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_transport[pickup]'"));
			$pickup_id = $row['hotel_id'];
			$pickup = $row['hotel_name'];
		}
		else{
			$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_transport[pickup]'"));
			$airport_nam = clean($row['airport_name']);
			$airport_code = clean($row['airport_code']);
			$pickup = $airport_nam." (".$airport_code.")";
			$pickup = $pickup;
			$pickup_id = $row['airport_id'];
		}
		// Drop
		if($row_transport['drop_type'] == 'city'){
			$row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_transport[drop]'"));
			$drop = $row['city_name'];
			$drop_id = $row['city_id'];
		}
		else if($row_transport['drop_type'] == 'hotel'){
			$row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_transport[drop]'"));
			$drop = $row['hotel_name'];
			$drop_id = $row['hotel_id'];
		}
		else{
			$row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_transport[drop]'"));
			$airport_nam = clean($row['airport_name']);
			$airport_code = clean($row['airport_code']);
			$drop = $airport_nam." (".$airport_code.")";
			$drop = $drop;
			$drop_id = $row['airport_id'];
		}

		$arr1 = array(
			'bus_name' => $q_transport['vehicle_name'],
			'bus_id' => $q_transport['entry_id'],
			'package_name' => $sq_package['package_name'],
			'package_id' => $sq_package['package_id'],
			'pickup' => $pickup,
			'pickup_id' => $pickup_id,
			'drop'=> $drop,
			'drop_id'=> $drop_id,
			'total_cost'=>$total_cost,
			'pickup_type' => $row_transport['pickup_type'],
			'drop_type'=> $row_transport['drop_type']
		);	
		array_push($transport_info_arr, $arr1);
	}
}
echo json_encode($transport_info_arr);
?>