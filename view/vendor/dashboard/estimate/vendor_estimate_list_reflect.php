<?php 
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$estimate_type = $_POST['estimate_type'];
$vendor_type = $_POST['vendor_type'];
$estimate_type_id = $_POST['estimate_type_id'];
$vendor_type_id = $_POST['vendor_type_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from vendor_estimate where financial_year_id='$financial_year_id' ";
if($estimate_type!=""){
	$query .= "and estimate_type='$estimate_type'";
}
if($vendor_type!=""){
	$query .= "and vendor_type='$vendor_type'";
}
if($estimate_type_id!=""){
	$query .= "and estimate_type_id='$estimate_type_id'";
}
if($vendor_type_id!=""){
	$query .= "and vendor_type_id='$vendor_type_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by estimate_id desc";
		
$total_estimate_amt = 0;
$count = 0;
$sq_estimate = mysql_query($query);
while($row_estimate = mysql_fetch_assoc($sq_estimate)){
	$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_estimate[emp_id]'"));
	$emp_name = ($row_estimate['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
	$date = $row_estimate['purchase_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$total_estimate_amt = $total_estimate_amt + $row_estimate['net_total'];
	$total_cancel_amt += $row_estimate['cancel_amount'];

	$estimate_type_val = get_estimate_type_name($row_estimate['estimate_type'], $row_estimate['estimate_type_id']);
	$vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);

	$purchase_amount=$row_estimate['net_total']-$row_estimate['cancel_amount'];
	$total_purchase_amt += $purchase_amount;

	$sq_paid_amount_query = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from vendor_payment_master where vendor_type='$row_estimate[vendor_type]' and vendor_type_id='$row_estimate[vendor_type_id]' and estimate_type='$row_estimate[estimate_type]' and estimate_type_id='$row_estimate[estimate_type_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$total_paid_amt += $sq_paid_amount_query['sum'];
	if($total_paid_amt==""){ $total_paid_amt = 0; }

	$bg = ($row_estimate['status']=="Cancel") ? "danger" : "";

	$newUrl = $row_estimate['invoice_proof_url'];
	if($newUrl!=""){
		$newUrl = preg_replace('/(\/+)/','/',$row_estimate['invoice_proof_url']); 
		$newUrl_arr = explode('uploads/', $newUrl);
		$newUrl1 = BASE_URL.'uploads/'.$newUrl_arr[1];	
	}	
	if($newUrl!=""){
		$evidence = '<a class="btn btn-info btn-sm" href="'. $newUrl1 .'" download data-toggle="tooltip" title="Download Payment Evidence slip"><i class="fa fa-download"></i></a>';
	}else{
		$evidence = '';
	}					
	$temp_arr = array( "data" => array(
		(int)(++$count),
		$row_estimate['estimate_type'],
		$estimate_type_val,
		$row_estimate['vendor_type'],
		$vendor_type_val,
		$row_estimate['remark'],
		number_format($purchase_amount, 2),
		($row_estimate['cancel_amount']=="") ? 0 : $row_estimate['cancel_amount'],
		$row_estimate['net_total'],
		'<button class="btn btn-info btn-sm" onclick="vendor_estimate_update_modal('. $row_estimate['estimate_id'] .')" data-toggle="tooltip" title="Edit this Purchase"><i class="fa fa-pencil-square-o"></i></button>

		'.$evidence.'

		<button class="btn btn-danger btn-sm" onclick="vendor_estimate_cancel('.$row_estimate['estimate_id'] .')" data-toggle="tooltip" title="Cancel this Purchase"><i class="fa fa-ban"></i></button>',
		$emp_name 
		), "bg" =>$bg);
	array_push($array_s,$temp_arr); 					
}
$footer_data = array("footer_data" => array(
	'total_footers' => 5,
	
	'foot0' => "Total Amount : ".number_format($total_estimate_amt, 2),
	'col0' => 4,
	'class0' =>"text-right info",

	'foot1' => "Total Cancel : ".number_format($total_cancel_amt, 2),
	'col1' => 2,
	'class1' =>"text-left danger",

	'foot2' => "Total Purchase : ".number_format($total_purchase_amt, 2),
	'col2' => 2,
	'class2' =>"info",

	'foot3' => "Total Paid : ".number_format($total_paid_amt, 2),
	'col3' => 1,
	'class3' =>"success",

	'foot4' => "Balance : ".number_format(($total_estimate_amt - $total_cancel_amt - $total_paid_amt), 2),
	'col4' => 2,
	'class4' =>"warning"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
