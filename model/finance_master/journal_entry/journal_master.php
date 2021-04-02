<?php 
class journal_master{

public function journal_master_save()
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$debit_ledger_id_arr = $_POST['debit_ledger_id_arr'];
	$debit_ledger_amt_arr = $_POST['debit_ledger_amt_arr'];
	$credit_ledger_id_arr = $_POST['credit_ledger_id_arr'];
	$credit_ledger_amt_arr = $_POST['credit_ledger_amt_arr'];

	$financial_year_id = $_SESSION['financial_year_id'];

	$created_at = date('Y-m-d');
	$entry_date = get_date_db($entry_date);

	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from journal_entry_master"));
	$entry_id = $sq_max['max'] + 1;

	begin_t();

	$sq_bank = mysql_query("insert into journal_entry_master (entry_id, entry_date,narration, created_at,financial_year_id) values ('$entry_id', '$entry_date','$narration', '$created_at','$financial_year_id')");

	//Debited account
	for($i=0;$i<sizeof($debit_ledger_id_arr);$i++)
	{
		$sq_max = mysql_fetch_assoc(mysql_query("select max(acc_id) as max from journal_entry_accounts"));
		$acc_id = $sq_max['max'] + 1;
		$sq_bank = mysql_query("insert into journal_entry_accounts (acc_id, entry_id, ledger_id,type,amount) values ('$acc_id', '$entry_id', '$debit_ledger_id_arr[$i]','Debit','$debit_ledger_amt_arr[$i]')");

		//Finance Save
		$this -> debit_finance_save($entry_id,$debit_ledger_id_arr[$i],$debit_ledger_amt_arr[$i]);
	}

	//Credited account
	for($i=0;$i<sizeof($credit_ledger_id_arr);$i++)
	{
		$sq_max = mysql_fetch_assoc(mysql_query("select max(acc_id) as max from journal_entry_accounts"));
		$acc_id = $sq_max['max'] + 1;
		$sq_bank = mysql_query("insert into journal_entry_accounts (acc_id, entry_id, ledger_id,type,amount) values ('$acc_id', '$entry_id', '$credit_ledger_id_arr[$i]','Credit','$credit_ledger_amt_arr[$i]')");

		//Finance Save
		$this -> credit_finance_save($entry_id,$credit_ledger_id_arr[$i],$credit_ledger_amt_arr[$i]);
	}
	if($sq_bank){
		commit_t();
		echo "Journal Entry saved.";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Journal Entry not saved!";
		exit;
	}

}

public function debit_finance_save($entry_id,$debit_ledger_id,$debit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;
	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $debit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $gl_id = $debit_ledger_id;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'JOURNAL VOUCHER');
}

public function credit_finance_save($entry_id,$credit_ledger_id,$credit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;
	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $credit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $gl_id = $credit_ledger_id;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'JOURNAL VOUCHER');
}

public function journal_master_update()
{
	$entry_date = $_POST['entry_date'];
	$entry_id = $_POST['entry_id'];
	$narration = $_POST['narration'];
	$debit_ledger_id_arr = $_POST['debit_ledger_id_arr'];
	$debit_ledger_amt_arr = $_POST['debit_ledger_amt_arr'];
	$credit_ledger_id_arr = $_POST['credit_ledger_id_arr'];
	$credit_ledger_amt_arr = $_POST['credit_ledger_amt_arr'];
	$debit_old_amt_arr = $_POST['debit_old_amt_arr'];
	$credit_old_amt_arr = $_POST['credit_old_amt_arr'];
	$entry_id_arr1 = $_POST['entry_id_arr1'];
	$entry_id_arr2 = $_POST['entry_id_arr2'];

	$entry_date = get_date_db($entry_date);

	begin_t();

	$sq_bank = mysql_query("update journal_entry_master set narration='$narration' where entry_id='$entry_id'");
	
	//Debited account
	for($i=0;$i<sizeof($debit_ledger_id_arr);$i++)
	{
		$sq_bank = mysql_query("update journal_entry_accounts set amount='$debit_ledger_amt_arr[$i]' where acc_id='$entry_id_arr1[$i]'");
		//Finance Save
		if($debit_ledger_amt_arr[$i] == '0'){
			$this -> debit_finance_update($entry_id,$debit_ledger_id_arr[$i],$debit_old_amt_arr[$i]);
		}
		else{
			$this -> debit_narr_update($entry_id,$debit_ledger_id_arr[$i],$debit_old_amt_arr[$i]);
		}
	}
	//Credited account
	for($i=0;$i<sizeof($credit_ledger_id_arr);$i++)
	{
		$sq_bank = mysql_query("update journal_entry_accounts set amount='$credit_ledger_amt_arr[$i]' where acc_id='$entry_id_arr2[$i]'");
		//Finance Save
		if($credit_ledger_amt_arr[$i] == '0'){
			$this -> credit_finance_update($entry_id,$credit_ledger_id_arr[$i],$credit_old_amt_arr[$i]);
		}
		else{
			$this -> credit_narr_update($entry_id,$credit_ledger_id_arr[$i],$credit_old_amt_arr[$i]);
		}
	}

	if($sq_bank){
		commit_t();
		echo "Journal Entry updated successfully!";
		exit;
	}
	else{
		rollback_t();
		echo "error--Sorry, Journal Entry not updated!";
		exit;
	}

}
public function debit_narr_update($entry_id,$debit_ledger_id,$debit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;

	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $debit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $old_gl_id = $gl_id = $debit_ledger_id;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'JOURNAL VOUCHER');
}

public function credit_narr_update($entry_id,$credit_ledger_id,$credit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;
	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $credit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $old_gl_id = $gl_id = $credit_ledger_id;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'JOURNAL VOUCHER');
	
}

public function debit_finance_update($entry_id,$debit_ledger_id,$debit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;
	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $debit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $gl_id = $debit_ledger_id;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'JOURNAL VOUCHER');
}

public function credit_finance_update($entry_id,$credit_ledger_id,$credit_ledger_amt)
{
	$entry_date = $_POST['entry_date'];
	$narration = $_POST['narration'];
	$entry_date = get_date_db($entry_date);

	global $transaction_master;
	$module_name = "Journal Entry";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $credit_ledger_amt;
    $payment_date = $entry_date;
    $payment_particular = $narration;
    $ledger_particular = '';
    $gl_id = $credit_ledger_id;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'JOURNAL VOUCHER');
}

}
?>