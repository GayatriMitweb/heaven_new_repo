<?php 

$flag = true;

class office_expense{



public function office_expense_type_save()

{

	$expense_type = $_POST['expense_type'];

	$gl_id = $_POST['gl_id'];




	$expense_type_count = mysql_num_rows(mysql_query("select * from office_expense_type where expense_type='$expense_type'"));

	if($expense_type_count>0){

		echo "error--Expense type already exists.";

		exit;

	}



	begin_t();



	$expense_type_id = mysql_fetch_assoc(mysql_query("select max(expense_type_id) as max from office_expense_type"));

	$expense_type_id = $expense_type_id['max'] + 1;



	$sq = mysql_query("insert into office_expense_type (expense_type_id, expense_type, gl_id) value ('$expense_type_id', '$expense_type', '$gl_id')");

	if($sq){

		commit_t();

		echo "Office expense type saved successfully.";

		exit;

	}

	else{

		rollback_t();

		echo "error--Office expense type not saved.";

		exit;

	}

}



public function office_expense_save()

{

	$expense_type_id = $_POST['expense_type_id'];

	$amount = $_POST['amount'];

	$expense_date = $_POST['expense_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];

	$bank_id = $_POST['bank_id'];
	$purchase_date = $_POST['purchase_date'];
	$branch = $_POST['branch'];
	$branch_admin_id = $_POST['branch_admin_id1'];

	$particular = $_POST['particular'];

	$expense_date = date('Y-m-d', strtotime($expense_date));
	$purchase_date = date('Y-m-d', strtotime($purchase_date));

	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";



	$financial_year_id = $_SESSION['financial_year_id']; 


	$particular = addslashes($particular);
	$bank_balance_status = bank_cash_balance_check($payment_mode, $bank_id, $amount);

	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($payment_mode, $bank_id); exit; }



	begin_t();



	$expense_id = mysql_fetch_assoc( mysql_query("select max(expense_id) as max from office_expense_master") );

	$expense_id = $expense_id['max'] + 1;	



	$sq = mysql_query("insert into office_expense_master ( expense_id, financial_year_id, expense_type_id, branch_admin_id, amount, expense_date, payment_mode, bank_name, transaction_id, bank_id, clearance_status, particular,purchase_date,branch_id ) values( '$expense_id', '$financial_year_id', '$expense_type_id', '$branch_admin_id', '$amount', '$expense_date', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$particular','$purchase_date','$branch' )");

	if($sq){



		//Finance Save

		$this->finance_save($expense_id);



		//Bank and Cash Book Save

		$this->bank_cash_book_save($expense_id);



		if($GLOBALS['flag']){

			commit_t();

			echo "Office expense saved successfully.";

			exit;	

		}

		

	}

	else{

		rollback_t();

		echo "error--Office expense not saved.";

		exit;

	}

}



public function finance_save($expense_id)

{



    $expense_type_id = $_POST['expense_type_id'];

	$amount = $_POST['amount'];

	$expense_date = $_POST['expense_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id1 = $_POST['transaction_id'];

	$bank_id = $_POST['bank_id'];



	$particular = $_POST['particular'];



	$expense_date = date('Y-m-d', strtotime($expense_date));



	$sq_expense_type_info = mysql_fetch_assoc(mysql_query("select * from office_expense_type where expense_type_id='$expense_type_id'"));



	global $transaction_master;

    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets;



	//Bank Or Cash

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$transaction_id = $transaction_id1;

	$payment_amount = $amount;

	$payment_date = $expense_date;

	$payment_particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;

	$payment_side = "Credit";

	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);	



	//Dynamic GL

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$transaction_id = $transaction_id1;

	$payment_amount = $amount;

	$payment_date = $expense_date;

	$payment_particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$gl_id = $sq_expense_type_info['gl_id'];

	$payment_side = "Debit";

	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);	

}



public function bank_cash_book_save($expense_id)

