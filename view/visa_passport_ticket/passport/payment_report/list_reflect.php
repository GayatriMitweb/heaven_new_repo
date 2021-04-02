<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$passport_id = $_POST['passport_id'];
$payment_from_date = $_POST['payment_from_date'];
$payment_to_date = $_POST['payment_to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$booker_id = $_POST['booker_id'];
$branch_id = $_POST['branch_id'];
$array_s = array();
$temp_arr = array();
$query = "select * from passport_master where 1 ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($passport_id!=""){
	$query .= " and passport_id='$passport_id'";
}
if($payment_from_date!='' && $payment_to_date!=''){
	$payment_from_date = get_date_db($payment_from_date);
	$payment_to_date = get_date_db($payment_to_date);
	$query .=" and created_at between '$payment_from_date' and '$payment_to_date'";
}
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($booker_id!=""){
	$query .= " and emp_id='$booker_id'";
}
if($branch_id!=""){
	$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_id')";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by passport_id desc ";
$count = 0;
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;

$sq_passport = mysql_query($query);
$refund_amount=0;
$paid_amount=0;
$total_balance=0;
while($row_passport = mysql_fetch_assoc($sq_passport)){

	$pass_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]'"));
	$cancel_count = mysql_num_rows(mysql_query("select * from  passport_master_entries where passport_id='$row_passport[passport_id]' and status='Cancel'"));
	if($pass_count==$cancel_count){
		$bg="danger";
	}
	else {
		$bg="#fff";
	}
	$date = $row_passport['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
	if($sq_customer_info['type']=='Corporate'){
		$customer_name = $sq_customer_info['company_name'];
	}else{
		$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	}
	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_passport[emp_id]'"));
	if($sq_emp['first_name'] == '') { $emp_name='Admin';}
	else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

	$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
	$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
	$sq_total_member = mysql_num_rows(mysql_query("select passport_id from passport_master_entries where passport_id = '$row_passport[passport_id]' AND status!='Cancel'"));

	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];
	$paid_amount = $sq_paid_amount['sum'];		
	if($paid_amount==""){ $paid_amount=0; } 	
	$sale_amount =$row_passport['passport_total_cost'] + $credit_card_charges;
	$cancel_amount = $row_passport['cancel_amount'];
	$total_bal = $sale_amount - $cancel_amount;	
	$bal_amount = $total_bal - $paid_amount;

	if($bal_amount>=0){
		$total_balance = $total_balance+$bal_amount;
	}
	else{
		$refund_amount = $refund_amount +abs($bal_amount);
	}	
	if($paid_amount > 0){
		if($pass_count==$cancel_count){
			$bal = 0;
		}else{
			$bal = $total_bal - $paid_amount;
		}
	}else{
		$bal = $cancel_amount;
	}
	//Footer
	$cancel_total = $cancel_total + $cancel_amount;
	$sale_total = $sale_total + $total_bal;
	$paid_total = $paid_total + $paid_amount+$credit_card_charges;
	$balance_total = $balance_total + $bal;
	/////// Purchase ////////
	$total_purchase = 0;
	$purchase_amt = 0;
	$i=0;
	$p_due_date = '';
	$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Passport Booking' and estimate_type_id='$row_passport[passport_id]'"));
	if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
	$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Passport Booking' and estimate_type_id='$row_passport[passport_id]'");
	while($row_purchase = mysql_fetch_assoc($sq_purchase)){
		$p_due_date = get_date_user($row_purchase['due_date']);			
		$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
		$total_purchase = $total_purchase + $purchase_amt;
	}
	$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Passport Booking' and estimate_type_id='$row_passport[passport_id]'"));		
	$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
	if($vendor_name == ''){ $vendor_name1 = 'NA';  }
	else{ $vendor_name1 = $vendor_name; }

	// Invoice
	$date = $row_passport['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sale_amount = $row_passport['passport_total_cost']-$row_passport['cancel_amount'] + $credit_card_charges;
	$bal_amount = $sale_amount - $paid_amount;

	$cancel_amt = $row_passport['cancel_amount'];
	if($cancel_amt == ""){ $cancel_amt = 0;}

	$total_sale = $total_sale+$row_passport['passport_total_cost'] + $credit_card_charges;
	$total_cancelation_amount = $total_cancelation_amount+$cancel_amt;
	$total_balance = $total_balance + $sale_amount;

	$invoice_no = get_passport_booking_id($row_passport['passport_id'],$year);
	$passport_id = $row_passport['passport_id'];
	$invoice_date = date('d-m-Y',strtotime($row_passport['created_at']));
	$customer_id = $row_passport['customer_id'];
	$service_name = "Passport Invoice";
	//**Service Tax
	$taxation_type = $row_passport['taxation_type'];
	$service_tax_per = $row_passport['service_tax'];
	$service_tax = $row_passport['service_tax_subtotal'];
	//**Basic Cost
	$basic_cost = $row_passport['passport_issue_amount'] - $row_passport['cancel_amount'];
	$service_charge = $row_passport['service_charge'];
	$net_amount1 = $row_passport['passport_total_cost'] - $row_passport['cancel_amount'];	

	$roundoff = $row_passport['roundoff'];
	$bsmValues = $row_passport['bsm_values'];
	$bsmValues = http_build_query(array('bsmValues' => $bsmValues));
	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Passport'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount1&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&passport_id=$passport_id&pass_count=$pass_count&roundoff=$roundoff&$bsmValues&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/passport_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&passport_id=$passport_id&pass_count=$pass_count&roundoff=$roundoff&$bsmValues&credit_card_charges=$credit_card_charges";

	//Service Tax and Markup Tax
	$service_tax_amount = 0;
	if($row_passport['service_tax_subtotal'] !== 0.00 && ($row_passport['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_passport['service_tax_subtotal']);
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		}
	}
	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_passport_booking_id($row_passport['passport_id'],$year),
		$customer_name,
		$contact_no,
		$email_id,
		$sq_total_member,
		get_date_user($row_passport['created_at']),
		'<button class="btn btn-info btn-sm" onclick="passport_view_modal('. $row_passport['passport_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
		number_format($row_passport['passport_issue_amount'],2),
		number_format($row_passport['service_charge'],2),
		number_format($service_tax_amount,2),
		number_format($credit_card_charges,2),
		number_format($row_passport['passport_total_cost']+$credit_card_charges,2),
		number_format($cancel_amount, 2),
		number_format($total_bal, 2),
		number_format($paid_amount+$credit_card_charges, 2),
		'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_passport['passport_id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
		number_format($bal, 2),
		($row_passport['due_date'] == '1970-01-01') ? 'NA' : get_date_user($row_passport['due_date']),
		number_format($total_purchase,2),
		'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_passport['passport_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
		$branch_name,
		$emp_name,
		'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download Invoice"><i class="fa fa-print"></i></a>'
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 5,
	'foot0' => "",
	'col0' =>11,
	'class0' =>"",

	'foot1' => "TOTAL CANCEL : ".number_format($cancel_total,2),
	'col1' => 2,
	'class1' =>"danger text-right",
	
	'foot2' => "TOTAL SALE :".number_format($sale_total,2),
	'col2' => 2,
	'class2' =>"info text-right",

	'foot3' => "TOTAL PAID : ".number_format($paid_total,2),
	'col3' => 2,
	'class3' =>"success text-right",

	'foot4' => "TOTAL BALANCE : ".number_format($balance_total,2),
	'col4' => 2,
	'class4' =>"warning text-right",

	'foot5' => "",
	'col5' => 4,
	'class5' =>""

	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>