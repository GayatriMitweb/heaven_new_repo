<?php 
$flag = true;
class vendor_payment_master{

public function vendor_payment_save()
{
	$row_spec='purchase';
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$advance_nullify = $_POST['advance_nullify'];
	$total_payment_amount = $_POST['total_payment_amount'];
	$total_purchase = $_POST['total_purchase'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$branch_admin_id = $_POST['branch_admin_id'];
    $emp_id = $_POST['emp_id'];
	$bank_id = $_POST['bank_id'];
	$payment_evidence_url = $_POST['payment_evidence_url'];

	$payment_amount_arr = $_POST['payment_amount_arr'];
	$purchase_type_arr = $_POST['purchase_type_arr'];
	$purchase_id_arr = $_POST['purchase_id_arr'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$created_at = date('Y-m-d H:i:s');

	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";

	$financial_year_id = $_SESSION['financial_year_id'];

	$bank_balance_status = bank_cash_balance_check($payment_mode, $bank_id, $payment_amount);
  	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($payment_mode, $bank_id); exit; }  


	begin_t();

	for($i=0;$i<sizeof($purchase_type_arr);$i++){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from vendor_payment_master"));
		$payment_id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into vendor_payment_master (payment_id, financial_year_id, branch_admin_id, emp_id, vendor_type, vendor_type_id,estimate_type,estimate_type_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, remark, bank_id, payment_evidence_url, clearance_status, created_at) values ('$payment_id', '$financial_year_id', '$branch_admin_id', '$emp_id', '$vendor_type', '$vendor_type_id', '$purchase_type_arr[$i]', '$purchase_id_arr[$i]', '$payment_date', '$payment_amount_arr[$i]', '$payment_mode', '$bank_name', '$transaction_id', '', '$bank_id', '$payment_evidence_url', '$clearance_status', '$created_at') ");
		
		//Bank and Cash Book Save
		$this->bank_cash_book_save($payment_id,$purchase_type_arr[$i],$payment_amount_arr[$i],get_vendor_payment_id($purchase_id_arr[$i]),$purchase_id_arr[$i],$branch_admin_id);
	}
	
	//Update supplier debit note balance
	$payment_amount1 = $payment_amount;
	$sq_debit_note = mysql_query("select * from debit_note_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'");	
	while($row_debit = mysql_fetch_assoc($sq_debit_note)) 
	{	
		if($row_debit['payment_amount'] <= $payment_amount1 && $payment_amount1 != '0'){		
			$payment_amount1 = $payment_amount1 - $row_debit['payment_amount'];
			$temp_amount = 0;
		}
		else{
			$temp_amount = $row_debit['payment_amount'] - $payment_amount1;
			$payment_amount1 = 0;
		}
		$sq_debit = mysql_query("update debit_note_master set payment_amount ='$temp_amount' where id='$row_debit[id]'");
	}

	if(!$sq_payment){
		rollback_t();
		echo "error--Sorry, Payment not saved!";
		exit;
	}
	else{

		//Finance Save
		$this->finance_save($payment_id,$row_spec,$branch_admin_id);


		if($GLOBALS['flag']){
			commit_t();
	    	echo "Payment has been successfully saved.";
			exit;	
		}
		
	}
}

public function finance_save($payment_id,$row_spec,$branch_admin_id)
{
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$advance_nullify = $_POST['advance_nullify'];
	$total_payment_amount = $_POST['total_payment_amount'];
	$total_purchase = $_POST['total_purchase'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$payment_amount_arr = $_POST['payment_amount_arr'];
	$purchase_type_arr = $_POST['purchase_type_arr'];
	$purchase_id_arr = $_POST['purchase_id_arr'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	global $transaction_master;

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH PAYMENT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
     } 

    //Getting supplier Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='105'"));
	$supplier_gl = $sq_cust['ledger_id'];

	//Supplier Advance Ledger
	$sq_supp = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='23'"));
	$supp_adv_gl = $sq_supp['ledger_id'];

	if($total_payment_amount > $total_purchase){
		$balance_amount = $total_payment_amount - $total_purchase;
		////////Supplier Amount//////   
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $total_purchase;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $total_purchase, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supplier_gl;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

		//////Advance Nullify Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $advance_nullify;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $advance_nullify, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supp_adv_gl;
	    $payment_side = "Credit";
	    $clearance_status = ''; 
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $advance_nullify, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //////Advance Nullify Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $balance_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $balance_amount, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supp_adv_gl;
	    $payment_side = "Debit";
	    $clearance_status = ''; 
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    if($supp_adv_gl == ''){
	    	$module_name = $vendor_type;
		    $module_entry_id = $payment_id;
		    $transaction_id = $transaction_id1;
		    $payment_amount = $balance_amount;
		    $payment_date = $payment_date;
		    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $balance_amount, $vendor_type, $vendor_type_id,$payment_mode);
				$ledger_particular = get_ledger_particular('By','Cash/Bank');
		    $gl_id = $supplier_gl;
		    $payment_side = "Debit";
		    $clearance_status = ''; 
		    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	    }
	}
	else if($total_payment_amount < $total_purchase){
		////////Supplier Amount//////   
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $total_payment_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $total_payment_amount, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supplier_gl;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

		//////Advance Nullify Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $advance_nullify;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $advance_nullify, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supp_adv_gl;
	    $payment_side = "Credit";
	    $clearance_status = ''; 
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_amount1, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);	
		
	}
	else
	{
		////////Supplier Amount//////   
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $total_payment_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $total_payment_amount, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supplier_gl;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

		//////Advance Nullify Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $advance_nullify;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $advance_nullify, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $supp_adv_gl;
	    $payment_side = "Credit";
	    $clearance_status = ''; 
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_amount1, $vendor_type, $vendor_type_id,$payment_mode);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);		
	}

}


