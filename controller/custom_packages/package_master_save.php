<?php
include "../../model/model.php"; 
include "../../model/custom_packages/package_master.php"; 

$dest_id = $_POST['dest_id'];
$tour_type = $_POST['tour_type'];
$package_code = $_POST['package_code'];
$package_name = $_POST['package_name'];
$total_days = $_POST['total_days'];
$total_nights = $_POST['total_nights'];
$adult_cost = $_POST['adult_cost'];
$child_cost = $_POST['child_cost'];
$infant_cost = $_POST['infant_cost'];
$child_with = $_POST['child_with'];
$child_without = $_POST['child_without'];
$extra_bed = $_POST['extra_bed'];
$inclusions = $_POST['inclusions'];
$exclusions = $_POST['exclusions'];

$day_program_arr = $_POST['day_program_arr'];
$special_attaraction_arr = $_POST['special_attaraction_arr'];
$overnight_stay_arr = $_POST['overnight_stay_arr'];
$meal_plan_arr = $_POST['meal_plan_arr'];

$city_name_arr = $_POST['city_name_arr'];
$hotel_name_arr = $_POST['hotel_name_arr'];
$hotel_type_arr = $_POST['hotel_type_arr'];
$total_days_arr = $_POST['total_days_arr'];

$vehicle_name_arr = $_POST['vehicle_name_arr'];
$drop_arr = $_POST['drop_arr'];
$pickup_arr = $_POST['pickup_arr'];
$drop_type_arr = $_POST['drop_type_arr'];
$pickup_type_arr = $_POST['pickup_type_arr'];
$status = $_POST['status'];

$package_master = new custom_package();
$currency_id = $_POST['currency_id'];
$taxation_type = $_POST['taxation_type'];
$taxation_id = $_POST['taxation_id'];
$service_tax = $_POST['service_tax'];

$package_master->package_master_save($tour_type,$dest_id,$package_code,$package_name,$total_days,$total_nights,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr, $hotel_type_arr,$total_days_arr,$vehicle_name_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr, $day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax);
?>