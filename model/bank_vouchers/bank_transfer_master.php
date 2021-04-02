<?php 
$flag = true;
class bank_transfer_master{
public function bank_transfer_save()
{
	$from_bank_id = $_POST['from_bank_id'];
	$to_bank_id = $_POST['to_bank_id'];
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$branch_admin_id = $_POST['branch_admin_id'];
    $emp_id = $_POST['emp_id']; 
    $financial_year_id = $_SESSION['financial_year_id'];

	$created_at = date('Y-m-d H:i:s');
    $payment_date = date('Y-m-d', strtotime($payment_date));
    $ins_date = date('Y-m-d', strtotime($ins_date));
    $lapse_date = ($lapse_date!='') ? date('Y-m-d', strtotime($lapse_date)) : '';

    $clearance_status = ($trans_type=="Cheque") ? "Pending" : "";
    
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from inter_bank_transfer_master"));
	$entry_id = $sq_max['max'] + 1;
	$sq_deposit = mysql_query("insert into inter_bank_transfer_master (entry_id, from_bank_id,to_bank_id, amount,favouring_name, transaction_date, transaction_type,instrument_no,instrument_date,lapse_date, branch_admin_id, emp_id, financial_year_id, created_at) values ('$entry_id', '$from_bank_id','$to_bank_id', '$payment_amount','$f_name','$payment_date','$trans_type','$ins_no','$ins_date','$lapse_date', '$branch_admin_id','$emp_id' ,'$financial_year_id','$created_at') ");

	if($sq_deposit){
		//Finance save
    	$this->finance_save($entry_id,$branch_admin_id);
		//Bank and Cash Book Save
		$this->bank_cash_book_save($entry_id);

	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Payment has been successfully saved.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Bank Transfer Not Done!";
		exit;
	}
}

public function finance_save($entry_id,$branch_admin_id)
{
	$row_spec = 'bank';
	$from_bank_id = $_POST['from_bank_id'];
	$to_bank_id = $_POST['to_bank_id'];
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];

    $payment_date1 = date('Y-m-d', strtotime($payment_date));

    //from BANK Ledger
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$from_bank_id' and user_type='bank'"));
    $from_pay_gl = $sq_bank['ledger_id'];
    
    //to BANK Ledger
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$to_bank_id' and user_type='bank'"));
    $to_pay_gl = $sq_bank['ledger_id'];

    global $transaction_master;

    ////////////Basic deposit Amount/////////////

    $module_name = "Bank Transfer";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date1;
    $payment_particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date1,$trans_type);    
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $from_pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK PAYMENT');

    /////////bank////////
    $module_name = "Bank Transfer";
    $module_entry_id = $entry_id;
    $transaction_id = "";
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date1;
    $payment_particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date1,$trans_type);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $to_pay_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK PAYMENT');

}

public function bank_cash_book_save($payment_id)
{
	global $bank_cash_book_master;

	$from_bank_id = $_POST['from_bank_id'];
	$to_bank_id = $_POST['to_bank_id'];
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];

	$payment_date = date("Y-m-d", strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	$module_name = "Bank Transfer";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount1;
	$payment_mode = '';
	$bank_name = $bank_name;
	$transaction_id = '';
	$bank_id = $from_bank_id;
	$particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date,$trans_type);
	$clearance_status = "";
	$payment_side = "Credit";
	$payment_type = "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

	$module_name = "Bank Transfer";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount1;
	$payment_mode = '';
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $to_bank_id;
	$particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date,$trans_type);
	$clearance_status = "";
	$payment_side = "Debit";
	$payment_type = "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}

public function bank_transfer_update()
{	
	$entry_id = $_POST['entry_id'];	
	$from_bank_id = $_POST['from_bank_id'];	
	$to_bank_id = $_POST['to_bank_id'];	
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_old_amount = $_POST['payment_old_amount'];

    $lapse_date = get_date_db($lapse_date);
    $ins_date = get_date_db($ins_date);

	begin_t();
	$sq_deposit_u = mysql_query("update inter_bank_transfer_master set amount='$payment_amount',transaction_type='$trans_type',favouring_name='$f_name',instrument_date='$ins_date',lapse_date='$lapse_date',instrument_no='$ins_no' where entry_id='$entry_id'");

	if($sq_deposit_u){
		//Finance save
		$this->finance_update($entry_id);
		$this->bank_cash_book_update($entry_id);

	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Payment has been successfully updated.";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Transfer not updated!";
		exit;
	}

}
public function finance_update($entry_id)
{
	$row_spec = 'bank';
	$entry_id = $_POST['entry_id'];	
	$from_bank_id = $_POST['from_bank_id'];	
	$to_bank_id = $_POST['to_bank_id'];	
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date1 = $_POST['payment_date'];
	$payment_old_amount = $_POST['payment_old_amount'];

    $payment_date1 = date('Y-m-d', strtotime($payment_date1));

    //BANK Ledger
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
    $pay_gl = $sq_bank['ledger_id'];

    global $transaction_master;
    //from BANK Ledger
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$from_bank_id' and user_type='bank'"));
    $from_pay_gl = $sq_bank['ledger_id'];
    
    //to BANK Ledger
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$to_bank_id' and user_type='bank'"));
    $to_pay_gl = $sq_bank['ledger_id'];

    if($payment_amount1 == '0' && ($payment_old_amount != $payment_amount1))
    {
	    ////////////Basic deposit /////////////
	    $module_name = "Bank Transfer";
	    $module_entry_id = $entry_id;
	    $transaction_id = "";
	    $payment_amount = $payment_old_amount;
	    $payment_date = $payment_date1;
	    $payment_particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date1,$trans_type);    
	    $ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $to_pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK PAYMENT');

	    /////////bank////////
	    $module_name = "Bank Transfer";
	    $module_entry_id = $entry_id;
	    $transaction_id = "";
	    $payment_amount = $payment_old_amount;
	    $payment_date = $payment_date1;
	    $payment_particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date1,$trans_type);
	    $ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $from_pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'BANK PAYMENT');

    }
}

public function bank_cash_book_update($payment_id)
{
	global $bank_cash_book_master;

	$from_bank_id = $_POST['from_bank_id'];
	$to_bank_id = $_POST['to_bank_id'];
	$f_name = $_POST['f_name'];
	$trans_type = $_POST['trans_type'];
	$ins_no = $_POST['ins_no'];
	$ins_date = $_POST['ins_date'];
	$lapse_date = $_POST['lapse_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];

	$payment_date = date("Y-m-d", strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

    if($payment_amount1 == '0' && ($payment_old_amount != $payment_amount1))
    {
		$module_name = "Bank Transfer";
		$module_entry_id = $payment_id;
		$payment_date = $payment_date;
		$payment_amount = $payment_amount1;
		$payment_mode = '';
		$bank_name = $bank_name;
		$transaction_id = '';
		$bank_id1 = $from_bank_id;
		$particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date,$trans_type);
		$clearance_status = "";
		$payment_side = "Credit";
		$payment_type = "Bank";

		$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id1, $particular, $clearance_status, $payment_side, $payment_type);

		$module_name = "Bank Transfer";
		$module_entry_id = $payment_id;
		$payment_date = $payment_date;
		$payment_amount = $payment_amount1;
		$payment_mode = '';
		$bank_name = $bank_name;
		$transaction_id = $transaction_id;
		$bank_id = $to_bank_id;
		$particular = get_bank_transfer_particular($from_bank_id,$to_bank_id,$payment_date,$trans_type);
		$clearance_status = "";
		$payment_side = "Debit";
		$payment_type = "Bank";

		$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	}
}

}

?>