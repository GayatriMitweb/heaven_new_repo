<?php 
$flag = true;
class incentive{

public function save()
{
	$incentive_arr = json_decode($_POST['incentive_arr']);
	
	$booking_id = $incentive_arr[0]->booking_id;
	$estimate_type = $incentive_arr[0]->estimate_type;
	$emp_id = $incentive_arr[0]->emp_id;
	$basic_amount = $incentive_arr[0]->basic_amount;
	$financial_year_id = $incentive_arr[0]->financial_year_id;
	$booking_date = $incentive_arr[0]->booking_date;
	$booking_date = date('Y-m-d', strtotime($booking_date));
	$incentive_count = mysql_num_rows(mysql_query("select * from booker_sales_incentive booking_id='$booking_id' and emp_id='$emp_id'"));
	if($incentive_count>0){
		echo "error--Sorry, You already entered this incentive.";
		exit;
	}

	$incentive_id = mysql_fetch_assoc(mysql_query( "select max(incentive_id) as max from booker_sales_incentive" ));
	$incentive_id = $incentive_id['max']+1;
	$sq = mysql_query("INSERT INTO `booker_sales_incentive`(`incentive_id`, `service_type`, `emp_id`, `booking_id`, `basic_amount`, `tds`, `incentive_amount`, `financial_year_id`, `booking_date`) VALUES ('$incentive_id','$estimate_type','$emp_id','$booking_id','$basic_amount','','$basic_amount','$financial_year_id','$booking_date')");
	$this->finance_save($booking_id, $emp_id);

	if($sq){
		echo "Incentive has been successfully saved.";
		exit;
	}
	else{
		echo "error--Sorry, Incentive not added.";
		exit;
	}

}
public function finance_save($booking_id,$emp_id)
{
	$incentive_amount = $_POST['incentive_amount'];
	$tds = $_POST['tds'];
	$basic_amount = $_POST['basic_amount'];
    $tds1 = ($basic_amount * ( $tds / 100));
    global $transaction_master;
    global $cash_in_hand, $bank_account, $booker_incentives ,$fiance_vars;

    //***========================Incentive entries start=============================***//
     //incentive amount
    $module_name = 'Booker Incentive Estimate';
    $module_entry_id = $booking_id;
    $transaction_type = '';
    $payment_amount = $incentive_amount;
    $payment_date = '';
    $payment_particular = get_incentive_paid_particular($emp_id);
    $gl_id = '146';
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_type, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

     //**TDS**//
    $module_name="Booker Incentive Estimate";
    $module_entry_id = $booking_id;
    $transaction_type = "";
    $payment_amount = $tds1;
    $payment_date = "";
    $payment_particular = get_incentive_paid_particular($emp_id);
    $gl_id = $fiance_vars['tds_paid'];
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_type, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    //basic amount
    $module_name = 'Booker Incentive Estimate';
    $module_entry_id = $booking_id;
    $transaction_type = '';
    $payment_amount = $incentive_amount;
    $payment_date = '';
    $payment_particular = get_incentive_paid_particular($emp_id);
    $gl_id = $booker_incentives;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_type, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);
}
public function update()
{
	$incentive_arr = json_decode($_POST['incentive_arr']);
	
	$booking_id = $incentive_arr[0]->booking_id;
	$estimate_type = $incentive_arr[0]->booking_type;
	$emp_id = $incentive_arr[0]->emp_id;
	$basic_amount = $incentive_arr[0]->basic_amount;
	$booking_date = $incentive_arr[0]->booking_date;
	
	$sq = mysql_query("update booker_sales_incentive set basic_amount='$basic_amount', tds='$tds', incentive_amount='$basic_amount' where booking_id='$booking_id' and emp_id='$emp_id' and service_type='$estimate_type'");
	if($sq){
		echo "Incentive has been successfully updated.";
		exit;
	}
	else{
		echo "error--Sorry, Incentive not updated.";
		exit;
	}
}

}
?>