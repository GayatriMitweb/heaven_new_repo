<?php
include "../../../../../model/model.php";

$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));

$enquiry_content = $sq_enq['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	
foreach($enquiry_content_arr1 as $enquiry_content_arr2){
	if($enquiry_content_arr2['name']=="travel_from_date"){ $sq_enq['travel_from_date'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="travel_to_date"){ $sq_enq['travel_to_date'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_members"){ $sq_enq['total_members'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_adult"){ $sq_enq['total_adult'] = $enquiry_content_arr2['value']; }
	// if($enquiry_content_arr2['name']=="total_children"){ $sq_enq['total_children'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_infant"){ $sq_enq['total_infant'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="hotel_type"){ $sq_enq['hotel_type'] = $enquiry_content_arr2['value']; }
}
$sq_enq['enquiry_specification'] = $sq_enq['enquiry_specification']; 

echo json_encode($sq_enq);
exit;
?>