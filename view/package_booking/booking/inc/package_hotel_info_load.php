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
    // Pickup
    if($row_tr['pickup_type'] == 'city'){
      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_tr[pickup]'"));
      $pickup = $row['city_name'];
      $pickup_id = $row['city_id'];
    }
    else if($row_tr['pickup_type'] == 'hotel'){
      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_tr[pickup]'"));
      $pickup_id = $row['hotel_id'];
      $pickup = $row['hotel_name'];
    }
    else{
      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_tr[pickup]'"));
      $airport_nam = clean($row['airport_name']);
      $airport_code = clean($row['airport_code']);
      $pickup = $airport_nam." (".$airport_code.")";
      $pickup_id = $row['airport_id'];
    }
    // Drop
    if($row_tr['drop_type'] == 'city'){
      $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$row_tr[drop]'"));
      $drop = $row['city_name'];
      $drop_id = $row['city_id'];
    }
    else if($row_tr['drop_type'] == 'hotel'){
      $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$row_tr[drop]'"));
      $drop = $row['hotel_name'];
      $drop_id = $row['hotel_id'];
    }
    else{
      $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$row_tr[drop]'"));
      $airport_nam = clean($row['airport_name']);
      $airport_code = clean($row['airport_code']);
      $drop = $airport_nam." (".$airport_code.")";
      $drop = $drop;
      $drop_id = $row['airport_id'];
    }
    $pickup_type = $row_tr['pickup_type'];
    $drop_type = $row_tr['drop_type'];

    $arr1 = array(
      'bus_name' => $bus_name,
      'vehicle_id' => $row_tr['vehicle_name'],
      'pickup' => $pickup,
      'drop' => $drop,
      'pickup_id' => $pickup_id,
      'drop_id' => $drop_id,
      'pickup_type' => $pickup_type,
      'drop_type' => $drop_type
    );
    array_push($tr_info_arr1, $arr1);
}

$hotel_info_arr['hotel_info_arr'] = $hotel_info_arr1;
$hotel_info_arr['transport_info_arr'] = $tr_info_arr1;
$hotel_info_arr['package_name'] = $query['package_name'];

echo json_encode($hotel_info_arr);
?>