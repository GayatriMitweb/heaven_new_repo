<?php 
$flag = true;
class advance_master{

public function advance_save()
{
	$cust_id = $_POST['cust_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];
	$branch_admin_id = $_POST['branch_admin_id'];

	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";

	$financial_year_id = $_SESSION['financial_year_id']; 

	$created_at = date('Y-m-d H:i:s');

	$payment_date = get_date_db($payment_date);

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(advance_id) as max from corporate_advance_master"));
	$advance_id = $sq_max['max'] + 1;

	$particular = addslashes($particular);
	$sq_income = mysql_query("insert into corporate_advance_master (advance_id, cust_id, financial_year_id,branch_admin_id, payment_amount, payment_date, payment_mode, bank_name, transaction_id, bank_id, clearance_status, particular, created_at) values ('$advance_id', '$cust_id', '$financial_year_id', '$branch_admin_id', '$payment_amount', '$payment_date', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$particular', '$created_at')");
	if($sq_income)
	{
		$sq_vendor_count = mysql_num_rows(mysql_query("select * from ledger_master where customer_id='$cust_id' and user_type='customer' and group_sub_id='22'"));
		if($sq_vendor_count != '0' ){
			$sq_vendor_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$cust_id' and user_type='customer' and group_sub_id='22'"));
			$ledger_id = $sq_vendor_ledger['ledger_id'];	
		    $sq_update = mysql_query("update corporate_advance_master set ledger_id='$ledger_id' where advance_id='$advance_id'");
		}
		else{
			$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$cust_id'"));			
			$sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
		    $ledger_id = $sq_max['max'] + 1;
		    $ledger_name = 'Advances from '.$sq_cust['company_name'].' A/c';

		    $sq_ledger = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type) values ('$ledger_id', '$ledger_name', '', '22', '0','Cr','$cust_id','customer')");
		    $sq_update = mysql_query("update corporate_advance_master set ledger_id='$ledger_id' where advance_id='$advance_id'");
		}
		//Finance Save
		$this->finance_save($advance_id,$ledger_id);

		//Bank and Cash Book Save
		$this->bank_cash_book_save($advance_id);

		if($GLOBALS['flag']){
			commit_t();
			echo "Advances has been successfully saved.";
			exit;
		}

	}
	else{
		rollback_t();
		echo "error--Advance not saved!";
		exit;
	}

}

public function finance_save($income_id,$ledger_id)
{
	$row_spec = 'sale advance';
	$cust_id = $_POST['cust_id'];
	$income_type_id = $_POST['income_type_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];
	$branch_admin_id = $_POST['branch_admin_id'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));

	$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from other_income_type_master where income_type_id='$income_type_id'"));

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

	global $transaction_master;

	//Bank Or Cash    
    $module_name = "Corporate Advance Payment";
    $module_entry_id = $income_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date1;
    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $pay_gl;
    $payment_side = "Debit";
    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

    //Advance customer ledger
	$module_name = "Corporate Advance Payment";
    $module_entry_id = $income_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date1;
    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $ledger_id;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
}

public function bank_cash_book_save($income_id)
{
	global $bank_cash_book_master;

	$cust_id = $_POST['cust_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	
	$module_name = "Corporate Advance Payment";
	$module_entry_id = $income_id;
	$payment_date = $payment_date1;
	$payment_amount = $payment_amount1;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id1;
	$bank_id = $bank_id;
	$particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
	$ledger_particular = get_ledger_particular('By','Cash/Bank');
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	
}


public function advance_update()
{
	$advance_id = $_POST['advance_id'];
	$cust_id = $_POST['cust_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];
	$payment_amount_old = $_POST['payment_amount_old'];

	$financial_year_id = $_SESSION['financial_year_id']; 

	$payment_date = get_date_db($payment_date);

	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from corporate_advance_master where advance_id='$advance_id'"));

	$clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];
	if($payment_mode=="Cash"){ $clearance_status = ""; }

	begin_t();
	$particular = addslashes($particular);
	$sq_income = mysql_query("update corporate_advance_master set cust_id='$cust_id', financial_year_id='$financial_year_id', payment_amount='$payment_amount', payment_date='$payment_date', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status', particular='$particular' where advance_id='$advance_id'");
	if($sq_income){

		$sq_ledger = mysql_fetch_assoc(mysql_query("select * from corporate_advance_master where advance_id='$advance_id'"));
		//Finance Update
		$this->finance_update($sq_payment_info, $clearance_status,$sq_ledger['ledger_id']);

		//Bank and Cash Book Save
		$this->bank_cash_book_update($clearance_status);

		if($GLOBALS['flag']){
			commit_t();
			echo "Advances has been successfully updated.";
			exit;
		}

	}
	else{
		rollback_t();
		echo "error--Advance not updated!";
		exit;
	}

}


public function finance_update($sq_payment_info, $clearance_status1,$ledger_id)
{
	$row_spec = 'sale advance';
	$advance_id = $_POST['advance_id'];
	$cust_id = $_POST['cust_id'];
	$income_type_id = $_POST['income_type_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];
	$payment_amount_old = $_POST['payment_amount_old'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
    
    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

	global $transaction_master;


	if($payment_amount1 > $payment_amount_old){
		$balance_amount = $payment_amount1 - $payment_amount_old;
		//Bank Or Cash    
	    $module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //Advance customer ledger
		$module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $balance_amount;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $ledger_id;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	//Reverse First Payment  
	    $module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount_old;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
	else if($payment_amount1 < $payment_amount_old){
		$balance_amount = $payment_amount_old - $payment_amount1;
		//Bank Or Cash    
	    $module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //Advance customer ledger
		$module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $balance_amount;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $ledger_id;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //Reverse First Payment  
	    $module_name = "Corporate Advance Payment";
	    $module_entry_id = $advance_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount_old;
	    $payment_date = $payment_date1;
	    $payment_particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
	else{

	}
}

public function bank_cash_book_update($clearance_status1)
{
	global $bank_cash_book_master;

	$advance_id = $_POST['advance_id'];
	$cust_id = $_POST['cust_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$particular = $_POST['particular'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	
	$module_name = "Corporate Advance Payment";
	$module_entry_id = $advance_id;
	$payment_date = $payment_date1;
	$payment_amount = $payment_amount1;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id1;
	$bank_id = $bank_id;
	$particular = get_advance_particular($cust_id,$payment_mode,$payment_date);
	$clearance_status = $clearance_status1;
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	
}

}
?>