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
	$branch_admin_id = $_POST['branch_admin_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	
	if($payment_mode=="Cheque"||$payment_mode=="Credit Card"){ 
		$clearance_status = "Pending"; } 
	else {  $clearance_status = ""; }	

	$financial_year_id = $_SESSION['financial_year_id'];	

	//**Starting trasnaction
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from bus_booking_payment_master"));
	$payment_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into bus_booking_payment_master (payment_id, booking_id, branch_admin_id, financial_year_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$booking_id', '$branch_admin_id','$financial_year_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");
	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Payment not saved!";
	}

	//Finance save
	$this->finance_save($payment_id, $branch_admin_id);

	//Bank and Cash Book Save
	if($payment_mode != 'Credit Note'){
		$this->bank_cash_book_save($payment_id, $branch_admin_id);
	}
	if($GLOBALS['flag']){
		commit_t();

      //Payment email notification
        $this->payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date);

        //Payment sms notification
        $this->payment_sms_notification_send($booking_id, $payment_amount, $payment_mode);

    	echo "Bus Ticket Payment has been successfully saved.";
		exit;	
	}
	else{
		rollback_t();
		exit;
	}
		
}

public function finance_save($payment_id, $branch_admin_id)
{
	$row_spec = 'sales';
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];
	$bank_id1 = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$payment_amount1 = $payment_amount1 + $credit_charges;
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 = $year1[0];

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from bus_booking_master where booking_id='$booking_id'"));
	$customer_id = $sq_booking_info['customer_id'];  
	global $transaction_master;

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
    }

    //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

    $sq_Bus_total = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'")); 
    $sq_Bus = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from bus_booking_payment_master where booking_id='$booking_id'"));

	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 224;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Get Credit card company Ledger///////
			$credit_card_details = explode('-',$credit_card_details);
			$entry_id = $credit_card_details[0];
			$sq_cust1 = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$entry_id' and user_type='credit company'"));
			$company_gl = $sq_cust1['ledger_id'];
			//////Get Credit card company Charges///////
			$sq_credit_charges = mysql_fetch_assoc(mysql_query("select * from credit_card_company where entry_id='$entry_id'"));
			//////company's credit card charges
			$company_card_charges = ($sq_credit_charges['charges_in'] =='Flat') ? $sq_credit_charges['credit_card_charges'] : ($payment_amount1 * ($sq_credit_charges['credit_card_charges']/100));
			//////company's tax on credit card charges
			$tax_charges = ($sq_credit_charges['tax_charges_in'] =='Flat') ? $sq_credit_charges['tax_on_credit_card_charges'] : ($company_card_charges * ($sq_credit_charges['tax_on_credit_card_charges']/100));
			$finance_charges = $company_card_charges + $tax_charges;
$finance_charges = number_format($finance_charges,2);
			$credit_company_amount = $payment_amount1 - $finance_charges;

			//////Finance charges ledger///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $finance_charges, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $payment_amount1;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $pay_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}

		//////Customer Payment Amount///////
		$module_name = "Bus Booking";
		$module_entry_id = $booking_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date;
		$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
}

public function bank_cash_book_save($payment_id, $branch_admin_id)
{
	global $bank_cash_book_master;	

	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 = $year1[0];

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id,created_at from bus_booking_master where booking_id='$booking_id'"));
	$created_at = date('Y-m-d', strtotime($sq_booking_info['created_at']));
	$year2 = explode("-", $created_at);
	$yr2 = $year2[0];

	$module_name = "Bus Booking";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_bus_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_bus_booking_id($booking_id,$yr2),$bank_id,$transaction_id);
	$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);
}


