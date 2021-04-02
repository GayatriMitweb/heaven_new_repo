<?php
include "../../../model/model.php"; 
include "../../../model/group_tour/tour_cities/city_master.php"; 

$city_id = $_POST["city_id"];
$city_name = $_POST["city_name"];
$active_flag = $_POST['active_flag'];

$city_master = new city_master();
$city_master->city_master_update($city_id, $city_name, $active_flag);
?>