<?php
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$branch_status = $_POST['branch_status']; 
$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];
$estimate_type = $_POST['estimate_type'];
$estimate_type_id = $_POST['estimate_type_id'];
$array_s = array();
$temp_arr = array();
$query = "select * from vendor_payment_master where payment_amount!='0' ";
if($financial_year_id!=""){
	$query .= " and financial_year_id='$financial_year_id'";
}
if($vendor_type!=""){
	$query .= " and vendor_type='$vendor_type'";
}
if($vendor_type_id!=""){
	$query .= " and vendor_type_id='$vendor_type_id'";
}
if($estimate_type!=""){
	$query .= " and estimate_type='$estimate_type'";
}
if($estimate_type_id!=""){
	$query .= " and estimate_type_id='$estimate_type_id'";
}

include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by payment_id desc ";
$total_paid_amt = 0;
$count = 0;

$sq_payment = mysql_query($query);		
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$total_payment=0;
while($row_payment = mysql_fetch_assoc($sq_payment)){
	$vendor_type_val = get_vendor_name($row_payment['vendor_type'], $row_payment['vendor_type_id']);

	$total_payment = $total_payment + $row_payment['payment_amount'];
	$estimate_type_val = get_estimate_type_name($row_payment['estimate_type'], $row_payment['estimate_type_id']);
	if($row_payment['clearance_status']=="Pending"){ 
		$bg='warning';
		$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount'];
	}
	else if($row_payment['clearance_status']=="Cancelled"){ 
		$bg='danger';
		$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'];
	}
	else{
		$bg = '';
	}
	

	if($row_payment['payment_evidence_url']!=""){
		$url = explode('uploads', $row_payment['payment_evidence_url']);
		$url = BASE_URL.'uploads'.$url[1];
	}
	else{
		$url = "";
	}
	if($url!=""){
		$evidence = '<a class="btn btn-info btn-sm" href="\''. $url .'\'" download data-toggle="tooltip" title="Download Payment Evidence slip"><i class="fa fa-download"></i></a>';
	}else{
		$evidence = '';
	}
	$temp_arr = array( "data" => array(
		(int)(++$count),
		$row_payment['vendor_type'],
		$vendor_type_val,
		($row_payment['estimate_type'] =='')? 'NA': $row_payment['estimate_type'],
		($estimate_type_val == '') ? 'NA'  : $estimate_type_val ,
		date('d-m-Y', strtotime($row_payment['payment_date'])),
		$row_payment['payment_amount'],
		$row_payment['payment_mode'],
		$row_payment['bank_name'],
		$row_payment['transaction_id'],
		''.$evidence.'

		<button class="btn btn-info btn-sm" onclick="payment_update_modal('.$row_payment['payment_id'] .')" data-toggle="tooltip" title="Edit this payment"><i class="fa fa-pencil-square-o"></i></button>'
	
		), "bg" =>$bg);
	array_push($array_s,$temp_arr); 
	
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
			
	'foot0' => "Total Amount : ".number_format($total_payment, 2),
	'col0' => 3,
	'class0' => "text-right info",
	
	'foot1' => "Total Pending : ".number_format($sq_pending_amount, 2),
	'col1' => 3,
	'class1' => "text-right warning",

	'foot2' => "Total Cancel : ".number_format($sq_cancel_amount, 2),
	'col2' => 2,
	'class2' => "text-right danger",

	'foot3' => "Total Paid : ".number_format(($total_payment - $sq_pending_amount - $sq_cancel_amount),2),
	'col3' => 3,
	'class3' => "text-right success"

	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	