public function bank_cash_book_save($payment_id,$purchase_type,$pay_amount,$purchase_id,$suppl_type_id,$branch_admin_id)
{
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	//$remark = $_POST['remark'];	
	$bank_id = $_POST['bank_id'];
	$payment_evidence_url = $_POST['payment_evidence_url'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	global $bank_cash_book_master;
	
	$module_name = $vendor_type;
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $pay_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $pay_amount, $vendor_type, $vendor_type_id,$payment_mode);
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type,$branch_admin_id);
	
}

public function vendor_payment_update()
{
	$payment_id = $_POST['payment_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$estimate_type = $_POST['estimate_type'];
	$estimate_type_id = $_POST['estimate_type_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$payment_evidence_url = $_POST['payment_evidence_url'];
	$payment_old_value = $_POST['payment_old_value'];
	$payment_old_mode =  $_POST['payment_old_mode'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$financial_year_id = $_SESSION['financial_year_id'];

	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from vendor_payment_master where payment_id='$payment_id'"));

	$bank_balance_status = bank_cash_balance_check($payment_mode, $bank_id, $payment_amount, $sq_payment_info['payment_amount']);
  	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($payment_mode, $bank_id); exit; }  

	$clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];
	if($payment_mode=="Cash"){ $clearance_status = ""; }

	begin_t();

	$sq_payment = mysql_query("update vendor_payment_master set financial_year_id='$financial_year_id', vendor_type='$vendor_type', vendor_type_id='$vendor_type_id', estimate_type='$estimate_type', estimate_type_id='$estimate_type_id', payment_date='$payment_date', payment_amount='$payment_amount', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', payment_evidence_url='$payment_evidence_url', clearance_status='$clearance_status' where payment_id='$payment_id' ");
	if(!$sq_payment){
		rollback_t();
		echo "error--Sorry, Payment not updated!";
		exit;
	}
	else{

		//Finance update
		$this->finance_update($sq_payment_info, $clearance_status);

		//Bank and Cash Book update
		$this->bank_cash_book_update($clearance_status);

		if($GLOBALS['flag']){
			commit_t();
	    	echo "Payment has been successfully updated.";
			exit;	
		}
		
	}
}

public function finance_update($sq_payment_info, $clearance_status1)
{
	$row_spec = 'purchase';
	$payment_id = $_POST['payment_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$payment_old_value = $_POST['payment_old_value'];
	$payment_old_mode =  $_POST['payment_old_mode'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	global $transaction_master;

    //Getting New cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl_new = 20; $type='CASH PAYMENT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl_new = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
     } 

    //Getting old cash/Bank Ledger
    if($payment_old_mode == 'Cash') {  $pay_gl_old = 20; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl_old = $sq_bank['ledger_id'];
     }
      
    //Getting supplier Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='105'"));
	$supplier_gl = $sq_cust['ledger_id'];

	if($payment_amount1 < $payment_old_value)
	{
		$supp_amount= $payment_old_value - $payment_amount1;
		$pay_gl = ($payment_mode != $payment_old_mode) ? $pay_gl_new : $pay_gl_old; 
		////////Supplier Amount//////   
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $supp_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $supp_amount, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $supplier_gl;
	    $payment_side = "Credit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_old_value;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_old_value, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_amount1, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);
	}
	else if($payment_amount1 > $payment_old_value)
	{
		$supp_amount = $payment_amount1 - $payment_old_value;
		$pay_gl = ($payment_mode != $payment_old_mode) ? $pay_gl_new : $pay_gl_old; 
		////////Supplier Amount//////   
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $supp_amount;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $supp_amount, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $supplier_gl;
	    $payment_side = "Debit";
	    $clearance_status = "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_old_value;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_old_value, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $pay_gl;
	    $payment_side = "Debit";
	    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);

	    //////Payment Amount///////
	    $module_name = $vendor_type;
	    $module_entry_id = $payment_id;
	    $transaction_id = $transaction_id1;
	    $payment_amount = $payment_amount1;
	    $payment_date = $payment_date;
	    $payment_particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_amount1, $vendor_type, $vendor_type_id,$payment_mode);
	    $gl_id = $pay_gl;
	    $payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,'',$type);
	}
	else{
		//Do Nothing
	}

}

public function bank_cash_book_update($clearance_status)
{
	$payment_id = $_POST['payment_id'];
	$vendor_type = $_POST['vendor_type'];
	$vendor_type_id = $_POST['vendor_type_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	//$remark = $_POST['remark'];	
	$bank_id = $_POST['bank_id'];
	$payment_evidence_url = $_POST['payment_evidence_url'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	global $bank_cash_book_master;
	
	$module_name = $vendor_type;
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_purchase_paid_partucular(get_vendor_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $vendor_type, $vendor_type_id,$payment_mode);
	$clearance_status = $clearance_status;
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type,$branch_admin_id);
}

}
?>