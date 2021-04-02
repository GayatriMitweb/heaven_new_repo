<?php
include "../../../../../model/model.php";

$enquiry_id = $_GET['enquiry_id'];
$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));

$enquiry_content = $sq_enq['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	
// foreach($enquiry_content_arr1 as $enquiry_content_arr2){
// 	if($enquiry_content_arr2['name']=="travel_datetime"){ $sq_enq['travel_datetime'] = $enquiry_content_arr2['value']; }
// 	if($enquiry_content_arr2['name']=="sector_from"){ 
// 		$sector_from = mysql_fetch_assoc(mysql_query("select airport_code,airport_name from airport_master where airport_id = ".$enquiry_content_arr2['value']));
// 		$sq_enq['sector_from'] = $sector_from['airport_name'];
// 		$sq_enq['sector_from_added'] = $sector_from['airport_name']."(".$sector_from['airport_code'].")";
// 		$sq_enq['from_city_name'] = mysql_fetch_assoc(mysql_query("select city_id from airport_master where airport_id = $enquiry_content_arr2[value]"));
	
// 	}
// 	if($enquiry_content_arr2['name']=="sector_to"){
// 		$sector_to = mysql_fetch_assoc(mysql_query("select airport_code,airport_name from airport_master where airport_id = ".$enquiry_content_arr2['value']));
// 		 $sq_enq['sector_to'] = $sector_to['airport_name'];
// 		 $sq_enq['sector_to_added'] = $sector_to['airport_name']."(".$sector_to['airport_code'].")";
// 		 $sq_enq['to_city_name'] = mysql_fetch_assoc(mysql_query("select city_id from airport_master where airport_id = $enquiry_content_arr2[value]"));
		
// 		}
// 	if($enquiry_content_arr2['name']=="preffered_airline"){ $sq_enq['preffered_airline_id'] = $enquiry_content_arr2['value'];
// 	$airline_name = mysql_fetch_assoc(mysql_query("select airline_name,airline_code from airline_master where airline_id = ".$enquiry_content_arr2[value]));
// 	$sq_enq['preffered_airline'] = $airline_name['airline_name']." (".$airline_name['airline_code'].")"; 
// 	}
// 	if($enquiry_content_arr2['name']=="class_type"){ $sq_enq['class_type'] = $enquiry_content_arr2['value']; }
// 	if($enquiry_content_arr2['name']=="trip_type"){ $sq_enq['trip_type'] = $enquiry_content_arr2['value']; }
// 	if($enquiry_content_arr2['name']=="total_seats"){ $sq_enq['total_seats'] = $enquiry_content_arr2['value'];
// 	 }
	 
// }
echo json_encode($sq_enq);
exit;
?>