public function payment_update()
{
	$row_spec = 'sales';
	$payment_id = $_POST['payment_id'];
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
	$credit_charges_old = $_POST['credit_charges_old'];

	$payment_date = date('Y-m-d', strtotime($payment_date));

	$financial_year_id = $_SESSION['financial_year_id'];

	$sq_payment_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_payment_master where payment_id='$payment_id'"));

	$clearance_status = ($sq_payment_info['payment_mode']=='Cheque' || $payment_mode ="Credit Card") ? "Pending" : $sq_payment_info['clearance_status'];
	if($payment_mode=="Cash"){ $clearance_status = ""; }

	//**Starting transaction
	begin_t();

	$sq_payment = mysql_query("update bus_booking_payment_master set booking_id='$booking_id', financial_year_id='$financial_year_id', payment_date='$payment_date', payment_amount='$payment_amount', payment_mode='$payment_mode', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status',credit_charges='$credit_charges' where payment_id='$payment_id' ");
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

      //Payment email notification
      $this->payment_update_email_notification_send($payment_id);
      
		echo "Bus Payment has been successfully updated.";
		exit;			
	}
	else{
		rollback_t();
		exit;
	}

	
}

public function finance_update($sq_payment_info, $clearance_status1)
{
	$row_spec = 'sales';
	$payment_id = $_POST['payment_id'];
	$booking_id = $_POST['booking_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$payment_old_value = $_POST['payment_old_value'];
	$bank_id = $_POST['bank_id'];	
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
	$credit_charges_old = $_POST['credit_charges_old'];

	$payment_amount1 = $payment_amount1 + $credit_charges;
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
	$customer_id = $sq_booking_info['customer_id'];  
	global $transaction_master;

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
		$sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
		$pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
    } 

     //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

    $sq_bus_total = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'")); 
    $sq_Bus = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from bus_booking_payment_master where booking_id='$booking_id'"));	

	//////////Payment Amount///////////
	if($payment_amount1 != $payment_old_value){
		
		if($payment_mode == 'Credit Card'){
			$payment_old_value = $payment_old_value + $credit_charges_old;

			//////Customer Credit charges///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges_old;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $credit_charges_old, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges_old;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $credit_charges_old, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 224;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Get Credit card company Ledger///////
			$credit_card_details = explode('-',$credit_card_details);
			$entry_id = $credit_card_details[0];
			$sq_cust1 = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$entry_id' and user_type='credit company'"));
			$company_gl = $sq_cust1['ledger_id'];
			//////Get Credit card company Charges///////
			$sq_credit_charges = mysql_fetch_assoc(mysql_query("select * from credit_card_company where entry_id='$entry_id'"));
			//////company's credit card charges
			$company_card_charges = ($sq_credit_charges['charges_in'] =='Flat') ? $sq_credit_charges['credit_card_charges'] : ($payment_old_value * ($sq_credit_charges['credit_card_charges']/100));
			//////company's tax on credit card charges
			$tax_charges = ($sq_credit_charges['tax_charges_in'] =='Flat') ? $sq_credit_charges['tax_on_credit_card_charges'] : ($company_card_charges * ($sq_credit_charges['tax_on_credit_card_charges']/100));
			$finance_charges = $company_card_charges + $tax_charges;
$finance_charges = number_format($finance_charges,2);
			$credit_company_amount = $payment_old_value - $finance_charges;

			//////Finance charges ledger///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $finance_charges, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $payment_old_value;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $payment_old_value, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $pay_gl;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}

		//////Customer Payment Amount///////
		$module_name = "Bus Booking";
		$module_entry_id = $booking_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_old_value;
		$payment_date = $payment_date;
		$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Debit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
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
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
	$credit_charges_old = $_POST['credit_charges_old'];

	
	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 = $year1[0];

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id,created_at from bus_booking_master where booking_id='$booking_id'"));
	$created_at = date('Y-m-d', strtotime($sq_booking_info['created_at']));
	$year2 = explode("-", $created_at);
	$yr2 = $year2[0];

	$module_name = "Bus Booking";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_bus_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_bus_booking_id($booking_id,$yr2),$bank_id,$transaction_id);
	$clearance_status = $clearance_status;
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}


//////////////////////////////////**Payment email notification send start**/////////////////////////////////////
public function payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date)
{
	global $encrypt_decrypt,$secret_key;
   $sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
   $total_amount = $sq_hotel_info['net_total'];

   $date = $sq_hotel_info['created_at'];
   $yr = explode("-", $date);
   $year =$yr[0];

   $sq_customer_info = mysql_fetch_assoc(mysql_query("select email_id,first_name from customer_master where customer_id='$sq_hotel_info[customer_id]'"));
   $email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);
   $due_date = '';
   $sq_total_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$booking_id' and clearance_status!='Cancelled'"));
   $paid_amount = $sq_total_amount['sum'];

   $payment_id = get_bus_booking_payment_id($payment_id,$year);
   $subject = 'Payment Acknowledgement (Booking ID : '.get_bus_booking_id($booking_id,$year).' )';
   global $model;
   $model->generic_payment_mail('51',$payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $due_date,$email_id, $subject, $sq_customer_info['first_name']);
}
//////////////////////////**Payment email notification send end/////////


