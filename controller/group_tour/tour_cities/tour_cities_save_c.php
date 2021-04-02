<?php 
include "../../../model/model.php";
include "../../../model/group_tour/tour_cities/tour_cities_master.php";

$tour_id = $_POST["tour_id"];
$city_name = $_POST["city_name"];

$tour_cities_master = new tour_cities_master();
$tour_cities_master->tour_cities_save($tour_id, $city_name);
?>