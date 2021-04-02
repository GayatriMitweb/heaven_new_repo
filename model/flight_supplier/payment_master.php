<?php 
$flag = true;
class payment_master{

public function payment_save()
{
	$sup_id = $_POST['sup_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";

	$financial_year_id = $_SESSION['financial_year_id']; 

	$created_at = date('Y-m-d H:i:s');

	$payment_date = get_date_db($payment_date);

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from flight_supplier_payment"));
	$advance_id = $sq_max['max'] + 1;

	$sq_income = mysql_query("insert into flight_supplier_payment (id, supplier_id, financial_year_id, payment_amount, payment_date, payment_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$advance_id', '$sup_id', '$financial_year_id', '$payment_amount', '$payment_date', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at')");
	if($sq_income)
	{
		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$sup_id'"));
		$vendor_name = $sq_vendor['vendor_name'];
		$vendor_name = addslashes($vendor_name);
		$sq_vendor_count = mysql_num_rows(mysql_query("select * from ledger_master where customer_id='$sup_id' and user_type='Ticket Vendor' and group_sub_id='23'"));
		if($sq_vendor_count != '0' ){
			$sq_vendor_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$sup_id' and user_type='Ticket Vendor' and group_sub_id='23'"));
			$ledger_id = $sq_vendor_ledger['ledger_id'];	
		}
		else{
			$sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
		    $ledger_id = $sq_max['max'] + 1;
		    $ledger_name = 'Advances to '.$vendor_name.' A/c';

		    $sq_ledger = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type) values ('$ledger_id', '$ledger_name', '', '23', '0','Dr','$sup_id','Ticket Vendor')");
		}

		//Finance Save
		$this->finance_save($advance_id,$ledger_id,$vendor_name);

		//Bank and Cash Book Save
		$this->bank_cash_book_save($advance_id,$vendor_name);

		global $model;
		$sq_supplier = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$sup_id'"));
		$subject = $sq_supplier['vendor_name']." Airline Topup Recharged with amount ".$payment_amount;
   	    $model->while_topup_mail_send($payment_amount, $sq_supplier['vendor_name'],'airline');

		if($GLOBALS['flag']){
			commit_t();
			echo "Payment has been successfully saved.";
			exit;
		}

	}
	else{
		rollback_t();
		echo "error--Payment not saved!";
		exit;
	}

}


public function finance_save($payment_id,$ledger_id,$vendor_name)
{
	$row_spec = 'purchase';
	$sup_id = $_POST['sup_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	global $transaction_master;

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

	//////Payment Amount///////
    $module_name = 'Ticket Vendor';
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_flight_supplier_particular($vendor_name);
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

    ////////Supplier Amount//////
    $module_name = 'Ticket Vendor';
    $module_entry_id = $payment_id;
    $transaction_id = $transaction_id1;
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date;
    $payment_particular = get_flight_supplier_particular($vendor_name);
    $ledger_particular = '';
    $gl_id = $ledger_id;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
}

public function bank_cash_book_save($advance_id,$vendor_name)
{
	global $bank_cash_book_master;

	$cust_id = $_POST['cust_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	
	$module_name = "Airline Supplier Payment";
	$module_entry_id = $advance_id;
	$payment_date = $payment_date1;
	$payment_amount = $payment_amount1;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id1;
	$bank_id = $bank_id;
	$particular = get_flight_supplier_particular($vendor_name);
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	
}


public function payment_update()
{
	$pay_id = $_POST['pay_id'];
	$sup_id = $_POST['sup_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$payment_old_value = $_POST['payment_old_value'];

	$financial_year_id = $_SESSION['financial_year_id']; 

	$payment_date = get_date_db($payment_date);

	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from flight_supplier_payment where id='$pay_id'"));

	$clearance_status = ($sq_payment_info['payment_mode']=='Cheque') ? "Pending" : $sq_payment_info['clearance_status'];

	begin_t();

	$sq_income = mysql_query("update flight_supplier_payment set supplier_id='$sup_id', financial_year_id='$financial_year_id', payment_amount='$payment_amount', payment_date='$payment_date', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status' where id='$pay_id'");
	if($sq_income){

		$sq_vendor = mysql_fetch_assoc(mysql_query("select * from ticket_vendor where vendor_id='$sup_id'"));
		$vendor_name = $sq_vendor['vendor_name'];
		//Finance Update
		$this->finance_update($sq_payment_info, $clearance_status,$vendor_name);

		//Bank and Cash Book Save
		$this->bank_cash_book_update($clearance_status,$vendor_name);

		if($GLOBALS['flag']){
			commit_t();
			echo "Payment has been successfully updated.";
			exit;
		}

	}
	else{
		rollback_t();
		echo "error--Payment not update!";
		exit;
	}

}


public function finance_update($sq_payment_info, $clearance_status1,$vendor_name)
{
	$row_spec = 'purchase';
	$payment_id = $_POST['pay_id'];
	$sup_id = $_POST['sup_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$payment_old_value = $_POST['payment_old_value'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	global $transaction_master;
	
    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

    $sq_vendor_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$sup_id' and user_type='Ticket Vendor' and group_sub_id='23'"));
    $ledger_id = $sq_vendor_ledger['ledger_id'];

    if($payment_amount1 > $payment_old_value)
	{
		$balance_amount = $payment_amount1 - $payment_old_value;
		//////Payment Amount///////
	    $module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    ////////Balance Amount//////
	    $module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $balance_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $ledger_id;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    //Reverse first payment amount
		$module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_old_value;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);
	}
	else if($payment_amount1 < $payment_old_value)
	{
		$balance_amount = $payment_old_value - $payment_amount1;
		//////Payment Amount///////
	    $module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    ////////Balance Amount//////
	    $module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $balance_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $ledger_id;
	    $payment_side = "Credit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);  
	    
	    //Reverse first payment amount
		$module_name = 'Ticket Vendor';
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_old_value;
	    $payment_date = $payment_date;
	    $payment_particular = get_flight_supplier_particular($vendor_name);
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);
	} 
	else{
      //Do nothing
	}

}

public function bank_cash_book_update($clearance_status1,$vendor_name)
{
	global $bank_cash_book_master;

	$pay_id = $_POST['pay_id'];
	//$cust_id = $_POST['cust_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	
	$module_name = "Airline Supplier Payment";
	$module_entry_id = $pay_id;
	$payment_date = $payment_date1;
	$payment_amount = $payment_amount1;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id1;
	$bank_id = $bank_id;
	$particular = get_flight_supplier_particular($vendor_name);
	$clearance_status = $clearance_status1;
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
	
}

}
?>