//////////////////////////////////**Payment update email notification send start**/////////////////////////////////////
public function payment_update_email_notification_send($payment_id)
{
	global $encrypt_decrypt,$secret_key;
  $sq_payment_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_payment_master where payment_id='$payment_id' and clearance_status!='Cancelled'"));
  $booking_id = $sq_payment_info['booking_id'];
  $payment_amount = $sq_payment_info['payment_amount'];
    $payment_mode = $sq_payment_info['payment_mode'];
    $payment_date = $sq_payment_info['payment_date'];
  $update_payment = true;

  $sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
  $total_amount = $sq_hotel_info['net_total'];
  $date = $sq_hotel_info['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $sq_total_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$booking_id' and clearance_status!='Cancelled'"));
  $paid_amount = $sq_total_amount['sum'];
  $due_date = '';
  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_hotel_info[customer_id]'"));
  $email_id = $encrypt_decrypt->fnDecrypt($sq_customer_info['email_id'], $secret_key);

  $payment_id = get_bus_booking_payment_id($payment_id,$year);
  $subject = 'Bus Booking Payment Correction (Booking ID : '.get_bus_booking_id($booking_id,$year).' )';
  global $model;
  $model->generic_payment_mail('61',$payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $due_date,$email_id, $subject, $sq_customer_info['first_name']);
}
//////////////////////////////////**Payment update email notification send end**/////////////////////////////////////

//////////////////////////////////**Payment sms notification send start**/////////////////////////////////////
public function payment_sms_notification_send($booking_id, $payment_amount, $payment_mode)
{
  global $encrypt_decrypt,$secret_key,$currency;
  $sq_hotel_info = mysql_fetch_assoc(mysql_query("select customer_id from bus_booking_master where booking_id='$booking_id'"));
  $customer_id = $sq_hotel_info['customer_id'];

  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);

  $sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$currency'"));
  $currency_code = $sq_currency['currency_code'];

  $message = " Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", Acknowledge your payment of ".$payment_amount." ".$currency_code." ,  which we received for Bus booking installment.";
  global $model;
  $model->send_message($mobile_no, $message);
}
//////////////////////////////////**Payment sms notification send end**/////////////////////////////////////

public function whatsapp_send(){
	global $app_contact_no,$session_emp_id,$currency_logo,$encrypt_decrypt,$secret_key;

   $booking_id = $_POST['booking_id'];
   $payment_amount = $_POST['payment_amount'];
   $sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id=".$_POST['booking_id']));

   $total_amount = $sq_bus_info['net_total'];
   $sq_pay = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where clearance_status!='Cancelled' and booking_id=".$_POST['booking_id']));
   $total_pay_amt = $sq_pay['sum'];
   $outstanding =  $total_amount - ($total_pay_amt+$payment_amount);

$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id= '$session_emp_id"));
if($session_emp_id == 0){
   $contact = $app_contact_no;
}
else{
   $contact = $sq_emp_info['mobile_no'];
}

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id=".$sq_bus_info['customer_id']));
$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);

$whatsapp_msg = rawurlencode('Hello Dear '.$sq_customer[first_name].',
Hope you are doing great. This is to inform you that we have received your payment. We look forward to provide you a great experience.
*Total Amount* : '.$currency_logo.' '.$total_amount.'
*Paid Amount* : '.$currency_logo.' '. $payment_amount.'
*Balance Amount* : '.$currency_logo.' '.$outstanding.'
  
Please do not hesitate to call us on '.$contact.' if you have any concern. 
Thank you. ');
   $link = 'https://web.whatsapp.com/send?phone='.$contact_no.'&text='.$whatsapp_msg;
   echo $link;
  }
}
?>