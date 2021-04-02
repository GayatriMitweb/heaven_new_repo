<?php 
include_once('../../../../../model/model.php');

$group_id = $_POST['group_id'];
$hotel_info_arr = array();

$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$group_id'"));

$query = "select * from group_tour_hotel_entries where tour_id='$sq_group[tour_id]'";

$sq_hotel = mysql_query($query);

	while($row_hotel = mysql_fetch_assoc($sq_hotel)){
        $city_names = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id = ".$row_hotel['city_id']));
        $hotel_names = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id = ".$row_hotel['hotel_id']));
        $hotel_type = $row_hotel['hotel_type'];
		$total_nights = $row_hotel['total_nights'];
		$arr = array(
			'city_names' => $city_names['city_name'],
			'hotel_names' => $hotel_names['hotel_name'],
			'hotel_type' => $row_hotel['hotel_type'],			
			'total_nights' => $row_hotel['total_nights'],
		);
	 array_push($hotel_info_arr, $arr);
	}


echo json_encode($hotel_info_arr);
?>