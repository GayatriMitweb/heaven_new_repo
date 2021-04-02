<?php
include "../../../../../model/model.php";

$travel_type = $_POST['travel_type'];
$vehicle_name = $_POST['vehicle_name'];
$places_to_visit = $_POST['places_to_visit'];
$hotel_arr= array();

if($travel_type=='Local'){
    $q="select * from car_rental_tariff_entries where vehicle_name='$vehicle_name' and tour_type = '$travel_type' and status!='Inactive'";
    $sq = mysql_query($q);
}else{
    $q="select * from car_rental_tariff_entries where vehicle_name='$vehicle_name' and tour_type = '$travel_type' and route = '$places_to_visit' and status!='Inactive'";

    $sq = mysql_query($q);
}
while($sql_entries = mysql_fetch_assoc($sq)){
        
        $arr = array(
			
        'total_hrs' => $sql_entries['total_hrs'],
        'total_km' => $sql_entries['total_km'],
        'extra_hrs_rate' => $sql_entries['extra_hrs_rate'],
        'extra_km_rate' => $sql_entries['extra_km_rate'],
        'route' => $sql_entries['route'],
        'total_days' => $sql_entries['total_days'],
        'total_max_km' => $sql_entries['total_max_km'],
        'rate' => $sql_entries['rate'],
        'driver_allowance' => $sql_entries['driver_allowance'],
        'permit_charges' => $sql_entries['permit_charges'],
        'toll_parking' => $sql_entries['toll_parking'],
        'state_entry_pass' => $sql_entries['state_entry_pass'],
        'other_charges'	=> $sql_entries['other_charges']
		 	);
		array_push($hotel_arr, $arr);
	}
	
echo json_encode($hotel_arr);
?>