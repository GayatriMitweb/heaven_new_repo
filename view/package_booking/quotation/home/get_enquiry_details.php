<?php
include "../../../model/model.php";

$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));

$enquiry_content = $sq_enq['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	
foreach($enquiry_content_arr1 as $enquiry_content_arr2){
	if($enquiry_content_arr2['name']=="tour_name"){ $sq_enq['tour_name'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="budget"){ $sq_enq['budget'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_members"){ $sq_enq['total_members'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_adult"){ $sq_enq['total_adult'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_infant"){ $sq_enq['total_infant'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="children_without_bed"){ $sq_enq['children_without_bed'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="children_with_bed"){ $sq_enq['children_with_bed'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="travel_from_date"){ $sq_enq['travel_from_date'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="travel_to_date"){ $sq_enq['travel_to_date'] = $enquiry_content_arr2['value']; }
}

echo json_encode($sq_enq);
exit;
?>