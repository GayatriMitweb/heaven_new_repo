<?php
include "../../../../../model/model.php";

$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));

$enquiry_content = $sq_enq['enquiry_content'];
 
$enquiry_content_arr1 = json_decode($enquiry_content, true);	
foreach($enquiry_content_arr1 as $enquiry_content_arr2){
	if($enquiry_content_arr2['name']=="total_pax"){ $sq_enq['total_pax'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="days_of_traveling"){ $sq_enq['days_of_traveling'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="traveling_date"){ $sq_enq['traveling_date'] = get_datetime_user($enquiry_content_arr2['value']); }
	if($enquiry_content_arr2['name']=="vehicle_type"){ $sq_enq['vehicle_type'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="travel_type"){ $sq_enq['travel_type'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="places_to_visit"){ $sq_enq['places_to_visit'] = $enquiry_content_arr2['value']; }
}

echo json_encode($sq_enq);
exit;
?>