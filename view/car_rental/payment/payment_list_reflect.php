<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
$payment_mode = $_POST['payment_mode'];
$financial_year_id = $_SESSION['financial_year_id'];
$payment_from_date = $_POST['payment_from_date'];
$payment_to_date = $_POST['payment_to_date'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$query = "select * from car_rental_payment where 1";
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
if($booking_id!=""){
	$query .=" and booking_id='$booking_id'";
}
if($payment_mode!=""){
	$query .=" and payment_mode='$payment_mode'";
}
if($payment_from_date!='' && $payment_to_date!=''){
	$payment_from_date = get_date_db($payment_from_date);
	$payment_to_date = get_date_db($payment_to_date);
	$query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
}
include "../../../model/app_settings/branchwise_filteration.php";
$query .=" order by payment_id desc";
$array_s = array();
		$temp_arr = array();
		$footer_data = array();
		$count = 0;
		$sq_payment = mysql_query($query);
		$total_paid_amt=0;
		while($row_payment = mysql_fetch_assoc($sq_payment))
			if($row_payment['payment_amount']!=0){
			{
				$count++;
				$sq_booking = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$row_payment[booking_id]'"));
				$total_sale = $sq_booking['total_fees'];
				$sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from car_rental_payment where clearance_status!='Cancelled' and booking_id='$row_payment[booking_id]'"));
				$total_pay_amt = $sq_pay['sum'];
				$outstanding =  $total_sale - $total_pay_amt;

				$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
				$date = $sq_booking['created_at'];
				$yr = explode("-", $date);
				$year =$yr[0];
				if($sq_customer['type']=='Corporate'){
					$customer_name = $sq_customer['company_name'];
				}else{
					$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
				}
				
				$total_paid_amt = $total_paid_amt + $row_payment['payment_amount'] + $row_payment['credit_charges'];
				if($row_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount']  + $row_payment['credit_charges'];
				}
				else if($row_payment['clearance_status']=="Cancelled"){ $bg='danger';
					$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'] + $row_payment['credit_charges'];
				}
				else{
					$bg='';
				}

				$payment_id_name = "Car Rental Payment ID";
				$payment_id = get_car_rental_booking_payment_id($row_payment['payment_id'],$year);
				$receipt_date = date('d-m-Y');
				$booking_id = get_car_rental_booking_id($row_payment['booking_id'],$year);
				$customer_id = $sq_booking['customer_id'];
				$booking_name = "Car Rental Booking";
				$travel_date = date('d-m-Y',strtotime($sq_booking['traveling_date']));
				$payment_amount = $row_payment['payment_amount'] + $row_payment['credit_charges'];
				$payment_mode1 = $row_payment['payment_mode'];
				$transaction_id = $row_payment['transaction_id'];
				$payment_date = date('d-m-Y',strtotime($row_payment['payment_date']));
				$bank_name = $row_payment['bank_name'];
				$receipt_type = "Car Rental Receipt";				
				$checshow = "";
				if($row_payment['payment_mode']=="Cash" || $row_payment['payment_mode']=="Cheque"){
					$checshow = '<input type="checkbox" id="chk_car_rental_payment_'. $count .'" name="chk_car_rental_payment" value="'. $row_payment['payment_id'] .'">';
				} 
				$payshow = "";
				if($payment_mode=="Cheque"){
					$payshow = '<input type="text" id="branch_name_'.$count.'" name="branch_name_d" class="form-control" placeholder="Branch Name" style="width:120px">';
				}
				$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=car_rental_payment&customer_field=booking_id&in_customer_id=$row_payment[booking_id]";
				$temp_arr = array( "data" => array(
					(int)($count),
					$checshow,
					get_car_rental_booking_id($row_payment['booking_id'],$year),
					$customer_name,
					$row_payment['payment_mode'],
					date('d/m/Y', strtotime($row_payment['payment_date'])),
					$payshow ,
					number_format($row_payment['payment_amount'] +
					$row_payment['credit_charges'],2) ,
					'<a onclick="loadOtherPage(\''. $url1 .'\')" class="btn btn-info btn-sm" title="Download Receipt"><i class="fa fa-print"></i></a>
		
					<button class="btn btn-info btn-sm" data-toggle="tooltip" onclick="payment_update_modal('.$row_payment['payment_id'].')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>'
				  ), "bg" =>$bg );
				  array_push($array_s,$temp_arr); 
				}}
				$footer_data = array("footer_data" => array(
					'total_footers' => 4,
					'foot0' => "Total Amount: ".number_format((($total_paid_amt=="") ? 0 : $total_paid_amt), 2),
					'col0' => 3,
					'class0' => "info",
					'foot1' => "Pending Clearance : ".number_format((($sq_pending_amount=="") ? 0 : $sq_pending_amount), 2),
					'col1' => 2,
					'class1' => "warning",
					'foot2' =>  "Cancelled Amount: ".number_format((($sq_cancel_amount=="") ? 0 : $sq_cancel_amount), 2),
					'col2' => 2,
					'class2' => "danger",
					'foot3' => "Total Paid : ".number_format(($total_paid_amt - $sq_pending_amount - $sq_cancel_amount), 2),
					'col3' => 2,
					'class3' => "success"
					)
				);
				array_push($array_s, $footer_data);	
				echo json_encode($array_s);	
	?>