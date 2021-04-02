<?php 
include "../../../model/model.php"; 
include "../../../model/group_tour/tours_master.php"; 

$tour_type = $_POST['tour_type'];
$tour_name = $_POST['tour_name'];
$adult_cost = $_POST['adult_cost'];
$child_with_cost = $_POST['child_with_cost'];
$child_without_cost = $_POST['child_without_cost'];
$infant_cost = $_POST['infant_cost'];
$with_bed_cost = $_POST['with_bed_cost'];
$active_flag = $_POST['active_flag'];
$visa_country_name =$_POST['visa_country_name'];
$company_name = $_POST['company_name'];
$inclusions = $_POST['inclusions'];
$exclusions = $_POST['exclusions'];
$pdf_url = $_POST['pdf_url'];

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$capacity = $_POST['capacity'];

$train_from_location_arr = $_POST['train_from_location_arr'];
$train_to_location_arr = $_POST['train_to_location_arr'];
$train_class_arr = $_POST['train_class_arr'];

$from_city_id_arr = $_POST['from_city_id_arr'];
$to_city_id_arr = $_POST['to_city_id_arr'];
$plane_from_location_arr = $_POST['plane_from_location_arr'];
$plane_to_location_arr = $_POST['plane_to_location_arr'];
$airline_name_arr = $_POST['airline_name_arr'];
$plane_class_arr = $_POST['plane_class_arr'];

$day_program_arr = $_POST['day_program_arr'];
$special_attaraction_arr = $_POST['special_attaraction_arr'];
$overnight_stay_arr = $_POST['overnight_stay_arr'];
$meal_plan_arr = $_POST['meal_plan_arr'];
$dest_name = $_POST['dest_name'];
$route_arr = $_POST['route_arr'];
$cabin_arr = $_POST['cabin_arr'];

$city_name_arr = $_POST['city_name_arr'];
$hotel_name_arr = $_POST['hotel_name_arr'];
$hotel_type_arr = $_POST['hotel_type_arr'];
$total_days_arr = $_POST['total_days_arr'];

$daywise_url = $_POST['daywise_url'];

$tours_master = new tours_master();
$tours_master->tour_master_save($tour_type, $tour_name, $adult_cost, $child_with_cost, $child_without_cost , $infant_cost, $with_bed_cost,$visa_country_name,$company_name, $from_date, $to_date, $capacity,$active_flag,$train_from_location_arr,$train_to_location_arr,$train_class_arr,$from_city_id_arr, $to_city_id_arr, $plane_from_location_arr,$plane_to_location_arr,$airline_name_arr,$plane_class_arr,$day_program_arr,$special_attaraction_arr,$overnight_stay_arr,$meal_plan_arr,$route_arr,$cabin_arr,$city_name_arr,$hotel_name_arr,$hotel_type_arr,$total_days_arr ,$inclusions, $exclusions,$pdf_url, $daywise_url,$dest_name);

?>