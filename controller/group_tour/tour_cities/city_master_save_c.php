<?php
include "../../../model/model.php"; 
include "../../../model/group_tour/tour_cities/city_master.php"; 

$city_name = $_POST["city_name"];
$active_flag_arr = $_POST['active_flag_arr'];

$city_master = new city_master();
$city_master->city_master_save($city_name, $active_flag_arr);
?>