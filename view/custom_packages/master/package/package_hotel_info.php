<?php
include_once("../../../../model/model.php");
$hotel_name_arr = $_POST['hotel_name_arr'];
$hotel_info_arr = array();

for($i=0; $i<sizeof($hotel_name_arr); $i++)
{
 $sq_hotel_id = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id = '$hotel_name_arr[$i]'"));
 $hotel_name = $sq_hotel_id['hotel_name'];

		$hotel_arr = array(
			'hotel_name1' => $hotel_name,
			'hotel_id' => $hotel_name_arr[$i]
		);
	 array_push($hotel_info_arr, $hotel_arr);
}


echo json_encode($hotel_info_arr);
?>