<?php 
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$booker_id = $_POST['booker_id'];
$branch_id = $_POST['branch_id'];
$array_s = array();
$temp_arr = array();
$query = "select * from car_rental_booking where 1 ";
if($customer_id!=""){
$query .= " and customer_id='$customer_id'";
}
if($booking_id!=""){
$query .= " and booking_id='$booking_id'";
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
if($booker_id!=""){
$query .= " and emp_id='$booker_id'";
}
if($branch_id!=""){
$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_id')";
}
include "../../../model/app_settings/branchwise_filteration.php";
$query .= " order by booking_id desc";
$count = 0;
$total_balance=0;
$total_refund=0;		
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;

$sq_car = mysql_query($query);
while($row_car = mysql_fetch_assoc($sq_car)){

$bg="";
$date = $row_car['created_at'];
$yr = explode("-", $date);
$year =$yr[0];
($row_car['status']=='Cancel') ? $bg='danger' : $bg='fff';

$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_car[customer_id]'"));
$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
if($sq_customer_info['type'] == 'Corporate'){
	$customer_name = $sq_customer_info['company_name'];
}else{
	$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
}
$sq_enq = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$row_car[enquiry_id]'"));
$sq_ref = mysql_fetch_assoc(mysql_query("select * from references_master where reference_id='$sq_enq[reference_id]'"));

$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_car[emp_id]'"));
if($sq_emp['first_name'] == '') { $emp_name='Admin';}
else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];

$sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum,sum(credit_charges) as sumc from car_rental_payment where booking_id='$row_car[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$date = $row_car['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$total_sale = $row_car['total_fees']+ $sq_paid_amount['sumc'];
$cancel_amount = $row_car['cancel_amount'];
if($cancel_amount==""){	$cancel_amount=0.00; } 
$paid_amount = $sq_paid_amount['sum']+ $sq_paid_amount['sumc'];
$total_bal = $total_sale - $cancel_amount;

if($paid_amount > 0){
	if($row_car['status']=='Cancel'){
		$bal = 0;
	}else{
		$bal = $total_bal - $paid_amount;
	}
}else{
	$bal = $cancel_amount;
}
$due_date= ($row_car['due_date'] == '1970-01-01') ? 'NA' : get_date_user($row_car['due_date']);
if($paid_amount==""){	$paid_amount=0; } 

if($bal>=0){						 
	$total_balance=$total_balance + $bal;
}else{
	$total_refund =$total_refund+ abs($bal);
}		
$other_charges = $row_car['driver_allowance'] + $row_car['permit_charges'] + $row_car['toll_and_parking'] + $row_car['state_entry_tax'];
//Footer
$cancel_total = $cancel_total + $cancel_amount;
$sale_total = $sale_total + $total_bal;
$paid_total = $paid_total + $paid_amount;
$balance_total = $balance_total + $bal;

/////// Purchase ////////
$total_purchase = 0;
$purchase_amt = 0;
$i=0;
$p_due_date = '';
$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'"));
if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'");
while($row_purchase = mysql_fetch_assoc($sq_purchase)){		
	$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
	$total_purchase = $total_purchase + $purchase_amt;
}
$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Car Rental' and estimate_type_id='$row_car[booking_id]'"));		
$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
if($vendor_name == ''){ $vendor_name1 = 'NA';  }
else{ $vendor_name1 = $vendor_name; }

$date = $row_car['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from car_rental_payment where booking_id='$row_car[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$paid_amount = $sq_paid_amount['sum'] + $sq_paid_amount['sumc'] ;
$paid_amount = ($paid_amount == '')?0:$paid_amount;
$total_paid = 0;
$total_paid =  $sq_payment_total['sum'];  
$total_paid = ($total_paid == '') ? '0' : $total_paid;

$invoice_no = get_car_rental_booking_id($row_car['booking_id'],$year);
$invoice_date = date('d-m-Y',strtotime($row_car['created_at']));
$customer_id = $row_car['customer_id'];
$booking_id = $row_car['booking_id'];
$service_name = "Car Rental Invoice";
//**Service Tax
$taxation_type = $row_car['taxation_type'];
$service_tax_per = $row_car['service_tax'];
$service_charge1 = $row_car['actual_cost'] + $row_car['km_total_fee'];
$service_tax1 = $row_car['service_tax_subtotal'];
//**Basic Cost
$basic_cost = $row_car['total_cost'] - $service_tax1 - $row_car['cancel_amount'];
$other_charge = $row_car['driver_allowance'] + $row_car['permit_charges'] + $row_car['toll_and_parking'] + $row_car['state_entry_tax']  ;
$net_amount = $row_car['total_fees'] - $row_car['cancel_amount'];
$basic_cost1 =  $row_car['basic_amount'];
$bal_amount = $net_amount - $total_paid;
$credit_card_charges = $sq_paid_amount['sumc'];

$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Car Rental'"));   
$sac_code = $sq_sac['hsn_sac_code'];

if($app_invoice_format == 4)
$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost1&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax1&net_amount=$net_amount&service_charge=$service_charge1&total_paid=$total_paid&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&pass_count=$pass_count&credit_card_charges=$credit_card_charges";
else
$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/carrental_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost1&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax1&net_amount=$net_amount&service_charge=$other_charge&total_paid=$total_paid&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
//Service Tax and Markup Tax
$service_tax_amount = 0;
if($row_car['service_tax_subtotal'] !== 0.00 && ($row_car['service_tax_subtotal']) !== ''){
	$service_tax_subtotal1 = explode(',',$row_car['service_tax_subtotal']);
	for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
	$service_tax = explode(':',$service_tax_subtotal1[$i]);
	$service_tax_amount +=  $service_tax[2];
	}
}
$markupservice_tax_amount = 0;
if($row_car['markup_cost_subtotal'] !== 0.00 && $row_car['markup_cost_subtotal'] !== ""){
	$service_tax_markup1 = explode(',',$row_car['markup_cost_subtotal']);
	for($i=0;$i<sizeof($service_tax_markup1);$i++){
	$service_tax = explode(':',$service_tax_markup1[$i]);
	$markupservice_tax_amount += $service_tax[2];

	}
}
$temp_arr = array( "data" => array(
	(int)(++$count),
	get_car_rental_booking_id($row_car['booking_id'],$year),
	$customer_name,
	$contact_no,
	$email_id,
	$row_car['total_pax'],
	$row_car['travel_type'],
	get_date_user($row_car['created_at']),
	'<button class="btn btn-info btn-sm" onclick="car_view_modal('. $row_car['booking_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	number_format($row_car['basic_amount']+$row_car['service_charge']+$row_car['markup_cost']+$sq_paid_amount['sumc'] ,2),
	number_format($service_tax_amount+$markupservice_tax_amount,2),
	number_format($sq_paid_amount['sumc'],2),
	number_format($other_charges,2),
	number_format($total_sale,2),
	number_format($cancel_amount, 2),
	number_format($total_bal, 2),
	number_format($paid_amount, 2),
	'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_car['booking_id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	number_format($bal, 2),
	$due_date,
	number_format($total_purchase,2),
	'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_car['booking_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	$branch_name,
	$emp_name,
	($row_car['quotation_id'] == 0)?'NA':get_quotation_id($row_car['quotation_id']),
	'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download Invoice"><i class="fa fa-print"></i></a>'
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 5,
	'foot0' => "",
	'col0' =>12,
	'class0' =>"",

	'foot1' => "TOTAL SALE : ".number_format($sale_total,2),
	'col1' => 2,
	'class1' =>"info text-right",
	
	'foot2' => "TOTAL CANCEL :".number_format($cancel_total,2),
	'col2' => 2,
	'class2' =>"danger text-right",

	'foot3' => "TOTAL PAID : ".number_format($paid_total,2),
	'col3' => 2,
	'class3' =>"success text-right",

	'foot4' => "TOTAL BALANCE : ".number_format($balance_total,2),
	'col4' => 1,
	'class4' =>"warning text-right",

	'foot5' => "",
	'col5' => 4,
	'class5' =>""			
));
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>