<?php
include "../../model/model.php";
include "../../model/custom_packages/package_master.php"; 

$package_id1 = $_POST['package_id'];
$dest_id = $_POST['dest_id'];
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
$transport_id = $_POST['transport_id'];
$inclusions = $_POST['inclusions'];
$exclusions = $_POST['exclusions'];
$entry_id_arr = $_POST['entry_id_arr'];
$hotel_entry_id_arr = $_POST['hotel_entry_id_arr'];
$checked_programe_arr = $_POST['checked_programe_arr'];

$day_program_arr = $_POST['day_program_arr'];
$special_attaraction_arr = $_POST['special_attaraction_arr'];
$overnight_stay_arr = $_POST['overnight_stay_arr'];
$meal_plan_arr = $_POST['meal_plan_arr'];

$city_name_arr = $_POST['city_name_arr'];
$hotel_name_arr = $_POST['hotel_name_arr'];
$hotel_type_arr = $_POST['hotel_type_arr'];
$total_days_arr = $_POST['total_days_arr'];
$hotel_check_arr = $_POST['hotel_check_arr'];
$status = $_POST['status'];

$vehicle_name_arr = $_POST['vehicle_name_arr'];
$vehicle_check_arr = $_POST['vehicle_check_arr'];
$drop_arr = $_POST['drop_arr'];
$drop_type_arr = $_POST['drop_type_arr'];
$pickup_arr = $_POST['pickup_arr'];
$pickup_type_arr = $_POST['pickup_type_arr'];
$tr_entry_arr = $_POST['tr_entry_arr'];

$currency_id = $_POST['currency_id'];
$taxation_type = $_POST['taxation_type'];
$taxation_id = $_POST['taxation_id'];
$service_tax = $_POST['service_tax'];

$package_master1 = new custom_package();

$package_master1->package_master_update($package_id1,$dest_id,$package_code,$package_name,$total_days,$total_nights,$transport_id,$inclusions,$exclusions, $status ,$city_name_arr, $hotel_name_arr,$hotel_type_arr,$total_days_arr,$hotel_check_arr,$vehicle_name_arr,$vehicle_check_arr,$drop_arr,$drop_type_arr,$pickup_arr,$pickup_type_arr,$tr_entry_arr,$checked_programe_arr, $day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$entry_id_arr,$hotel_entry_id_arr,$adult_cost,$child_cost,$infant_cost,$child_with,$child_without,$extra_bed,$currency_id,$taxation_type,$taxation_id,$service_tax);
?>