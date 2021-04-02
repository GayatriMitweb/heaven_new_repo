<?php
include "../../../model/model.php";

$customer_id = $_POST['customer_id'];
$traveling_date_from = $_POST['traveling_date_from'];
$traveling_date_to = $_POST['traveling_date_to'];
$cust_type = $_POST['cust_type'];
$booking_id = $_POST['booking_id'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status']; 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$query = "select * from car_rental_booking where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .= " and customer_id='$customer_id'";
}
if($booking_id!=""){
	$query .=" and booking_id='$booking_id'";
}
if($traveling_date_from!='' && $traveling_date_to!=''){
	$traveling_date_from = get_date_db($traveling_date_from);
	$traveling_date_to = get_date_db($traveling_date_to);
	$query .=" and date(created_at) between '$traveling_date_from' and '$traveling_date_to'";
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
$query .= " order by booking_id desc";

		$count = 0;
		$array_s = array();
		$temp_arr = array();
		$footer_data = array();
		$sq_booking = mysql_query($query);
		while($row_booking = mysql_fetch_assoc($sq_booking)){
		$sq_emp =  mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id = '$row_booking[emp_id]'"));
		$emp_name = ($row_booking['emp_id'] != 0) ? $sq_emp['first_name'].' '.$sq_emp['last_name'] : 'Admin';
		
			$count++;
			$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
			$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 
			if($sq_customer['type']=='Corporate'){
				$customer_name = $sq_customer['company_name'];
			}else{
				$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
			}
			$bg="";
			($row_booking['status']=='Cancel') ? $bg='danger' : $bg='fff';

			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum ,sum(`credit_charges`) as sumc from car_rental_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

			$paid_amount = $sq_paid_amount['sum'];
			$credit_card_charges = $sq_paid_amount['sumc'];

			$paid_amount = ($paid_amount == '')?0:$paid_amount;

			$invoice_no = get_car_rental_booking_id($row_booking['booking_id'],$year);
			$invoice_date = date('d-m-Y',strtotime($row_booking['created_at']));
			$customer_id = $row_booking['customer_id'];
			$booking_id = $row_booking['booking_id'];
			$service_name = "Car Rental Invoice";
			//**Service Tax
			$taxation_type = $row_booking['taxation_type'];
			$service_tax_per = $row_booking['service_tax'];
			$service_charge1 = $row_booking['actual_cost'] + $row_booking['km_total_fee'];
			$service_tax1 = $row_booking['service_tax_subtotal'];
			//**Basic Cost
			$basic_cost = $row_booking['basic_amount'] - $row_booking['cancel_amount'];
			$other_charge = $row_booking['driver_allowance'] + $row_booking['permit_charges'] + $row_booking['toll_and_parking'] + $row_booking['state_entry_tax'] + $row_booking['other_charges']   ;
			$basic_cost += $other_charge;
			
			$net_amount = $row_booking['total_fees']  - $row_booking['cancel_amount'];
			$basic_cost1 = $row_booking['basic_amount'];
			$bal_amount = $net_amount - $paid_amount;

			$sq_sac = mysql_fetch_assoc(mysql_query("select * from sac_master where service_name='Car Rental'"));   
			$sac_code = $sq_sac['hsn_sac_code'];

			if($app_invoice_format == 4)
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/tax_invoice_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost1&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax1&net_amount=$net_amount&service_charge=$service_charge1&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&pass_count=$pass_count&credit_card_charges=$credit_card_charges";
			else
			$url1 = BASE_URL."model/app_settings/print_html/invoice_html/body/carrental_body_html.php?invoice_no=$invoice_no&invoice_date=$invoice_date&customer_id=$customer_id&service_name=$service_name&basic_cost=$basic_cost&taxation_type=$taxation_type&service_tax_per=$service_tax_per&service_tax=$service_tax1&net_amount=$net_amount&service_charge=$other_charge&total_paid=$paid_amount&balance_amount=$bal_amount&sac_code=$sac_code&branch_status=$branch_status&booking_id=$booking_id&credit_card_charges=$credit_card_charges";
			
			$temp_arr = array( "data" => array(
				(int)($count),
				get_car_rental_booking_id($row_booking['booking_id'],$year),
				$customer_name,
				$contact_no,
				$email_id,
				($row_booking['total_pax'] !='')?$row_booking['total_pax']:0,
				
				number_format($row_booking['total_fees'] + $credit_card_charges - $row_booking['cancel_amount'],2),
				$emp_name,
				'<button data-toggle="tooltip" display="inline" class="btn btn-danger btn-sm" onclick="booking_registration_pdf('.$row_booking['booking_id'] .')" title="Download Duty Slip"><i class="fa fa-file-pdf-o"></i></button><a onclick="loadOtherPage(\''. $url1.'\')" class="btn btn-info btn-sm" title="Download Invoice"><i class="fa fa-print"></i></a><button class="btn btn-info btn-sm" data-toggle="tooltip" display="inline-block" onclick="booking_update_modal('.$row_booking['booking_id'] .')" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>

				<button class="btn btn-info btn-sm" display="inline-block" data-toggle="tooltip" onclick="car_display_modal('. $row_booking['booking_id'] .')" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
				
				<button class="btn btn-danger btn-sm" display="inline-block" data-toggle="tooltip" onclick="booking_cancel('. $row_booking['booking_id'] .')" title="Cancel This Booking"><i class="fa fa-times"></i></button>'
			  ), "bg" =>$bg );
			  array_push($array_s,$temp_arr); 
			}
			echo json_encode($array_s);
?>