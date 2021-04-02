<?php 
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');

$quotation_for = $_POST['quotation_for'];
$enquiry_id = $_POST['enquiry_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$array_s = array();
$temp_arr = array();

$query = "select * from vendor_reply_master where 1 ";

if($quotation_for!=""){
	$query .= " and quotation_for='$quotation_for'";	
}
if($enquiry_id!=""){
	$query .= " and request_id in(select request_id from vendor_request_master where enquiry_id='$enquiry_id') ";
}
 
$query .= "  order by created_at desc";

$count = 0;
$sq_req = mysql_query($query);
while($row_req = mysql_fetch_assoc($sq_req)){
	$sq_request = mysql_fetch_assoc(mysql_query("select city_id,quotation_for from vendor_request_master where request_id='$row_req[request_id]' "));
	
	if($sq_request['quotation_for'] == 'Hotel'){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select city_id from hotel_master where hotel_id='$row_req[supplier_id]'"));
	}
	if($sq_request['quotation_for'] == 'DMC'){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select city_id from dmc_master where dmc_id='$row_req[supplier_id]'"));
	}
	if($sq_request['quotation_for'] == 'Transport'){
		$sq_hotel = mysql_fetch_assoc(mysql_query("select city_id from transport_agency_master where transport_agency_id='$row_req[supplier_id]'"));
	}
	$sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
	$vendor_type_val = get_vendor_name($row_req['quotation_for'], $row_req['supplier_id']);
	

	$temp_arr = array( "data" => array(
		(int)(++$count),
		date('d/m/Y', strtotime($row_req['created_at'])),
		$sq_city['city_name'],
		$vendor_type_val,
		$row_req['total_cost'],
		'<button class="btn btn-info btn-sm" onclick="view_modal('. $row_req['id'] .')" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></button>'
	), "bg" =>$bg);
	array_push($array_s,$temp_arr); 


}
echo json_encode($array_s);
?>

