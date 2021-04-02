<?php 
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$ticket_id=$_POST['ticket_id_filter'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$booker_id = $_POST['booker_id'];
$branch_id = $_POST['branch_id'];

$array_s = array();
$temp_arr = array();
$query = "select * from ticket_master where 1 ";
if($customer_id!=""){
$query .= " and customer_id='$customer_id'";
}
if($ticket_id!="")
{
$query .= " and ticket_id='$ticket_id'";
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
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by ticket_id desc";

$count = 0;
$total_balance=0;
$cancel_amount = 0;
$total_refund=0;		
$cancel_total =0;
$sale_total = 0;
$paid_total = 0;
$balance_total = 0;
$sq_ticket = mysql_query($query);
while($row_ticket = mysql_fetch_assoc($sq_ticket)){

	$pass_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'"));
	$cancel_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]' and status='Cancel'"));

	if($pass_count==$cancel_count) 	{
		$bg="danger";
	}
	else  {
		$bg="#fff";
	}
	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
	if($sq_customer_info['type']=='Corporate'){
		$customer_name = $sq_customer_info['company_name'];
	}else{
		$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
	}

	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_ticket[emp_id]'"));
	if($sq_emp['first_name'] == '') { $emp_name='Admin';}
	else{ $emp_name = $sq_emp['first_name'].' '.$sq_emp['last_name']; }

	$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$sq_emp[branch_id]'"));
	$branch_name = $sq_branch['branch_name']==''?'NA':$sq_branch['branch_name'];
	$sq_total_member = mysql_num_rows(mysql_query("select ticket_id from ticket_master_entries where ticket_id = '$row_ticket[ticket_id]' AND status!='Cancel'"));

	$due_date = ($row_ticket['due_date'] == '1970-01-01') ? 'NA' : get_date_user($row_ticket['due_date']);
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum, sum(credit_charges) as sumc from ticket_payment_master where ticket_id='$row_ticket[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
	$credit_card_charges = $sq_paid_amount['sumc'];

	$paid_amount = $sq_paid_amount['sum'];
	if($paid_amount=="") {$paid_amount = 0;  }
	$total_sale= $row_ticket['ticket_total_cost'];
	$balaces= $total_sale - $paid_amount;
	$cancel_amount=$row_ticket['cancel_amount'];
	$total_bal = $total_sale - $cancel_amount;	
	if($paid_amount > 0){
		if($pass_count==$cancel_count) 	{
			$bal = 0;
		}else{
			$bal = $total_bal - $paid_amount;
		}
	}else{
		$bal = $cancel_amount;
	}
	if($cancel_amount=="") {$cancel_amount = 0;  }
	if($balaces>=0){
		$total_balance=$total_balance+$balaces;
	}
	else{
		$total_refund=$total_refund+abs($balaces);
	}
	//Footer
	$cancel_total = $cancel_total + $cancel_amount;
	$sale_total = $sale_total + $total_bal + $credit_card_charges;
	$paid_total = $paid_total + $paid_amount + $credit_card_charges;
	$balance_total = $balance_total + $bal;

	$other_charges = $row_ticket['basic_cost_markup'] - $row_ticket['basic_cost_discount'] +$row_ticket['yq_tax'] +$row_ticket['yq_tax_markup'] - $row_ticket['yq_tax_discount'] + $row_ticket['other_taxes'];
	/////// Purchase ////////
	$total_purchase = 0;
	$purchase_amt = 0;
	$i=0;
	$p_due_date = '';
	$sq_purchase_count = mysql_num_rows(mysql_query("select * from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id='$row_ticket[ticket_id]'"));
	if($sq_purchase_count == 0){  $p_due_date = 'NA'; }
	$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id='$row_ticket[ticket_id]'");
	while($row_purchase = mysql_fetch_assoc($sq_purchase)){		
		$purchase_amt = $row_purchase['net_total'] - $row_purchase['refund_net_total'];
		$total_purchase = $total_purchase + $purchase_amt;
	}
	$sq_purchase1 = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_type='Ticket Booking' and estimate_type_id='$row_ticket[ticket_id]'"));		
	$vendor_name = get_vendor_name_report($sq_purchase1['vendor_type'], $sq_purchase1['vendor_type_id']);
	if($vendor_name == ''){ $vendor_name1 = 'NA';  }
	else{ $vendor_name1 = $vendor_name; }

	$paid_amount = $sq_paid_amount['sum'];
	$paid_amount = ($paid_amount == '')?0:$paid_amount;
	$sale_amount = $row_ticket['ticket_total_cost'] - $row_ticket['cancel_amount']+ $credit_card_charges;
	$bal_amount = $sale_amount - $paid_amount;

	$cancel_amt = $row_ticket['cancel_amount'];
	if($cancel_amt==""){ $cancel_amt = 0;}

	$total_sale = $total_sale + $row_ticket['ticket_total_cost'];
	$total_cancelation_amount = $total_cancelation_amount + $cancel_amt;
	$total_balance = $total_balance + $sale_amount;

	//Invoice
	$date = $row_ticket['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$ticket_id = $row_ticket['ticket_id'];
	$invoice_no = get_ticket_booking_id($row_ticket['ticket_id'],$year);
	$invoice_date = date('d-m-Y',strtotime($row_ticket['created_at']));
	$customer_id = $row_ticket['customer_id'];
	$service_name = "Flight Invoice";
	//**Discount
	$taxation_type = $row_ticket['taxation_type'];
	//**Service tax
	$service_tax_per = $row_ticket['service_tax'];
	$service_charge = $row_ticket['service_charge'];
	$service_tax = $row_ticket['service_tax_subtotal'];
	//**Basic Cost
	$basic_cost = $row_ticket['basic_cost'] + $row_ticket['basic_cost_markup'] - $row_ticket['cancel_amount'];

	$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Flight'"));   
	$sac_code = $sq_sac['hsn_sac_code'];
	$net_amount = $row_ticket['ticket_total_cost'] - $row_ticket['cancel_amount'];

	if($app_invoice_format == 4)
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&service_charge=$service_charge&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&ticket_id=$ticket_id&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&pass_count=$pass_counts&credit_card_charges=$credit_card_charges";
	else
	$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/flight_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax&net_amount=$net_amount&ticket_id=$ticket_id&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_statuss&credit_card_charges=$credit_card_charges";

	$voucher_name = "AIR TICKET VOUCHER";
	$pass_url = BASE_URL."view/visa_passport_ticket/ticket/home/e_ticket.php?ticket_id=$row_ticket[ticket_id]&service_name=$voucher_name&invoice_date=$invoice_date";

	//Service Tax and Markup Tax
	$service_tax_amount = 0;
	if($row_ticket['service_tax_subtotal'] !== 0.00 && ($row_ticket['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_ticket['service_tax_subtotal']);
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		}
	}
	$markupservice_tax_amount = 0;
	if($row_ticket['markup_tax'] !== 0.00 && $row_ticket['markup_tax'] !== ""){
		$service_tax_markup1 = explode(',',$row_ticket['markup_tax']);
		for($i=0;$i<sizeof($service_tax_markup1);$i++){
		$service_tax = explode(':',$service_tax_markup1[$i]);
		$markupservice_tax_amount += $service_tax[2];
	
		}
	}
	$temp_arr = array( "data" => array(

	(int)(++$count),
	get_ticket_booking_id($row_ticket['ticket_id'],$year),
	$customer_name,
	$contact_no,
	$email_id,
	$sq_total_member,
	$row_ticket['tour_type'],
	$row_ticket['type_of_tour'],
	get_date_user($row_ticket['created_at']),
	'<button class="btn btn-info btn-sm" onclick="ticket_view_modal('. $row_ticket['ticket_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	number_format($row_ticket['basic_cost'],2),
	number_format($other_charges,2),
	number_format($row_ticket['service_charge']+$row_ticket['markup'],2),
	number_format($service_tax_amount+$markupservice_tax_amount,2),
	number_format($row_ticket['tds'],2),
	number_format($credit_card_charges,2),
	number_format($row_ticket['ticket_total_cost']+$credit_card_charges,2),
	number_format($cancel_amount, 2),
	number_format($total_bal+$credit_card_charges, 2),
	number_format($paid_amount+$credit_card_charges, 2),
	'<button class="btn btn-info btn-sm" onclick="payment_view_modal('.$row_ticket['ticket_id'] .')"  data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	number_format($bal, 2),
	$due_date,
	number_format($total_purchase,2),
	'<button class="btn btn-info btn-sm" onclick="supplier_view_modal('. $row_ticket['ticket_id'] .')" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye" aria-hidden="true"></i></button>',
	$branch_name,
	$emp_name,
	'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" data-toggle="tooltip" title="Download Invoice"><i class="fa fa-print"></i></a>
	<a href="'. $pass_url.'" target="_blank" class="btn btn-danger btn-sm" title="Download E_Ticket"><i class="fa fa-file-pdf-o"></i></a>
	'
	), "bg" =>$bg);
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(
	'total_footers' => 5,
	'foot0' => "",
	'col0' =>15,
	'class0' =>"",

	'foot1' => "TOTAL CANCEL : ".number_format($cancel_total,2),
	'col1' => 2,
	'class1' =>"danger text-right",
	
	'foot2' => "TOTAL SALE : ".number_format($sale_total,2),
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