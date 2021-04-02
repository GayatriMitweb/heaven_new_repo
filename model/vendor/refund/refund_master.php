<?php 

$flag = true;

class refund_master{



public function refund_save()
{
	$estimate_id = $_POST['estimate_id'];
	$estimate_type_id =$_POST['estimate_type_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_amount = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$created_at = date('Y-m-d');

	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
    
	$financial_year_id = $_SESSION['financial_year_id'];
	$branch_admin_id = $_SESSION['branch_admin_id'];

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from vendor_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_refund = mysql_query("insert into vendor_refund_master(refund_id, financial_year_id, estimate_id, payment_amount, payment_date, payment_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$financial_year_id', '$estimate_id', '$payment_amount', '$payment_date', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at')");

	if($payment_mode == 'Debit Note'){

		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from debit_note_master"));
		$id = $sq_max['max'] + 1;
		$sq_refund = mysql_query("insert into debit_note_master (id, financial_year_id, estimate_id, vendor_type,vendor_type_id, payment_amount, refund_id, created_at,branch_admin_id) values ('$id', '$financial_year_id', '$estimate_id', '$vendor_type','$vendor_type_id','$payment_amount','$refund_id','$created_at','$branch_admin_id')");
	}


	if($sq_refund){

		//Finance Save
		$this->finance_save($refund_id);

		//Bank and Cash Book Save
		$this->bank_cash_book_save($refund_id);



		if($GLOBALS['flag']){

			commit_t();

			echo "Refund saved!";

			exit;	

		}

		else{

			rollback_t();

			exit;	

		}

		

	}

	else{

		rollback_t();

		echo "Refund not saved!";

		exit;

	}



}

public function finance_save($refund_id)
{
	$row_spec = 'purchase';
	$estimate_id = $_POST['estimate_id'];
	$estimate_type_id =$_POST['estimate_type_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$refund_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $refund_date);
	$yr1 =$year1[0];

	global $transaction_master;

  	//Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
		$pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

     //Getting supplier Ledger
    $sq_sup = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type'"));
    $supplier_gl = $sq_sup['ledger_id'];

	////////Refund Amount//////
    $module_name = $vendor_type;
    $module_entry_id = $refund_id;
    $transaction_id = "";
    $payment_amount = $payment_amount1;
    $payment_date = $refund_date;
    $payment_particular = get_refund_charges_particular(get_vendor_estimate_id($estimate_id,$yr1),get_vendor_refund_id($refund_id,$yr1),$vendor_type,$vendor_type_id,$payment_mode);
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');  

	////////Refund Amount//////
    $module_name = $vendor_type;
    $module_entry_id = $refund_id;
    $transaction_id = "";
    $payment_amount = $payment_amount1;
    $payment_date = $refund_date;
    $payment_particular = get_refund_charges_particular(get_vendor_estimate_id($estimate_id,$yr1),get_vendor_refund_id($refund_id,$yr1),$vendor_type,$vendor_type_id,$payment_mode);
    $ledger_particular = '';
    $gl_id = $supplier_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');  

}


public function bank_cash_book_save($refund_id)
{
	$estimate_id = $_POST['estimate_id'];
	$estimate_type_id =$_POST['estimate_type_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_date = $_POST['payment_date'];
	$payment_mode1 = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$refund_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $refund_date);
	$yr1 =$year1[0];

	global $bank_cash_book_master;

	$module_name = "Vendor Refund Paid";
	$module_entry_id = $refund_id;
	$payment_date = $refund_date;
	$payment_amount = $payment_amount1;
	$payment_mode = $payment_mode1;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_refund_charges_particular(get_vendor_estimate_id($estimate_id,$yr1),get_vendor_refund_id($refund_id,$yr1),$vendor_type,$vendor_type_id,$payment_mode1);
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}



public function refund_update()

{

	$refund_id = $_POST['refund_id'];

	$estimate_id = $_POST['estimate_id'];

	$payment_amount = $_POST['payment_amount'];

	$payment_date = $_POST['payment_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];

	$bank_id = $_POST['bank_id'];



	$payment_date = date('Y-m-d', strtotime($payment_date));



	$financial_year_id = $_SESSION['financial_year_id'];



	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from vendor_refund_master where refund_id='$refund_id'"));



	$clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];

	if($payment_mode=="Cash"){ $clearance_status = ""; }



	begin_t();



	$sq_refund = mysql_query("update vendor_refund_master set financial_year_id='$financial_year_id', estimate_id='$estimate_id', payment_amount='$payment_amount', payment_date='$payment_date', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status' where refund_id='$refund_id'");



	if($sq_refund){



		//Finance update

		$this->finance_update($sq_payment_info, $clearance_status);



		//Bank and Cash Book update

		$this->bank_cash_book_update($clearance_status);



		if($GLOBALS['flag']){

			commit_t();

			echo "Refund updated!";

			exit;	

		}

		

	}

	else{

		rollback_t();

		echo "Refund not updated!";

		exit;

	}



}



public function finance_update($sq_payment_info, $clearance_status1)

{

	$refund_id = $_POST['refund_id'];	

	$payment_amount1 = $_POST['payment_amount'];

	$payment_date = $_POST['payment_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id1 = $_POST['transaction_id'];

	$remark = $_POST['remark'];

	$bank_id = $_POST['bank_id'];



	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];





	global $transaction_master;

    global $cash_in_hand, $bank_account, $sundry_debitor, $sundry_creditor, $service_tax_assets, $service_charge_received, $cancel_charge_paid;



   

    //Bank/cash

    $module_name = "Vendor Refund Paid";

    $module_entry_id = $refund_id;

    $transaction_id = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular = get_refund_charges_particular(get_vendor_estimate_id($refund_id,$yr1), $payment_date, $payment_amount1, $payment_mode, get_vendor_refund_id($refund_id,$yr1),$payment_mode);

    $old_gl_id = ($sq_payment_info['payment_mode']=="Cash") ? $cash_in_hand : $bank_account;

    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;

    $payment_side = "Debit";

    $clearance_status = $clearance_status1;

    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, '',$payment_side, $clearance_status);



    //Sundry Creditor

    $module_name = "Vendor Refund Paid";

    $module_entry_id = $refund_id;

    $transaction_id = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular = get_refund_charges_particular(get_vendor_estimate_id($refund_id,$yr1), $payment_date, $payment_amount1, $payment_mode, get_vendor_refund_id($refund_id,$yr1),$payment_mode);

    $old_gl_id = $gl_id = $sundry_creditor;

    $payment_side = "Credit";

    $clearance_status = $clearance_status1;

    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, '',$payment_side, $clearance_status);

}



public function bank_cash_book_update($clearance_status)

{

	$refund_id = $_POST['refund_id'];

	

	$payment_amount = $_POST['payment_amount'];

	$payment_date = $_POST['payment_date'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];

	$remark = $_POST['remark'];

	$bank_id = $_POST['bank_id'];



	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];



	global $bank_cash_book_master;

	

	$module_name = "Vendor Refund Paid";

	$module_entry_id = $refund_id;

	$payment_date = $payment_date;

	$payment_amount = $payment_amount;

	$payment_mode = $payment_mode;

	$bank_name = $bank_name;

	$transaction_id = $transaction_id;

	$bank_id = $bank_id;

	$particular = get_refund_charges_particular(get_vendor_estimate_id($refund_id,$yr1), $payment_date, $payment_amount, $payment_mode, get_vendor_refund_id($refund_id,$yr1),$payment_mode);

	$clearance_status = $clearance_status;

	$payment_side = "Debit";

	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";



	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}





}

?>