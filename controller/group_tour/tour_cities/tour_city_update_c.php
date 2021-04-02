<?php 
include "../../../model/model.php";
include "../../../model/group_tour/tour_cities/tour_cities_master.php";

$tour_city_id = $_POST["tour_city_id"];
$city_name = $_POST["city_name"];
$tour_id = $_POST["tour_id"];

$tour_cities_master = new tour_cities_master();
$tour_cities_master->tour_cities_update($tour_city_id, $city_name, $tour_id);
?>