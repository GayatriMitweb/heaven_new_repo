<?php
include_once('../../../../model/model.php');

$package_id = $_POST['package_id'];
$hotel_info_arr = array();
$hotel_info_arr1 = array();
$tr_info_arr1 = array();


$query = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id='$package_id'"));
$sq_hotel = mysql_query("select * from custom_package_hotels where package_id='$package_id'");
while($row_hotel = mysql_fetch_assoc($sq_hotel)){
  
  $sq_hotel_id = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id = '$row_hotel[hotel_name]'"));
  $hotel_name1 = $sq_hotel_id['hotel_name'];
  $sq_city_id = mysql_fetch_assoc(mysql_query("select * from city_master where city_id = '$row_hotel[city_name]'"));
  $city_name1 = $sq_city_id['city_name'];

  $arr = array(
    'city_id' => $row_hotel['city_name'],
    'hotel_id1' => $row_hotel['hotel_name'],
    'city_name' => $city_name1,
    'hotel_name' => $hotel_name1
  );
  array_push($hotel_info_arr1, $arr);
}

$sq_tr = mysql_query("select * from custom_package_transport where package_id='$package_id'");
while($row_tr = mysql_fetch_assoc($sq_tr)){
  
  $sq_hotel_id = mysql_fetch_assoc(mysql_query("select * from b2b_transfer_master where entry_id = '$row_tr[vehicle_name]'"));
  $bus_name = $sq_hotel_id['vehicle_name'];

  $arr1 = array(
    'bus_name' => $bus_name,
    'bus_id' => $row_tr['vehicle_name'],
    'cost' => $row_tr['cost'],
  );
  array_push($tr_info_arr1, $arr1);
}

$hotel_info_arr['hotel_info_arr'] = $hotel_info_arr1;
$hotel_info_arr['transport_info_arr'] = $tr_info_arr1;
$hotel_info_arr['package_name'] = $query['package_name'];

echo json_encode($hotel_info_arr);
?>