<?php
include "../../../../model/model.php";
global $encrypt_decrypt,$secret_key;

$customer_id = $_POST['customer_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$train_ticket_id=$_POST['train_ticket_id'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from train_ticket_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}		
if($train_ticket_id!="")
{
	$query .= " and train_ticket_id='$train_ticket_id'";
}
if($from_date!="" && $to_date!=""){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and created_at between '$from_date' and '$to_date'";
}		
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by train_ticket_id desc";
$count = 0;
$total_sale = 0;
$total_cancelation_amount = 0;
$array_s = array();
$temp_arr = array();
$footer_data = array();
$total_balance = 0;
$sq_ticket = mysql_query($query);

while($row_ticket = mysql_fetch_assoc($sq_ticket)){
	$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_ticket[emp_id]'"));
	$emp_name = ($row_ticket['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

	$pass_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));
	$cancel_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$row_ticket[train_ticket_id]' and status='Cancel'"));
	if($pass_count==$cancel_count) 	{
		$bg="danger";
	}
	else  {
		$bg="#fff";
	}

	$date = $row_ticket['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	if($sq_customer_info['type']=='Corporate'){
		$customer_name = $sq_customer_info['company_name'];
	}else{
		$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	}

	$sq_train_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$row_ticket[train_ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];

	$paid_amount = $sq_paid_amount['sum'];
	$paid_amount = ($paid_amount == '')?0:$paid_amount;
	$sale_amount = $row_ticket['net_total']-$row_ticket['cancel_amount'];
	$bal_amount = $sale_amount - $paid_amount;

	$cancel_amt = $row_ticket['cancel_amount'];
	if($cancel_amt == ""){ $cancel_amt = 0;}
	
	$total_sale = $total_sale+$row_ticket['net_total']+$credit_card_charges;
	$total_cancelation_amount = $total_cancelation_amount+$cancel_amt;
	$total_balance = $total_balance+$sale_amount;	

	$invoice_no = get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year);
	$invoice_date = date('d-m-Y',strtotime($row_ticket['created_at']));
	$customer_id = $row_ticket['customer_id'];
	$service_name = "Train Invoice";
	$train_ticket_id = $row_ticket['train_ticket_id'];
	$taxation_type = $row_ticket['taxation_type'];
	$service_tax_per = $row_ticket['service_tax'];
	$service_charge =  $row_ticket['service_charge'];
	$service_tax = $row_ticket['service_tax_subtotal'];
	
	$basic_cost = $row_ticket['basic_fair'] - $row_ticket['cancel_amount'];
	$net_amount = $row_ticket['net_total'] - $row_ticket['cancel_amount'];

	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Train'"));   
	$sac_code = $sq_sac['hsn_sac_code'];

	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&service_charge=$service_charge&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&train_ticket_id=$train_ticket_id&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&pass_count=$pass_count&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/train_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&service_charge=$service_charge&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&train_ticket_id=$train_ticket_id&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&credit_card_charges=$credit_card_charges";
	
	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year),
		$customer_name,
		$contact_no,
		$sq_train_info['train_no'],
		$row_ticket['type_of_tour'],
		number_format($row_ticket['net_total']+$credit_card_charges,2),
		$cancel_amt,
		number_format(($row_ticket['net_total']-$row_ticket['cancel_amount']+$credit_card_charges), 2),
		$emp_name,
		'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" title="Download Invoice"><i class="fa fa-print"></i></a>
		
		<button class="btn btn-info btn-sm" onclick="train_ticket_view_modal('. $row_ticket['train_ticket_id'] .')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>

		<button class="btn btn-info btn-sm" onclick="train_ticket_update_modal('. $row_ticket['train_ticket_id'] .')"  data-toggle="tooltip" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
		), "bg" =>$bg );
		array_push($array_s,$temp_arr); 
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	'foot0' => "Total",
	'col0' => 6,
	'class0' => "text-right",
	'foot1' => number_format($total_sale, 2),
	'col1' => 1,
	'class1' => "info",
	'foot2' =>  number_format($total_cancelation_amount, 2),
	'col2' => 1,
	'class2' => "danger",
	'foot3' => number_format($total_balance, 2),
	'col3' => 1,
	'class3' => "success",
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);	
?>