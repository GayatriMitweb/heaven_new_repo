<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$active_flag = $_POST['active_flag'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$branch_status = $_POST['branch_status'];
$branch_id = $_POST['branch_id'];

$array_s = array();
$temp_arr = array();

$query = "select * from customer_master where 1 ";
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($cust_type != ""){
	$query .=" and type = '$cust_type' ";
}
if($company_name != ""){
	$query .=" and company_name='$company_name' ";
}
if($branch_status=='yes' && $role!='Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}
if($branch_id!=""){
	$query .= " and branch_admin_id = '$branch_id'";
} 
 
$count = 0;
$sq_customer = mysql_query($query);
while($row_customer = mysql_fetch_assoc($sq_customer)){
	$count++;
	$bg = ($row_customer['active_flag']=="Inactive") ? "danger" : "";
	$contact_no = $encrypt_decrypt->fnDecrypt($row_customer['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($row_customer['email_id'], $secret_key);
	$masked =  str_pad(substr($contact_no, -4), strlen($contact_no), '*', STR_PAD_LEFT);
	$masked_email =  str_pad(substr($email_id, 4), strlen($email_id), '*', STR_PAD_LEFT);
	$birth_date =  ($row_customer['birth_date'] == '1970-01-01') ? 'NA': get_date_user($row_customer['birth_date']);
	$masked_email1 =  ($masked_email == "") ? 'NA' : $masked_email;

	$temp_arr = array("data" =>array(
		(int)($count), $row_customer['first_name'].' '.$row_customer['last_name'],$birth_date,
		'<span onclick="showNum(' .$count. ');" id="phone-y'. $count.'" class="row_value phone">'.$masked.'</span><span id="phone-x'. $count.'" class="hidden" >'.$contact_no.'</span>',
		'<span onclick="showEmail('. $count.');" id="phone-ye'. $count.'" class="row_value phone">'. $masked_email1 .'</span><span id="phone-xe'. $count.'" class="hidden" >'. $email_id.'</span>',
		'<button class="btn btn-info btn-sm" onclick="customer_display_modal('. $row_customer['customer_id'] .')" title="View Details" data-toggle="tooltip"><i class="fa fa-eye"></i></button><button class="btn btn-info btn-sm" onclick="customer_update_modal('. $row_customer['customer_id'] .')" title="Edit Details" data-toggle="tooltip"><i class="fa fa-pencil-square-o"></i></button><button class="btn btn-info btn-sm" onclick="customer_history_modal('. $row_customer['customer_id'].' )" title="Download Outstanding Payment Summary" data-toggle="tooltip"><i class="fa fa-print"></i></button>'), "bg" => $bg
	);
	array_push($array_s,$temp_arr); 
}
echo json_encode($array_s);
//print_r($array_s);
?>