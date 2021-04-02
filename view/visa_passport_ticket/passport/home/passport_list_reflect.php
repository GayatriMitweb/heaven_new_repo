<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];
$passport_id = $_POST['passport_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$query = "select * from passport_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($passport_id!=""){
	$query .= " and passport_id='$passport_id'";
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
if($role == "B2b"){
	$query .= " and emp_id='$emp_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by passport_id desc ";
$count = 0;
$total_sale = 0;
$total_cancelation_amount = 0;
$total_balance = 0;
$array_s = array();
$temp_arr = array();
$footer_data = array();
$sq_passport = mysql_query($query);
while($row_passport = mysql_fetch_assoc($sq_passport)){
	$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_passport[emp_id]'"));
	$emp_name = ($row_passport['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

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
	$customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));
	if($customer_info['type']=='Corporate'){
		$customer_name = $customer_info['company_name'];
	}else{
		$customer_name = $customer_info['first_name'].' '.$customer_info['last_name'];
	}
	$contact = $encrypt_decrypt->fnDecrypt($customer_info['contact_no'], $secret_key); 
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(`credit_charges`) as sumc from passport_payment_master where passport_id='$row_passport[passport_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];

	$paid_amount = $sq_paid_amount['sum'];
	$paid_amount = ($paid_amount == '')?0:$paid_amount;

	$cancel_amt = $row_passport['cancel_amount'];
	if($cancel_amt == ""){ $cancel_amt = 0;}

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
	$passport_total_cost = $row_passport['passport_total_cost'];
	$net_amount1 = $passport_total_cost - $row_passport['cancel_amount'];	

	$sale_amount = $passport_total_cost-$row_passport['cancel_amount']+$credit_card_charges;
	$bal_amount = $sale_amount - $paid_amount;

	$total_sale = $total_sale + $sale_amount;
	$total_cancelation_amount = $total_cancelation_amount + $cancel_amt;
	$total_balance = $total_balance+$sale_amount;		

	$roundoff = $row_passport['roundoff'];
	$bsmValues = $row_passport['bsm_values'];
	$bsmValues = http_build_query(array('bsmValues' => $bsmValues));
	
	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Passport'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	
	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount1&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&passport_id=$passport_id&pass_count=$pass_count&roundoff=$roundoff&$bsmValues&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/passport_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount1&service_charge=$service_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&passport_id=$passport_id&roundoff=$roundoff&credit_card_charges=$credit_card_charges";
	
	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_passport_booking_id($row_passport['passport_id'],$year),
		$customer_name,
		$contact,
		number_format($passport_total_cost+$credit_card_charges,2),
		$cancel_amt,
		number_format($sale_amount, 2),
		$emp_name,
		'<a onclick="loadOtherPage(\''. $url1 .'\')" data-toggle="tooltip" class="btn btn-info btn-sm" title="Download Invoice"><i class="fa fa-print"></i></a>
		
		<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="passport_view_modal('. $row_passport['passport_id'] .')" title="View Details"><i class="fa fa-eye"></i></button>

		<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="passport_update_modal('. $row_passport['passport_id'] .')"  title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
		), "bg" =>$bg );
		array_push($array_s,$temp_arr); 
	}
	$footer_data = array("footer_data" => array(
		'total_footers' => 4,
		'foot0' => "Total",
		'col0' => 4,
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