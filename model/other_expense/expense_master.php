<?php 

$flag = true;

class expense_master{
public function expense_save()
{
	$row_spec = 'other expense';
	$expense_type = $_POST['expense_type'];
	$supplier_type = $_POST['supplier_type'];
	$sub_total = $_POST['sub_total'];
 	$ledger_ids = $_POST['ledger_ids'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$net_total = $_POST['net_total'];
	$due_date = $_POST['due_date'];
	$booking_date = $_POST['booking_date'];
	$invoice_no = $_POST['invoice_no'];
	$id_upload_url =$_POST['id_upload_url'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$payment_amount = $_POST['payment_amount'];
	$bank_name =$_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$emp_id = $_POST['emp_id']; 
	$payment_evidence_url = $_POST['payment_evidence_url'];

	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$financial_year_id = $_SESSION['financial_year_id'];

	$created_at = date('Y-m-d H:i:s');
	$due_date = date('Y-m-d',strtotime($due_date));
	$booking_date = date('Y-m-d',strtotime($booking_date));
	$payment_date = date('Y-m-d', strtotime($payment_date));

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(expense_id) as max from other_expense_master"));
	$expense_id = $sq_max['max'] + 1;
	$sq_expense = mysql_query("insert into other_expense_master (expense_id, expense_type_id, supplier_id, financial_year_id, branch_admin_id, amount,ledgers, service_tax_subtotal, tds, total_fee, due_date,invoice_no,expense_date,invoice_url,created_at) values ('$expense_id', '$expense_type', '$supplier_type', '$financial_year_id', '$branch_admin_id', '$sub_total','$ledger_ids','$service_tax_subtotal', '$tds','$net_total','$due_date','$invoice_no','$booking_date','$id_upload_url','$created_at' ) ");

	$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from other_expense_payment_master"));
	$payment_id = $sq_max['max']+1;
	$sq_payment = mysql_query("insert into other_expense_payment_master(payment_id,expense_id, expense_type_id,supplier_id, financial_year_id, branch_admin_id, payment_amount, payment_mode, payment_date, bank_name, transaction_id, bank_id, clearance_status,evidance_url, created_at, emp_id) values ('$payment_id','$expense_id', '$expense_type', '$supplier_type', '$financial_year_id', '$branch_admin_id', '$payment_amount', '$payment_mode', '$payment_date', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$payment_evidence_url', '$created_at', '$emp_id')");
    if(!$sq_payment){
  	  $GLOBALS['flag'] = false;
	    echo "error--Sorry, Payment not done!";
	    exit;
    }
	if($sq_expense){
		//Finance save
    	$this->finance_save($expense_id, $payment_id, $row_spec, $branch_admin_id);

    	//Cash/bank book
    	$this->bank_cash_book_save($expense_id, $payment_id, $branch_admin_id);

	    if($GLOBALS['flag']){
	      commit_t();
	      echo "Expense has been successfully saved";
	      exit;
	    }
	    else{
	      rollback_t();
	      exit;
	    }
	}
	else{
		rollback_t();
		echo "error--Expense Booking Not Done!";
		exit;
	}
}


public function finance_save($expense_id, $payment_id, $row_spec, $branch_admin_id){
	
	global $transaction_master;
	$expense_type = $_POST['expense_type'];
	$supplier_type = $_POST['supplier_type'];
	$sub_total = $_POST['sub_total'];
	$ledger_ids = $_POST['ledger_ids'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$net_total = $_POST['net_total'];
	$due_date = $_POST['due_date'];
	$booking_date = $_POST['booking_date'];
	$invoice_no = $_POST['invoice_no'];
	$id_upload_url =$_POST['id_upload_url'];
	$payment_date = $_POST['payment_date'];
	$payment_mode = $_POST['payment_mode'];
	$payment_amount1 = $_POST['payment_amount'];
	$bank_name =$_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
    $branch_admin_id = $_POST['branch_admin_id'];

	$booking_date = get_date_db($_POST['booking_date']);
	$payment_date1 = get_date_db($payment_date);

	$str="select * from ledger_master where customer_id='$supplier_type' and user_type='Other Vendor'";
	//exit();
	//Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query($str));
	
	$cust_gl = $sq_cust['ledger_id'];

	//Getting cash/Bank Ledger
	if($payment_mode == 'Cash') {  $pay_gl = 20;$type='CASH PAYMENT';  }
	else{ 
		$sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
		$pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
	}

	$service_tax_subtotal1 = $service_tax_subtotal / 2;
    ////////////Total Expense Amount/////////////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $sub_total;
    $payment_date = $booking_date;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $sub_total, $payment_mode);    
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $expense_type;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');

	//Tax Amount
	$ledger_ids_arr = explode(',',$ledger_ids);
	if(sizeof($ledger_ids_arr) == 1){
		// Debit
		$module_name = "Other Expense Booking";
		$module_entry_id = $expense_id;
		$transaction_id = "";
		$payment_amount = $service_tax_subtotal;
		$payment_date = $booking_date;
		$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $service_tax_subtotal, $payment_mode);    
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $ledger_ids_arr[0];
		$payment_side = "Debit";
		$clearance_status = "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');
	}
	else{
		for($i=0;$i<sizeof($ledger_ids_arr);$i++){
			//Debit 
			$module_name = "Other Expense Booking";
			$module_entry_id = $expense_id;
			$transaction_id = "";
			$payment_amount = $service_tax_subtotal1;
			$payment_date = $booking_date;
			$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $service_tax_subtotal1, $payment_mode);    
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $ledger_ids_arr[$i];
			$payment_side = "Debit";
			$clearance_status = "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');
		}
	}
    /////////TDS Debit////////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $booking_date;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $tds, $payment_mode);
    $ledger_particular = get_ledger_particular('To','Expense');
    $gl_id = 126;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');

    ////////////Basic Amount/////////////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $net_total;
    $payment_date = $booking_date;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $net_total, $payment_mode);    
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');
	
