<?php 
$flag = true;
class payment_master{

public function payment_save()
{
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

	$financial_year_id = $_SESSION['financial_year_id'];	

	//**Starting trasnaction
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from miscellaneous_payment_master"));
	$payment_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into miscellaneous_payment_master (payment_id, booking_id, financial_year_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status) values ('$payment_id', '$booking_id', '$financial_year_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status') ");
	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Payment not saved!";
	}

	//Finance save
	$this->finance_save($payment_id);

	//Bank and Cash Book Save
	$this->bank_cash_book_save($payment_id);

	if($GLOBALS['flag']){
		commit_t();
    	echo "Payment saved!";
		exit;	
	}
	else{
		rollback_t();
		exit;
	}
		
}

public function finance_save($payment_id)
{
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id1 = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from miscellaneous_booking_master where booking_id='$booking_id'"));

	global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received;

	$module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
    $payment_side = "Debit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);

    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
    $gl_id = $sundry_debitor;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);
}

public function bank_cash_book_save($payment_id)
{
	global $bank_cash_book_master;	

	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from miscellaneous_booking_master where booking_id='$booking_id'"));

	$module_name = "Miscellaneous Booking Payment";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}


public function payment_update()
{
	$payment_id = $_POST['payment_id'];
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];	

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$financial_year_id = $_SESSION['financial_year_id'];

	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_payment_master where payment_id='$payment_id'"));

	$clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];
	if($payment_mode=="Cash"){ $clearance_status = ""; }

	//**Starting transaction
	begin_t();

	$sq_payment = mysql_query("update miscellaneous_payment_master set booking_id='$booking_id', financial_year_id='$financial_year_id', payment_date='$payment_date', payment_amount='$payment_amount', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status' where payment_id='$payment_id' ");
	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Payment not update!";
	}

	//Finance update
	$this->finance_update($sq_payment_info, $clearance_status);

	//Bank/Cashbook update
	$this->bank_cash_book_update($clearance_status);

	if($GLOBALS['flag']){
		commit_t();
		echo "Payment Updated";
		exit;			
	}
	else{
		rollback_t();
		exit;
	}

	
}

public function finance_update($sq_payment_info, $clearance_status1)
{
	$payment_id = $_POST['payment_id'];
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from miscellaneous_booking_master where booking_id='$booking_id'"));

	global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received;

    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
    $old_gl_id = ($sq_payment_info['payment_mode']=="Cash") ? $cash_in_hand : $bank_account;
    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;
    $payment_side = "Debit";
    $clearance_status = $clearance_status1;
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

    $module_name = "Miscellaneous Booking Payment";
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
    $old_gl_id = $gl_id = $sundry_debitor;
    $payment_side = "Credit";
    $clearance_status = $clearance_status1;
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);


}

public function bank_cash_book_update($clearance_status)
{
	global $bank_cash_book_master;

	$payment_id = $_POST['payment_id'];
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];	

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from miscellaneous_booking_master where booking_id='$booking_id'"));

	$module_name = "Miscellaneous Booking Payment";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_miscellaneous_booking_payment_id($payment_id), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_miscellaneous_booking_id($booking_id));
	$clearance_status = $clearance_status;
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}

}
?>