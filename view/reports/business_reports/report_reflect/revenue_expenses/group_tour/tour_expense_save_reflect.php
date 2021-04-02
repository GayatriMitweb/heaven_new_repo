<?php 
include "../../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];

$total_sale = 0; $total_purchase = 0;
$array_s = array();
$temp_arr = array();
//Sale
$q1 = mysql_query("select *  from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id ='$tour_group_id' ");
while($tourwise_details = mysql_fetch_assoc($q1)){
	$sq_sum = mysql_fetch_assoc(mysql_query("select sum(basic_amount) as incentive_amount from booker_incentive_group_tour where tourwise_traveler_id='$tourwise_details[id]'"));
	$incentive_amount = $sq_sum['incentive_amount'];
	//Cancel consideration
	$sq_tr_refund = mysql_num_rows(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_details[id]'"));
	$sq_tour_refund = mysql_num_rows(mysql_query("select * from refund_tour_estimate where tourwise_traveler_id='$tourwise_details[id]'"));
	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Cancelled'"));
	$credit_charges = $sq_paid_amount['sumc'];

	if($sq_tour_refund == '0' || $sq_tr_refund == '0'){
		$actual_travel_expense = $tourwise_details['total_travel_expense'];
		$actual_tour_expense = $tourwise_details['total_tour_fee'];
		$sale_amount = $tourwise_details['net_total'] - $incentive_amount;
		$tax_amount = $tourwise_details['train_service_tax_subtotal'] + $tourwise_details['plane_service_tax_subtotal'] + $tourwise_details['cruise_service_tax_subtotal'] + $tourwise_details['visa_service_tax_subtotal'] + $tourwise_details['insuarance_service_tax_subtotal'] + $tourwise_details['service_tax'];
		$sale_amount -= $tax_amount;
		$total_sale += $sale_amount;
	}
}
$total_sale += $credit_charges;

// Purchase
$sq_purchase = mysql_query("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and status!='Cancel'");
while($row_purchase = mysql_fetch_assoc($sq_purchase)){
	$total_purchase += $row_purchase['net_total'] ;
	$total_purchase -= $row_purchase['service_tax_subtotal'];
}

//Other Expense
$sq_other_purchase = mysql_fetch_assoc(mysql_query("select sum(amount) as amount_total from group_tour_estimate_expense where tour_id='$tour_id' and tour_group_id ='$tour_group_id'"));
$total_purchase += $sq_other_purchase['amount_total'];


//Revenue & Expenses
$result = $total_sale - $total_purchase;

if($total_sale > $total_purchase){
	$var = 'Total Profit';
}else{
	$var = 'Total Loss';
}
$profit_loss = $total_sale - $total_purchase;
?>



<?php 
$count = 1;
$q1 = mysql_query("select *  from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id ='$tour_group_id' ");
while($row_query = mysql_fetch_assoc($q1)){
	$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_query[emp_id]'"));
	$emp = ($row_query['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name']; 

	$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Cancelled'"));
	$credit_charges = $sq_paid_amount['sumc'];

	$actual_travel_expense = $row_query['total_travel_expense'];
	$actual_tour_expense = $row_query['total_tour_fee'];
	$sale_amount = $row_query['net_total'] - $incentive_amount;
	$tax_amount = $row_query['train_service_tax_subtotal'] + $row_query['plane_service_tax_subtotal'] + $row_query['cruise_service_tax_subtotal'] + $row_query['visa_service_tax_subtotal'] + $row_query['insuarance_service_tax_subtotal'] + $row_query['service_tax'];
	$sale_amount -= $tax_amount;
	$sale_amount += $credit_charges;
	$date = $row_query['form_date'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$temp_arr = array( "data" => array(

		(int)(++$count),
		get_group_booking_id($row_query['id'],$year),
		get_date_user($row_query['form_date']),
		number_format($sale_amount,2),
		$emp,
		'<button class="btn btn-info btn-sm" onclick="view_purchase_modal('. $tour_id .','.$tour_group_id.')" data-toggle="tooltip" title="View Purchase"><i class="fa fa-eye"></i></button>',
		'<button class="btn btn-info btn-sm" onclick="other_expnse_modal('. $tour_id .','.$tour_group_id .')" data-toggle="tooltip" title="Add Other Miscellaneous amount"><i class="fa fa-plus"></i></button>'
		
		), "bg" =>$bg);
	array_push($array_s,$temp_arr);
	
}
echo json_encode($array_s);
?>
	