<?php
include "../../../../model/model.php";
$term = $_REQUEST['request'];


$query = mysql_query("SELECT city.*, airport.* FROM `airport_master` AS `airport`  INNER JOIN  `city_master` AS `city` ON airport.city_id=city.city_id  WHERE (city.active_flag = 'Active' AND airport.flag = 'Active') AND (city.city_name LIKE '%$term%'  OR airport.airport_name LIKE '%$term%' OR airport.airport_code LIKE '%$term%')");

$final_array = array();
while($airports = mysql_fetch_assoc($query)){
    $value = $airports['city_name']." - ".$airports['airport_name']. " (".$airports['airport_code'].")";
    $to_be_push = array(
        "value" => $value,
        "label" => $value,
        "city_id" => $airports['city_id']
    );
    array_push($final_array, $to_be_push);
}

echo json_encode($final_array);
?>