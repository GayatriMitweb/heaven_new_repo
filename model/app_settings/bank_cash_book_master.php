<?php 
global $bank_cash_book_master;
$bank_cash_book_master = new bank_cash_book_master;
class bank_cash_book_master{

public function bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id)
{
	$emp_id = $_SESSION['emp_id'];
	$payment_date = get_date_db($payment_date);

	$sq_max = mysql_fetch_assoc(mysql_query("select max(register_id) as max from bank_cash_book_master"));
	$register_id = $sq_max['max'] + 1;
	$particular = addslashes($particular);

	$sq_register = mysql_query("insert into bank_cash_book_master (register_id,branch_admin_id, module_name, module_entry_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, particular, clearance_status, payment_side, payment_type, emp_id) values ('$register_id', '$branch_admin_id', '$module_name', '$module_entry_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$particular', '$clearance_status', '$payment_side', '$payment_type','$emp_id')");
	if(!$sq_register){
		$GLOBALS['flag'] = false;
		echo "Cash/Bank book not saved!";
	}

}

public function bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type)
{
	$payment_date = get_date_db($payment_date);
	$particular = addslashes($particular);
	$q = "update bank_cash_book_master set payment_date='$payment_date', payment_amount='$payment_amount', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', particular='$particular', clearance_status='$clearance_status', payment_side='$payment_side', payment_type='$payment_type' where module_name='$module_name' and module_entry_id='$module_entry_id'";
	$sq_register = mysql_query($q);
	if(!$sq_register){
		$GLOBALS['flag'] = false;
		echo "Cash/Bank book not updated!";
	}

}


}
?>