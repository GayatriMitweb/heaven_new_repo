<?php
include "../../../model/model.php";
global $app_quot_format,$whatsapp_switch;

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from hotel_availability_request where 1 and active_status='' ";
if($from_date!='' && $to_date!=""){
	$from_date = date('Y-m-d H:i', strtotime($from_date));
	$to_date = date('Y-m-d H:i', strtotime($to_date));
	$query .= " and created_at between '$from_date' and '$to_date' "; 
}
if($customer_id!=''){
	$query .= " and register_id in(select register_id from b2b_registration where customer_id = '$customer_id')";
}
$query .=" order by request_id desc ";

$count = 1;
$array_s = array();
$temp_arr = array();
$sq_request = mysql_query($query);
while($row_request = mysql_fetch_assoc($sq_request)){
	$row_reg = mysql_fetch_assoc(mysql_query("select cp_first_name,cp_last_name,mobile_no,email_id from b2b_registration where register_id = '$row_request[register_id]'"));
	$cart_data = json_encode($row_request['cart_data']);
	$response = json_decode($row_request['response']);
	if(sizeof(json_decode($row_request['cart_data'])) == sizeof($response))
		$status = 'success';
	else
		$status = '';
	$supplier_mail = $row_request['supplier_mail'];
	$temp_arr = array("data" => array(
		(int)($count),
		get_datetime_user($row_request['created_at']),
		$row_request['cust_name'],
		$row_reg['cp_first_name'].' '.$row_reg['cp_last_name'],
		$row_reg['mobile_no'],
		$row_reg['email_id'],
		'<button style="display:inline-block" class="btn btn-info btn-sm" onclick="supplier_request('.$row_request['request_id'] .','.$row_request['register_id'].','.$supplier_mail.')" id="mail'.$row_request['request_id'].'" title="Hotel Availability Request Mail to Supplier" data-toggle="tooltip"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button><button style="display:inline-block" class="btn btn-info btn-sm" onclick="view_request('.$row_request['request_id'] .')" id="edit'.$row_request['request_id'].'" title="Update Hotel Availability Request Status" data-toggle="tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button style="display:inline-block" class="btn btn-info btn-sm" onclick="agent_response('.$row_request['request_id'] .','.$row_request['register_id'].')" title="Hotel Availability Confirmation Mail to Agent" data-toggle="tooltip" id="agentmail'.$row_request['request_id'].'"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button><button style="display:inline-block" class="btn btn-info btn-sm" onclick="delete_request('.$row_request['request_id'] .')" title="Delete Request" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></button>'
		), "bg" =>$status);

	array_push($array_s,$temp_arr);
	$count++;
}
echo json_encode($array_s);
?>