    //////Payment Amount///////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $payment_amount1;
    $payment_date = $payment_date1;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $payment_date1, $payment_amount1, $payment_mode);
    $ledger_particular = get_ledger_particular('To','Expense');
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER');

    ////////Supplier Payment Amount//////
	$module_name = "Other Expense Booking";
	$module_entry_id = $expense_id;
	$transaction_id = "";
	$payment_amount = $payment_amount1;
	$payment_date = $payment_date1;
	$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $payment_date1, $payment_amount1, $payment_mode);
	$ledger_particular = get_ledger_particular('To','Expense');
	$gl_id = $cust_gl;
	$payment_side = "Debit";
	$clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'VOUCHER'); 
}

public function bank_cash_book_save($expense_id, $payment_id, $branch_admin_id)
{
  global $bank_cash_book_master;

  $supplier_type = $_POST['supplier_type'];
  $expense_type = $_POST['expense_type'];
  $payment_date = $_POST['payment_date'];
  $payment_amount = $_POST['payment_amount'];
  $payment_mode = $_POST['payment_mode'];
  $bank_name =$_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $bank_id = $_POST['bank_id'];

  $module_name = "Other Expense Booking";
  $module_entry_id = $payment_id;
  $payment_date = $payment_date;
  $payment_amount = $payment_amount;
  $payment_mode = $payment_mode;
  $bank_name = $bank_name;
  $transaction_id = $transaction_id;
  $bank_id = $bank_id; 
  $particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $payment_date, $payment_amount, $payment_mode);
  $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
  $payment_side = "Credit";
  $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

  $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);
  
}
public function expense_update(){
	$row_spec = 'other expense';
	$expense_id = $_POST['expense_id'];
	$expense_type = $_POST['expense_type'];
	$supplier_type = $_POST['supplier_type'];
	$sub_total = $_POST['sub_total'];
	$ledger_ids = $_POST['ledger_ids'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$net_total = $_POST['net_total'];
	$due_date = $_POST['due_date'];
	$booking_date = $_POST['booking_date'];
	$invoice_no = $_POST['invoice_no'];
	$id_upload_url =$_POST['id_upload_url'];

	$due_date = get_date_db($due_date);
    $booking_date = get_date_db($booking_date);

	begin_t();
	$sq_expense_u = mysql_query("update other_expense_master set expense_type_id='$expense_type',supplier_id='$supplier_type',amount='$sub_total',ledgers='$ledger_ids', service_tax_subtotal='$service_tax_subtotal', tds='$tds', total_fee='$net_total', due_date='$due_date',invoice_no='$invoice_no',expense_date='$booking_date',invoice_url='$id_upload_url' where expense_id='$expense_id'");

	if($sq_expense_u){
		//Finance save
		$this->finance_update($expense_id, $row_spec);

		if($GLOBALS['flag']){
			commit_t();
			echo "Expense has been successfully updated.";
			exit;
		}
		else{
			rollback_t();
			exit;
		}
	}
	else{
		rollback_t();
		echo "error--Expense not updated!";
		exit;
	}
}

public function finance_update($expense_id, $row_spec)
{
	$expense_type = $_POST['expense_type'];
	$supplier_type = $_POST['supplier_type'];
	$sub_total = $_POST['sub_total'];
	$ledger_ids = $_POST['ledger_ids'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$tds = $_POST['tds'];
	$net_total = $_POST['net_total'];
	$due_date = $_POST['due_date'];
	$booking_date = $_POST['booking_date'];
	$invoice_no = $_POST['invoice_no'];
	$id_upload_url =$_POST['id_upload_url'];

	$booking_date = get_date_db($_POST['booking_date']);
	$payment_date = get_date_db($payment_date);

    //Getting customer Ledger
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$supplier_type' and user_type='Other Vendor'"));
    $cust_gl = $sq_cust['ledger_id'];

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; }
    else{ 
        $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
        $pay_gl = $sq_bank['ledger_id'];
    }

    global $transaction_master;
    $sq_exp = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from other_expense_payment_master where supplier_id='$supplier_type' and expense_type_id='$expense_type' and clearance_status!='Cancelled'"));
	$balance_amount = $net_total - $sq_exp['payment_amount'];

    ////////////Basic Expense Amount/////////////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $sub_total;
    $payment_date = $booking_date;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $sub_total, $payment_mode);    
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id = $gl_id = $expense_type;
    $payment_side = "Debit";
    $clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'VOUCHER');

	//Tax Amount
	$ledger_ids_arr = explode(',',$ledger_ids);
	if(sizeof($ledger_ids_arr) == 1){

		// Debit
		$module_name = "Other Expense Booking";
		$module_entry_id = $expense_id;
		$transaction_id = "";
		$payment_amount = $service_tax_subtotal;
		$payment_date = $booking_date;
		$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $service_tax_subtotal, $payment_mode);
		$ledger_particular = get_ledger_particular('To','Expense');
		$old_gl_id = $gl_id = $ledger_ids_arr[0];
		$payment_side = "Debit";
		$clearance_status = "";
		$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'VOUCHER');
	}
	else{
		$service_tax_subtotal = $service_tax_subtotal / 2;
		for($i=0;$i<sizeof($ledger_ids_arr);$i++){

			//Debit
			$module_name = "Other Expense Booking";
			$module_entry_id = $expense_id;
			$transaction_id = "";
			$payment_amount = $service_tax_subtotal;
			$payment_date = $booking_date;
			$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $service_tax_subtotal, $payment_mode);
			$ledger_particular = get_ledger_particular('To','Expense');
			$old_gl_id = $gl_id = $ledger_ids_arr[$i];
			$payment_side = "Debit";
			$clearance_status = "";
			$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'VOUCHER');
		}
	}
	
    /////////TDS Debit////////
    $module_name = "Other Expense Booking";
    $module_entry_id = $expense_id;
    $transaction_id = "";
    $payment_amount = $tds;
    $payment_date = $booking_date;
    $payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $tds, $payment_mode);
    $ledger_particular = get_ledger_particular('To','Expense');
    $old_gl_id = $gl_id = 126;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'VOUCHER');

    ////////Net total Amount//////
	$module_name = "Other Expense Booking";
	$module_entry_id = $expense_id;
	$transaction_id = "";
	$payment_amount = $net_total;
	$payment_date = $booking_date;
	$payment_particular = get_expense_paid_particular(get_other_expense_booking_id($expense_id), $expense_type, $booking_date, $net_total, $payment_mode);
	$ledger_particular = get_ledger_particular('To','Expense');
	$old_gl_id = $gl_id = $cust_gl;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'VOUCHER'); 
	
}

}
?>