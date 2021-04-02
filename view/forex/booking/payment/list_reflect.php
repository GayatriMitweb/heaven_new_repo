<?php
include "../../../../model/model.php";
$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$payment_mode = $_POST['payment_mode'];
$financial_year_id = $_SESSION['financial_year_id'];
$payment_from_date = $_POST['payment_from_date'];
$payment_to_date = $_POST['payment_to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "SELECT * from forex_booking_payment_master where 1";		
if($financial_year_id!=""){
	$query .= " and financial_year_id='$financial_year_id'";
}
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
if($payment_mode!=""){
	$query .= " and payment_mode='$payment_mode'";
}
if($customer_id!=""){
	$query .= " and booking_id in (select booking_id from forex_booking_master where customer_id='$customer_id')";
}
if($payment_from_date!='' && $payment_to_date!=''){
	$payment_from_date = get_date_db($payment_from_date);
	$payment_to_date = get_date_db($payment_to_date);
	$query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
}
if($cust_type != ""){
	$query .= " and booking_id in (select booking_id from forex_booking_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($company_name != ""){
	$query .= " and booking_id in (select booking_id from forex_booking_master where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and branch_admin_id = '$branch_admin_id'";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and booking_id in (select booking_id from forex_booking_master where emp_id='$emp_id') and branch_admin_id = '$branch_admin_id'";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and booking_id in (select booking_id from forex_booking_master where emp_id='$emp_id')";
}
$query .= " order by payment_id desc";
$bg;
$count = 0;
$total_paid_amt=0;
$array_s = array();
$temp_arr = array();
$footer_data = array();
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;

$sq_payment = mysql_query($query);

while($row_payment = mysql_fetch_assoc($sq_payment)){

	if($row_payment['payment_amount'] != '0'){

		$count++;
		$sq_forex_info = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$row_payment[booking_id]'"));
		$total_sale = $sq_forex_info['net_total'];
		$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from forex_booking_payment_master where clearance_status!='Cancelled' and booking_id='$row_payment[booking_id]'"));
		$total_pay_amt = $sq_pay['sum'];
		$outstanding =  $total_sale - $total_pay_amt;

		$date = $sq_forex_info['created_at'];
		$yr = explode("-", $date);
		$year =$yr[0];

		$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_forex_info[customer_id]'"));					
		if($sq_customer_info['type']=='Corporate'){
			$customer_name = $sq_customer_info['company_name'];
		}else{
			$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
		}

		$bg='';
		$sq_paid_amount = $sq_paid_amount + $row_payment['payment_amount']+$row_payment['credit_charges'];
		if($row_payment['clearance_status']=="Pending"){ 
			$bg='warning';
			$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount']+$row_payment['credit_charges'];
		}
		else if($row_payment['clearance_status']=="Cancelled"){ 
			$bg='danger';
			$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount']+$row_payment['credit_charges'];
		}
		else if($row_payment['clearance_status']=="Cleared"){ $bg = "success"; }

		$payment_id_name = "Forex Payment ID";
		$payment_id = get_forex_booking_payment_id($row_payment['payment_id'],$year);
		$receipt_date = date('d-m-Y');
		$booking_id = get_forex_booking_id($row_payment['booking_id']);
		$customer_id = $sq_forex_info['customer_id'];
		$booking_name = "Forex Booking";
		$travel_date = 'NA';
		$payment_amount = $row_payment['payment_amount']+$row_payment['credit_charges'];
		$payment_mode1 = $row_payment['payment_mode'];
		$transaction_id = $row_payment['transaction_id'];
		$payment_date = date('d-m-Y',strtotime($row_payment['payment_date']));
		$bank_name = $row_payment['bank_name'];
		$receipt_type = "Forex Receipt";

		$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=forex_booking_payment_master&customer_field=booking_id&in_customer_id=$row_payment[booking_id]";
		$checkshow = "";
		if($row_payment['payment_mode']=="Cash" || $row_payment['payment_mode']=="Cheque"){
			$checshow = '<input type="checkbox" id="chk_payment_'.$count.'" name="chk_payment" value="'. $row_payment['payment_id'].'">';
		}
		$payshow = "";
		if($payment_mode=="Cheque"){
			
			$payshow = '<input type="text" id="branch_name_'.$count.'" name="branch_name_d" class="form-control" placeholder="Branch Name" style="width:120px">';
			
		}
		$temp_arr = array( "data" => array(
			(int)($count),
			$checshow,
			get_forex_booking_id($row_payment['booking_id'],$year),
			$customer_name,
			date('d/m/Y', strtotime($row_payment['payment_date'])),
			$row_payment['payment_mode'],
			$payshow,
			number_format($row_payment['payment_amount']+$row_payment['credit_charges'],2),
			'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>

			<button data-toggle="tooltip" class="btn btn-info btn-sm" onclick="update_modal('. $row_payment['payment_id'] .')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
		), "bg" =>$bg );
		array_push($array_s,$temp_arr); 

	}
}
$footer_data = array("footer_data" => array(
	'total_footers' => 4,
	'foot0' => "Paid Amount : ".number_format($sq_paid_amount, 2),
	'col0' => 3,
	'class0' => "",
	'foot1' => "Pending Clearance : ".number_format($sq_pending_amount, 2),
	'col1' => 2,
	'class1' => "warning",
	'foot2' =>  "Cancellation Charges : ".number_format($sq_cancel_amount, 2),
	'col2' => 2,
	'class2' => "danger",
	'foot3' => "Total Payment : ".number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount), 2),
	'col3' => 3,
	'class3' => "success",
	)
);
array_push($array_s, $footer_data);	
echo json_encode($array_s);	
?>