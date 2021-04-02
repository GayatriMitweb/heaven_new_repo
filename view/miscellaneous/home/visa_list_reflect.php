<?php
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$misc_id = $_POST['misc_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];

$query = "select * from miscellaneous_master where financial_year_id='$financial_year_id' ";

if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($misc_id!=""){
	$query .= " and misc_id='$misc_id'";
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
include "../../../model/app_settings/branchwise_filteration.php";
$query .= " order by misc_id desc";

$count = 0;
$booking_amount = 0;
$cancelled_amount = 0;
$total_amount = 0;
$array_s = array();
$temp_arr = array();
$footer_data = array();
$sq_visa = mysql_query($query);		

while($row_visa = mysql_fetch_assoc($sq_visa)){
	
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from miscellaneous_payment_master where misc_id='$row_visa[misc_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];

	$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_visa[emp_id]'"));
	$emp_name = ($row_visa['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';

	$pass_count = mysql_num_rows(mysql_query("select * from  miscellaneous_master_entries where misc_id='$row_visa[misc_id]'"));
	$cancel_count = mysql_num_rows(mysql_query("select * from  miscellaneous_master_entries where misc_id='$row_visa[misc_id]' and status='Cancel'"));
	$bg="";
	if($pass_count==$cancel_count) 	{
		$bg="danger";
	}
	else  {
		$bg="#fff";
	}
	//Get Total no of visa members
	$sq_total_member=mysql_num_rows(mysql_query("select misc_id from miscellaneous_master_entries where misc_id='$row_visa[misc_id]' "));     

	$customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row_visa[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($customer_info['contact_no'], $secret_key);
		
	if($customer_info['type']=='Corporate'){
		$customer_name = $customer_info['company_name'];
	}else{
		$customer_name = $customer_info['first_name'].' '.$customer_info['last_name'];
	}
	//Get Total visa cost
	$visa_total_amount=$row_visa['misc_total_cost'];
	
	//Get total refund amount
	$cancel_amount=$row_visa['cancel_amount'];
	if($cancel_amount==""){	$cancel_amount=0; }
	
	$total_visa_amount=$visa_total_amount-$cancel_amount + $credit_card_charges;
	
	//calculate total amounts
	$booking_amount=$booking_amount+$visa_total_amount+ $credit_card_charges;
	$cancelled_amount=$cancelled_amount+$cancel_amount;
	$total_amount=$total_amount+$total_visa_amount;

	$total_paid = 0;
	$total_paid =  $sq_paid_amount['sum'] ;
	$total_paid = ($total_paid == '') ? '0' : $total_paid;            

	$created_at = $row_visa['created_at'];
	$year = explode("-", $created_at);
	$year =$year[0];

	$invoice_no = get_misc_booking_id($row_visa['misc_id'],$year);
	$booking_id = $row_visa['misc_id'];
	$invoice_date = date('d-m-Y',strtotime($row_visa['created_at']));
	$customer_id = $row_visa['customer_id'];
	
	$service_name = "Miscellaneous Invoice";
	//**Service Tax
	$taxation_type = $row_visa['taxation_type'];
	$service_tax_per = $row_visa['service_tax'];
	$service_charge = $row_visa['service_charge'];
	$service_tax = $row_visa['service_tax_subtotal'];
	//**Basic Cost
	$basic_cost = $row_visa['misc_issue_amount'] - $row_visa['cancel_amount'];
	$net_amount = $row_visa['misc_total_cost'] - $row_visa['cancel_amount'];
	$balance_amount = $net_amount - $total_paid;

	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Miscellaneous'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&service_charge=$service_charge&total_paid=$total_paid&balance_amount=$balance_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&pass_count=$pass_count&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/misc_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&service_charge=$service_charge&total_paid=$total_paid&balance_amount=$balance_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&credit_card_charges=$credit_card_charges";

	$temp_arr = array( "data" => array(
		(int)(++$count),
		get_misc_booking_id($row_visa['misc_id'],$year),
		$customer_name,
		$contact_no,
		$sq_total_member,
		number_format($visa_total_amount+$credit_card_charges,2),
		$cancel_amount,
		number_format($total_visa_amount, 2),
		$emp_name,
		'<a onclick="loadOtherPage(\''.$url1 .'\')" class="btn btn-info btn-sm" title="Download Invoice"><i class="fa fa-print"></i></a>
		
		<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="visa_display_modal('. $row_visa['misc_id'] .')" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>

		<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="visa_update_modal('. $row_visa['misc_id'] .')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
		), "bg" =>$bg );
		array_push($array_s,$temp_arr); 
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	'foot0' => "Total",
	'col0' => 5,
	'class0' => "text-right",
	'foot1' => number_format($booking_amount, 2),
	'col1' => 1,	//colspan 
	'class1' => "info",
	'foot2' =>  number_format($cancelled_amount, 2),
	'col2' => 1,
	'class2' => "danger",
	'foot3' => number_format($total_amount, 2),
	'col3' => 1,
	'class3' => "success",
	)
);
array_push($array_s, $footer_data);	
echo json_encode($array_s);	
?>