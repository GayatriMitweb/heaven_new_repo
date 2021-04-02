<?php
include "../../../../model/model.php";
$quotation_id = $_GET['quotation_id'];
$query = mysql_query("SELECT * from `flight_quotation_plane_entries` where `quotation_id` = ".$quotation_id);
$final_array = array();
while($quot_data = mysql_fetch_assoc($query)){

    $airline_name = mysql_fetch_assoc(mysql_query("SELECT * FROM `airline_master` WHERE airline_id = ".$quot_data['airline_name']));
    $quot_data['airline_name'] = $airline_name['airline_name']." (".$airline_name['airline_code'].")";

    $from_city = mysql_fetch_assoc(mysql_query("SELECT * FROM `city_master` WHERE `city_id` = ".$quot_data['from_city']));
    $quot_data['from_city_show'] = $from_city['city_name'];

    $to_city = mysql_fetch_assoc(mysql_query("SELECT * FROM `city_master` WHERE `city_id` = ".$quot_data['to_city']));
    $quot_data['to_city_show'] = $to_city['city_name'];

    array_push($final_array, $quot_data);
}
echo json_encode($final_array);
?>