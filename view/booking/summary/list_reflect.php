<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$id = $_POST['id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$booker_id = $_POST['booker_id'];
$branch_id = $_POST['branch_id'];
$array_s = array();
$temp_arr = array();

$query = "select * from tourwise_traveler_details where 1 ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($id!=""){
	$query .= " and id='$id'";
}
if($from_date!="" && $to_date!=""){
	$from_date = date('Y-m-d', strtotime($from_date));
	$to_date = date('Y-m-d', strtotime($to_date));
	$query .= " and form_date between '$from_date' and '$to_date'";
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
include "../../../model/app_settings/branchwise_filteration.php";
$query .= " order by id desc";
$count = 0;
$total_balance=0;
$total_refund=0;		
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;

$sq_package = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_package))
{
	$bg=""; 
	$pass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]'"));
	$cancelpass_count = mysql_num_rows(mysql_query("select * from  travelers_details where traveler_group_id='$row_booking[id]' and status='Cancel'"));    
	if($row_booking['tour_group_status']=="Cancel") 	{
		$bg="danger";
		$sq_total_member = 0;
	}
	else  {
		if($pass_count==$cancelpass_count){
			$bg="danger";
		}else
		$bg="#fff";
	}

	$booking_date = $row_booking['form_date'];
	$yr = explode("-", $booking_date);
	$year =$yr[0];
	
	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_booking[emp_id]'"));
	if($sq_emp['first_name'] == '') { $emp_name='Admin';}
	else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

	$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
	$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
	if($row_booking['tour_group_status']!="Cancel") {
		$sq_total_member = mysql_num_rows(mysql_query("select traveler_group_id from travelers_details where traveler_group_id = '$row_booking[id]' AND status!='Cancel'"));
	}
	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
	if($sq_customer_info['type'] == 'Corporate'){
		$customer_name = $sq_customer_info['company_name'];
	}else{
		$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	}

	$sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum ,sum(credit_charges) as sumc from payment_master where tourwise_traveler_id='$row_booking[id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$paid_amount = $sq_paid_amount['sum'];
	$credit_card_charges = $sq_paid_amount['sumc'];
	//sale amount
	$tour_fee = $row_booking['net_total']+ $credit_card_charges;

	//cancel amount
	$sq_est_count = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
	if($sq_est_count!='0'){
		$sq_est_info= mysql_fetch_assoc(mysql_query("SELECT * from refund_tour_estimate where tourwise_traveler_id='$row_booking[id]'"));
		$tour_esti=$sq_est_info['cancel_amount'];
	}
	else{
			$sq_est_info = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$row_booking[id]'"));
			$tour_esti=$sq_est_info['cancel_amount'];
	}
	//total amount
	$total_amount = $tour_fee - $tour_esti;

	//balance
	if($paid_amount > 0){
		if($pass_count==$cancelpass_count){
			$total_balance = 0;
		}else{
			$total_balance = $total_amount - $paid_amount + $credit_card_charges;
		}
	}else{
		$total_balance = $cancel_amount;
	}
	
	//Footer
	$cancel_total = $cancel_total + $tour_esti;
	$sale_total = $sale_total + $total_amount+$tour_esti;
	$paid_total = $paid_total + $sq_paid_amount['sum']+$credit_card_charges;
	$balance_total = $balance_total + $total_balance;

	/////// Purchase ////////
	$total_purchase = 0;
	$purchase_amt = 0;
	$i=0;
	$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'"));
	if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
	$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'");
	while($row_purchase = mysql_fetch_assoc($sq_purchase)){
		$p_due_date = get_date_user($row_purchase['due_date']); 			
		$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
		$total_purchase = $total_purchase + $purchase_amt;
	}
	$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id='$row_booking[tour_group_id]'"));		
	$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
	if($vendor_name == ''){ $vendor_name1 = 'NA';  }
	else{ $vendor_name1 = $vendor_name; }

	/////// Incetive ////////
	$sq_incentive = mysql_fetch_assoc(mysql_query("select * from booker_incentive_group_tour where tourwise_traveler_id='$row_booking[id]'"));
	///Tour
	$sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$row_booking[tour_id]'"));

	$sq_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$row_booking[tour_group_id]'"));
	$tour = $sq_tour['tour_name'];
	$group = get_date_user($sq_group['from_date']).' To '.get_date_user($sq_group['to_date']);
	
	//////////Invoice//////////////
	$invoice_no = get_group_booking_id($row_booking['id'],$year);
	$invoice_date = date('d-m-Y',strtotime($row_booking['form_date']));
	$customer_id = $row_booking['customer_id'];
	$service_name = "Group Invoice";

	// Net amount
	$net_amount = 0;
	$tour_total_amount= ($row_booking['total_tour_fee']!="") ? $row_booking['total_tour_fee']: 0;
	$net_amount  =  $tour_total_amount + $row_booking['total_travel_expense'] - $cancel_tour_amount;

	//**Service Tax
	$taxation_type = $row_booking['taxation_type'];

	//basic amount
	$train_expense = $row_booking['train_expense'];
	$plane_expense = $row_booking['plane_expense'];
	$cruise_expense = $row_booking['cruise_expense'];
	$visa_amount = $row_booking['visa_amount'];
	$insuarance_amount = $row_booking['insuarance_amount'];
	$tour_subtotal = $row_booking['tour_fee_subtotal_1'] - $cancel_tour_amount;
	$basic_cost = $train_expense +$plane_expense +$cruise_expense +$visa_amount +$insuarance_amount +$tour_subtotal;

	//Service charge	
	$train_service_charge = $row_booking['train_service_charge'];
	$plane_service_charge = $row_booking['plane_service_charge'];
	$cruise_service_charge = $row_booking['cruise_service_charge'];
	$visa_service_charge = $row_booking['visa_service_charge'];
	$insuarance_service_charge = $row_booking['insuarance_service_charge'];
	$service_charge = $train_service_charge +$plane_service_charge +$cruise_service_charge +$visa_service_charge +$insuarance_service_charge;

	//service tax
	$train_service_tax = $row_booking['train_service_tax'];
	$plane_service_tax = $row_booking['plane_service_tax'];
	$cruise_service_tax = $row_booking['cruise_service_tax'];
	$visa_service_tax = $row_booking['visa_service_tax'];
	$insuarance_service_tax = $row_booking['insuarance_service_tax'];
	$tour_service_tax = $row_booking['service_tax_per'];
	
	//service tax subtotal	
	$train_service_tax_subtotal = $row_booking['train_service_tax_subtotal'];
	$plane_service_tax_subtotal = $row_booking['plane_service_tax_subtotal'];
	$cruise_service_tax_subtotal = $row_booking['cruise_service_tax_subtotal'];
	$visa_service_tax_subtotal = $row_booking['visa_service_tax_subtotal'];
	$insuarance_service_tax_subtotal = $row_booking['insuarance_service_tax_subtotal'];
	$tour_service_tax_subtotal = $row_booking['service_tax'];
	$service_tax_subtotal = $train_service_tax_subtotal +$plane_service_tax_subtotal +$cruise_service_tax_subtotal +$visa_service_tax_subtotal +$insuarance_service_tax_subtotal+$tour_service_tax_subtotal;	
	
	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Group Tour'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	$tour_date = get_date_user($sq_group['from_date']);
	$booking_id = $row_booking['id'];
	
	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/git_fit_tax_invoice.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&train_expense=$train_expense&plane_expense=$plane_expense&cruise_expense=$cruise_expense&visa_amount=$visa_amount&insuarance_amount=$insuarance_amount&tour_subtotal=$tour_subtotal&train_service_charge=$train_service_charge&plane_service_charge=$plane_service_charge&cruise_service_charge=$cruise_service_charge&visa_service_charge=$visa_service_charge&insuarance_service_charge=$insuarance_service_charge&train_service_tax=$train_service_tax&plane_service_tax=$plane_service_tax&cruise_service_tax=$cruise_service_tax&visa_service_tax=$visa_service_tax&insuarance_service_tax=$insuarance_service_tax&tour_service_tax=$tour_service_tax&train_service_tax_subtotal=$train_service_tax_subtotal&plane_service_tax_subtotal=$plane_service_tax_subtotal&cruise_service_tax_subtotal=$cruise_service_tax_subtotal&visa_service_tax_subtotal=$visa_service_tax_subtotal&insuarance_service_tax_subtotal=$insuarance_service_tax_subtotal&tour_service_tax_subtotal=$tour_service_tax_subtotal&total_paid=$total_paid&net_amount=$net_amount&sac_code=$sac_code&branch_status=$branch_status&pass_count=$pass_count&tour_date=$tour_date&tour_name=$tour&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/git_fit_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&train_expense=$train_expense&plane_expense=$plane_expense&cruise_expense=$cruise_expense&visa_amount=$visa_amount&insuarance_amount=$insuarance_amount&tour_subtotal=$tour_subtotal&train_service_charge=$train_service_charge&plane_service_charge=$plane_service_charge&cruise_service_charge=$cruise_service_charge&visa_service_charge=$visa_service_charge&insuarance_service_charge=$insuarance_service_charge&train_service_tax=$train_service_tax&plane_service_tax=$plane_service_tax&cruise_service_tax=$cruise_service_tax&visa_service_tax=$visa_service_tax&insuarance_service_tax=$insuarance_service_tax&tour_service_tax=$tour_service_tax&train_service_tax_subtotal=$train_service_tax_subtotal&plane_service_tax_subtotal=$plane_service_tax_subtotal&cruise_service_tax_subtotal=$cruise_service_tax_subtotal&visa_service_tax_subtotal=$visa_service_tax_subtotal&insuarance_service_tax_subtotal=$insuarance_service_tax_subtotal&tour_service_tax_subtotal=$tour_service_tax_subtotal&total_paid=$paid_amount&net_amount=$net_amount&sac_code=$sac_code&branch_status=$branch_status&tour_name=$tour&booking_id=$booking_id&credit_card_charges=$credit_card_charges";

	// Booking Form
	$b_url = BASE_URL."model/app_settings/print_html/booking_form_html/group_tour.php?booking_id=$row_booking[id]";
	//Service Tax and Markup Tax
	$service_tax_amount = 0;
	if($row_booking['service_tax'] !== 0.00 && ($row_booking['service_tax']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_booking['service_tax']);
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		}
	}
