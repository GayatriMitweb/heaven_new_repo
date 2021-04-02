<?php
include "../../../model/model.php";
$enquiry_id = $_POST['enquiry_id'];

$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
$enquiry_content = $sq_enq['enquiry_content'];
$enquiry_content_arr1 = json_decode($enquiry_content, true);	

foreach($enquiry_content_arr1 as $enquiry_content_arr2)
{
	if($enquiry_content_arr2['name']=="tour_name"){ $sq_enq1['tour_name'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="budget"){ $sq_enq1['budget'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_members"){ $sq_enq1['total_members'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_adult"){ $sq_enq1['total_adult'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_children"){ $sq_enq1['total_children'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="total_infant"){ $sq_enq1['total_infant'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="children_without_bed"){ $sq_enq1['children_without_bed'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="children_with_bed"){ $sq_enq1['children_with_bed'] = $enquiry_content_arr2['value']; }
	if($enquiry_content_arr2['name']=="travel_from_date"){ 
		$formatted = date('d-m-Y', strtotime($enquiry_content_arr2['value']));
		$sq_enq1['travel_from_date'] = $formatted; }
	if($enquiry_content_arr2['name']=="travel_to_date"){ 
		$formatted1 = date('d-m-Y', strtotime($enquiry_content_arr2['value']));
		$sq_enq1['travel_to_date'] = $formatted1; }
	if($enquiry_content_arr2['name']=="landline_no"){ $sq_enq1['landline_no'] = $enquiry_content_arr2['value']; }
}
$sq_enq1['name'] = $sq_enq['name'];
$sq_enq1['email_id'] = $sq_enq['email_id'];
$sq_enq1['landline_no'] = $sq_enq['landline_no'];
echo json_encode($sq_enq1);
exit;
?>