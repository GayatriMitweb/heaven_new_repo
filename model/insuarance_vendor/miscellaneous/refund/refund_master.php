<?php 
$flag = true;
class refund_master{

public function refund_save()
{
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$created_at = date('Y-m-d H:i:s');

	$clearance_status = ($refund_mode!="Cash") ? "Pending" : "";

	$financial_year_id = $_SESSION['financial_year_id'];  
		 

	$bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }    

	//**Starting transaction
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from miscellaneous_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into miscellaneous_refund_master (refund_id, booking_id, financial_year_id, refund_date, refund_amount, refund_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$booking_id', '$financial_year_id', '$refund_date', '$refund_amount', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at') ");
	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Refund not saved!";		
	}
	
	//Finance save
	$this->finance_save($refund_id);

	//Bank and Cash Book Save
	$this->bank_cash_book_save($refund_id);

	if($GLOBALS['flag']){
		commit_t();
		echo "Refund saved successfully!";
		exit;	
	}
	else{
		rollback_t();
		exit;
	}
}

public function finance_save($refund_id)
{
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount1 = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$refund_date = date('Y-m-d', strtotime($refund_date));

	global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received;

	$module_name = "Miscellaneous Booking Refund";
    $module_entry_id = $refund_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $refund_amount1;
    $payment_date = $refund_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_refund_id($refund_id), $payment_date, $refund_amount1, $customer_id, $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    $module_name = "Miscellaneous Booking Refund";
    $module_entry_id = $refund_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $refund_amount1;
    $payment_date = $refund_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_refund_id($refund_id), $payment_date, $refund_amount1, $customer_id, $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = $sundry_debitor;
    $payment_side = "Debit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);
}

public function bank_cash_book_save($refund_id)
{
	global $bank_cash_book_master;

	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$module_name = "Miscellaneous Booking Refund";
	$module_entry_id = $refund_id;
	$payment_date = $refund_date;
	$payment_amount = $refund_amount;
	$payment_mode = $refund_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_refund_paid_particular(get_miscellaneous_booking_id($booking_id), $refund_date, $refund_amount, $refund_mode, get_miscellaneous_booking_refund_id($refund_id));
	$clearance_status = ($refund_mode!="Cash") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($refund_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}

}
?>