$temp_arr = array( "data" => array(

(int)(++$count),
get_group_booking_id($row_booking['id'],$year),
$customer_name,
$contact_no,
$email_id,
$sq_total_member,
get_date_user($row_booking['form_date']),
'<button class="btn btn-info btn-sm" onclick="group_view_modal('. $row_booking['id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
$tour,
$group,
number_format($row_booking['basic_amount'],2),
number_format($service_tax_amount,2),
number_format($credit_card_charges,2),
number_format($tour_fee,2),
number_format($tour_esti,2),
number_format($total_amount,2),
number_format($sq_paid_amount['sum']+ $credit_card_charges,2),
'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_booking['id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
number_format($total_balance, 2),
get_date_user($row_booking['balance_due_date']),
number_format($total_purchase,2),
'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_booking['tour_group_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
$branch_name,
$emp_name,
number_format($sq_incentive['incentive_amount'],2),
'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Print Invoice"><i class="fa fa-print"></i></a>
<a onclick="loadOtherPage(\''. $b_url .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Print Booking Form"><i class="fa fa-print"></i></a>'


), "bg" =>$bg);
array_push($array_s,$temp_arr);


	}
	$footer_data = array("footer_data" => array(
	'total_footers' => 6,
	'foot0' => "",
	'col0' =>10,
	'class0' =>"success : ",

	'foot1' => "TOTAL SALE : ".number_format($sale_total,2),
	'col1' => 2,
	'class1' =>"info text-right",
	
	'foot2' => "TOTAL CANCEL : ".number_format($cancel_total,2),
	'col2' => 2,
	'class2' =>"danger text-right",

	'foot3' => "TOTAL PAID : ".number_format($paid_total,2),
	'col3' => 2,
	'class3' =>"success text-right",

	'foot4' => "TOTAL BALANCE : ".number_format($balance_total,2),
	'col4' => 3,
	'class4' =>"warning text-right",

	'foot5' => "",
	'col5' => 7,
	'class5' =>""

	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>
	