{

	global $bank_cash_book_master;



	$expense_type_id = $_POST['expense_type_id'];

	$amount = $_POST['amount'];

	$expense_date = $_POST['expense_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];

	$bank_id = $_POST['bank_id'];

	

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$payment_date = $expense_date;

	$payment_amount = $amount;

	$payment_mode = $payment_mode;

	$bank_name = $bank_name;

	$transaction_id = $transaction_id;

	$bank_id = $bank_id;

	$particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

	$payment_side = "Debit";

	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";



	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

	

}



public function office_expense_update()

{

	$expense_id = $_POST['expense_id'];

	$expense_type_id = $_POST['expense_type_id1'];

	$amount = $_POST['amount1'];

	$expense_date = $_POST['expense_date1'];
	$purchase_date = $_POST['purchase_date1'];

	$payment_mode = $_POST['payment_mode1'];

	$bank_name = $_POST['bank_name1'];

	$transaction_id = $_POST['transaction_id1'];

	$bank_id = $_POST['bank_id1'];

	$particular = $_POST['particular1'];
	$branch = $_POST['branch1'];



	$expense_date = date('Y-m-d', strtotime($expense_date));

	$purchase_date = date('Y-m-d', strtotime($purchase_date));

	$financial_year_id = $_SESSION['financial_year_id']; 



	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from office_expense_master where expense_id='$expense_id'"));



	$clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];

	if($payment_mode=="Cash"){ $clearance_status = ""; }



	$bank_balance_status = bank_cash_balance_check($payment_mode, $bank_id, $amount, $sq_payment_info['amount']);

	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($payment_mode, $bank_id); exit; }



	begin_t();


	$particular = addslashes($particular);
	$sq = mysql_query("update office_expense_master set financial_year_id='$financial_year_id', expense_type_id = '$expense_type_id', amount = '$amount', expense_date = '$expense_date', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status', particular = '$particular',purchase_date='$purchase_date',branch_id='$branch' where expense_id = '$expense_id'");

	if($sq){



		//Finance Update

		$this->finance_update($sq_payment_info, $clearance_status);



		//Bank and Cash Book Save

		$this->bank_cash_book_update($clearance_status);



		if($GLOBALS['flag']){

			commit_t();

			echo "Office expense updated successfully.";

			exit;	

		}

		

	}

	else{

		rollback_t();

		echo "error--Office expense not updated.";

		exit;

	}

}



public function finance_update($sq_payment_info, $clearance_status1)

{

	$expense_id = $_POST['expense_id'];

	$expense_type_id = $_POST['expense_type_id1'];

	$amount = $_POST['amount1'];

	$expense_date = $_POST['expense_date1'];

	$payment_mode = $_POST['payment_mode1'];

	$bank_name = $_POST['bank_name1'];

	$transaction_id1 = $_POST['transaction_id1'];

	$bank_id = $_POST['bank_id1'];

	$particular = $_POST['particular1'];



	$expense_date = date('Y-m-d', strtotime($expense_date));



	$sq_expense_type_info_old = mysql_fetch_assoc(mysql_query("select * from office_expense_type where expense_type_id='$sq_payment_info[expense_type_id]'"));

	$sq_expense_type_info = mysql_fetch_assoc(mysql_query("select * from office_expense_type where expense_type_id='$expense_type_id'"));



	global $transaction_master;

    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets;



	//Debit

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$transaction_id = $transaction_id1;

	$payment_amount = $amount;

	$payment_date = $expense_date;

	$payment_particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$old_gl_id = ($sq_payment_info['payment_mode']=="Cash") ? $cash_in_hand : $bank_account;

	$gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;

	$payment_side = "Credit";

	$clearance_status = $clearance_status1;

	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);



	//Credit

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$transaction_id = $transaction_id1;

	$payment_amount = $amount;

	$payment_date = $expense_date;

	$payment_particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$old_gl_id = $sq_expense_type_info_old['gl_id'];

	$gl_id = $sq_expense_type_info['gl_id'];

	$payment_side = "Debit";

	$clearance_status = $clearance_status1;

	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);





}



public function bank_cash_book_update($clearance_status)

{

	global $bank_cash_book_master;



	$expense_id = $_POST['expense_id'];

	$expense_type_id = $_POST['expense_type_id1'];

	$amount = $_POST['amount1'];

	$expense_date = $_POST['expense_date1'];

	$payment_mode = $_POST['payment_mode1'];

	$bank_name = $_POST['bank_name1'];

	$transaction_id = $_POST['transaction_id1'];

	$bank_id = $_POST['bank_id1'];

	$particular = $_POST['particular1'];

	

	$module_name = "Office Expense Payment";

	$module_entry_id = $expense_id;

	$payment_date = $expense_date;

	$payment_amount = $amount;

	$payment_mode = $payment_mode;

	$bank_name = $bank_name;

	$transaction_id = $transaction_id;

	$bank_id = $bank_id;

	$particular = get_expense_paid_particular(get_office_expense_payment_id($expense_id), $expense_type_id, $expense_date, $amount, $payment_mode);

	$clearance_status = $clearance_status;

	$payment_side = "Debit";

	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";



	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}





}

?>