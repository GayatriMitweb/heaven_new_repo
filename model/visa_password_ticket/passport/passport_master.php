<?php
$flag = true;
class passport_master{
public function passport_master_save(){

	$row_spec = "sales";
	$customer_id = $_POST['customer_id'];
	$emp_id = $_POST['emp_id'];
	$passport_issue_amount = $_POST['passport_issue_amount'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$passport_total_cost = $_POST['passport_total_cost'];
	$due_date1 = $_POST['due_date'];
	$balance_date = $_POST['balance_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$honorific_arr = $_POST['honorific_arr'];

	$first_name_arr = $_POST['first_name_arr'];

	$middle_name_arr = $_POST['middle_name_arr'];

	$last_name_arr = $_POST['last_name_arr'];

	$birth_date_arr = $_POST['birth_date_arr'];

	$adolescence_arr = $_POST['adolescence_arr'];
	$received_documents_arr = $_POST['received_documents_arr'];
	$appointment_date_arr = $_POST['appointment_date_arr'];
	$reflections = json_encode($_POST['reflections']);
	$roundoff = $_POST['roundoff'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
  	foreach($bsmValues[0] as $key => $value){
      switch($key){
		case 'basic' : $passport_issue_amount = ($value != "") ? $value : $passport_issue_amount;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      }
    }

	$birth_date = date('Y-m-d', strtotime($birth_date));
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$balance_date = date("Y-m-d",strtotime($balance_date));
	$due_date = date("Y-m-d",strtotime($due_date1));

	if($payment_mode == 'Cheque' || $payment_mode == 'Credit Card'){ 
		$clearance_status = "Pending"; } 
	else {  $clearance_status = ""; }

	$financial_year_id = $_SESSION['financial_year_id'];
	begin_t();

    //Get Customer id
    if($customer_id == '0'){
    	$sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
	    $customer_id = $sq_max['max'];
    }
    
	//passport save
	$sq_max = mysql_fetch_assoc(mysql_query("select max(passport_id) as max from passport_master"));
	$passport_id = $sq_max['max'] + 1;

	$bsmValues = json_encode($bsmValues);
	$sq_passport = mysql_query("INSERT INTO passport_master (passport_id, customer_id, branch_admin_id,financial_year_id, passport_issue_amount, service_charge, service_tax_subtotal, passport_total_cost, created_at, due_date,emp_id,reflections,roundoff,bsm_values) VALUES ('$passport_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$passport_issue_amount', '$service_charge', '$service_tax_subtotal', '$passport_total_cost', '$balance_date', '$due_date','$emp_id','$reflections','$roundoff','$bsmValues')");
	if(!$sq_passport){

		rollback_t();
		echo "error--Sorry, Passport saved!";
		exit;
	}
	else{

		for($i=0; $i<sizeof($first_name_arr); $i++){

			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from passport_master_entries"));
			$entry_id = $sq_max['max'] + 1;

			$birth_date_arr[$i] = date('Y-m-d', strtotime($birth_date_arr[$i]));
			$appointment_date_arr[$i] = date('Y-m-d', strtotime($appointment_date_arr[$i]));

			$sq_entry = mysql_query("insert into passport_master_entries(entry_id, passport_id, honorific, first_name, middle_name, last_name, birth_date, adolescence, received_documents,appointment_date) values('$entry_id', '$passport_id', '$honorific_arr[$i]', '$first_name_arr[$i]', '$middle_name_arr[$i]', '$last_name_arr[$i]', '$birth_date_arr[$i]', '$adolescence_arr[$i]', '$received_documents_arr[$i]','$appointment_date_arr[$i]')");

			if(!$sq_entry){
				$GLOBALS['flag'] = false;
				echo "error--Some passport entries are not saved!";
				//exit;
			}
		}

		$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from passport_payment_master"));
		$payment_id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into passport_payment_master (payment_id, passport_id, financial_year_id, branch_admin_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$passport_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details')");
		if(!$sq_payment){
			$GLOBALS['flag'] = false;
			echo "error--Sorry, Payment not saved!";
		}

		//Update customer credit note balance
		$payment_amount1 = $payment_amount;
		$sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
		$i=0;
		while($row_credit = mysql_fetch_assoc($sq_credit_note)){	

			if($row_credit['payment_amount'] <= $payment_amount1 && $payment_amount1 != '0'){		
				$payment_amount1 = $payment_amount1 - $row_credit['payment_amount'];
				$temp_amount = 0;
			}
			else{
				$temp_amount = $row_credit['payment_amount'] - $payment_amount1;
				$payment_amount1 = 0;
			}
			$sq_credit = mysql_query("update credit_note_master set payment_amount ='$temp_amount' where id='$row_credit[id]'");
		}

		//Get Particular
		$particular = $this->get_particular($customer_id);

		//Finance Save
		$this->finance_save($passport_id, $payment_id, $row_spec, $branch_admin_id,$particular);

		//Bank and Cash Book Save
		if($payment_mode != 'Credit Note'){
    		$this->bank_cash_book_save($passport_id, $payment_id, $branch_admin_id,$particular);
		}
		
		if($GLOBALS['flag']){

			commit_t();

			//Passport Booking email send
			$this->passport_booking_email_send($passport_id);
			$this->booking_sms($passport_id, $customer_id, $balance_date);

			//Passport payment email send
			$passport_payment_master  = new passport_payment_master;
			$passport_payment_master->payment_email_notification_send($passport_id, $payment_amount, $payment_mode, $payment_date);

			//Passport payment sms send
			if($payment_amount != 0){
				$passport_payment_master->payment_sms_notification_send($passport_id, $payment_amount, $payment_mode);
			}
			echo "Passport Booking has been successfully saved.";
			exit;
		}

		else{

			rollback_t();
			exit;
		}
	}
}


function get_particular($customer_id){

	$sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];

	return 'Passport renewal assistance for '.$cust_name;
}
public function booking_sms($booking_id, $customer_id, $created_at){

    global $model, $app_name,$secret_key,$encrypt_decrypt,$app_contact_no;
    $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    
    $mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
	// $email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
    $date = $created_at;
    $yr = explode("-", $date);
	$yr1 =$yr[0];
	
	$message = "Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", your passport consultancy is confirmed. Details will send you shortly. Please contact for more details ".$app_contact_no.".";
    $model->send_message($mobile_no, $message);  
}


public function finance_save($passport_id, $payment_id, $row_spec, $branch_admin_id,$particular){

	$customer_id = $_POST['customer_id'];
	$passport_issue_amount = $_POST['passport_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$passport_total_cost = $_POST['passport_total_cost'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
  	foreach($bsmValues[0] as $key => $value){
      switch($key){
		case 'basic' : $passport_issue_amount = ($value != "") ? $value : $passport_issue_amount;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      }
    }	
	$reflections = json_decode(json_encode($_POST['reflections']));
	$roundoff = $_POST['roundoff'];
	$bank_id = $_POST['bank_id'];
	$booking_date = $_POST['balance_date'];
	$created_at = date("Y-m-d");

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	$booking_date = date('Y-m-d', strtotime($booking_date));
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
	$year2 = explode("-", $payment_date1);
	$yr2 =$year2[0];

	global $transaction_master;

	$passport_sale_amount = $passport_issue_amount;
	$payment_amount1 = $payment_amount1 + $credit_charges;

	//Get Customer id
    if($customer_id == '0'){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
		$customer_id = $sq_max['max'];
    }
    //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT';}
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
    }

	//**Sales**//
    $module_name = "Passport Booking";
    $module_entry_id = $passport_id;
    $transaction_id = "";
    $payment_amount = $passport_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
    $gl_id = 93;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'' ,$payment_side, $clearance_status, $row_spec, $branch_admin_id,$ledger_particular,'INVOICE');
	
	/////////Service Charge////////
    $module_name = "Passport Booking";
    $module_entry_id = $passport_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
	$payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Passport Sales');
    $gl_id = ($reflections[0]->passport_sc != '') ? $reflections[0]->passport_sc : 194;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->passport_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Passport Booking";
	  $module_entry_id = $passport_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Passport Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}
	
	////////Customer Amount//////
	$module_name = "Passport Booking";
    $module_entry_id = $passport_id;
    $transaction_id = "";
    $payment_amount = $passport_total_cost;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Passport Sales');
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	////Roundoff Value
	$module_name = "Passport Booking";
	$module_entry_id = $passport_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
	$gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Passport Booking";
			$module_entry_id = $passport_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Passport Booking";
			$module_entry_id = $passport_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
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
			$module_name = "Passport Booking";
			$module_entry_id = $passport_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Passport Booking";
			$module_entry_id = $passport_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Passport Booking";
			$module_entry_id = $passport_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $payment_amount1;
			$payment_date = $payment_date1;
			$payment_particular = $particular;
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $pay_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}

		//////Customer Payment Amount///////
		$module_name = "Passport Booking";
		$module_entry_id = $passport_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
	
}



public function bank_cash_book_save($passport_id, $payment_id, $branch_admin_id,$particular){

	global $bank_cash_book_master;

	$customer_id = $_POST['customer_id'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$booking_date = $_POST['balance_date'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}

	$year1 = explode("-", $payment_date);
	$yr1 = $year1[0];

	$booking_date = date('Y-m-d', strtotime($booking_date));
	$year2 = explode("-", $booking_date);
	$yr2 = $year2[0];

	//Get Customer id
    if($customer_id == '0'){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
		$customer_id = $sq_max['max'];
    }

	$module_name = "Passport Booking";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_passport_booking_id($passport_id,$yr2), $payment_date1, $payment_amount, $customer_id, $payment_mode, get_passport_booking_id($passport_id,$yr2),$bank_id,$transaction_id);
	$clearance_status = ($payment_mode=="Cheque" || $payment_mode=="Credit Card") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);
}



public function passport_master_update(){

	$row_spec = "sales";

	$passport_id = $_POST['passport_id'];

	$customer_id = $_POST['customer_id'];

	$passport_issue_amount = $_POST['passport_issue_amount'];

	$service_charge = $_POST['service_charge'];

	$reflections = json_encode($_POST['reflections']);
	$roundoff = $_POST['roundoff'];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
  	foreach($bsmValues[0] as $key => $value){
      switch($key){
		case 'basic' : $passport_issue_amount = ($value != "") ? $value : $passport_issue_amount;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      }
    }

	$service_tax_subtotal = $_POST['service_tax_subtotal'];

	$passport_total_cost = $_POST['passport_total_cost'];

	$due_date1 = $_POST['due_date1'];
	$balance_date1 = $_POST['balance_date1'];


	$honorific_arr = $_POST['honorific_arr'];

	$first_name_arr = $_POST['first_name_arr'];

	$middle_name_arr = $_POST['middle_name_arr'];

	$last_name_arr = $_POST['last_name_arr'];

	$birth_date_arr = $_POST['birth_date_arr'];

	$adolescence_arr = $_POST['adolescence_arr'];

	$received_documents_arr = $_POST['received_documents_arr'];

	$entry_id_arr = $_POST['entry_id_arr'];
	$appointment_date_arr = $_POST['appointment_date_arr'];


	$birth_date = date('Y-m-d', strtotime($birth_date));

	$due_date = date('Y-m-d', strtotime($due_date1));
	$balance_date1 = date('Y-m-d', strtotime($balance_date1));


	$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));

	begin_t();

	$bsmValues = json_encode($bsmValues);
	$sq_passport = mysql_query("UPDATE passport_master set customer_id='$customer_id', passport_issue_amount='$passport_issue_amount', service_charge='$service_charge', service_tax_subtotal='$service_tax_subtotal', passport_total_cost='$passport_total_cost', due_date='$due_date',created_at='$balance_date1',reflections='$reflections',roundoff='$roundoff',bsm_values='$bsmValues' where passport_id='$passport_id' ");

	if(!$sq_passport){

		rollback_t();

		echo "error--Sorry, passport information not update successfully!";

		exit;

	}

	else{		



		for($i=0; $i<sizeof($first_name_arr); $i++){


			
			$birth_date_arr[$i] = date('Y-m-d', strtotime($birth_date_arr[$i]));
			$appointment_date_arr[$i] = date('Y-m-d', strtotime($appointment_date_arr[$i]));


			if($entry_id_arr[$i]==""){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from passport_master_entries"));
				$entry_id = $sq_max['max'] + 1;

				$sq_entry = mysql_query("insert into passport_master_entries(entry_id, passport_id, honorific, first_name, middle_name, last_name, birth_date, adolescence, received_documents,appointment_date) values('$entry_id', '$passport_id', '$honorific_arr[$i]', '$first_name_arr[$i]', '$middle_name_arr[$i]', '$last_name_arr[$i]', '$birth_date_arr[$i]', '$adolescence_arr[$i]', '$received_documents_arr[$i]','$appointment_date_arr[$i]')");

				if(!$sq_entry){

					$GLOBALS['flag'] = flag;
					echo "error--Some passport entries are not saved!";
					//exit;
				}	
			}
			else{
				$sq_entry = mysql_query("update passport_master_entries set honorific='$honorific_arr[$i]', first_name='$first_name_arr[$i]', middle_name='$middle_name_arr[$i]', last_name='$last_name_arr[$i]',  birth_date='$birth_date_arr[$i]', adolescence='$adolescence_arr[$i]', received_documents='$received_documents_arr[$i]',appointment_date='$appointment_date_arr[$i]' where entry_id='$entry_id_arr[$i]'");

				if(!$sq_entry){

					$GLOBALS['flag'] = flag;
					echo "error--Some passport entries are not updated!";
					//exit;
				}	
			}
		}

		//Finance Update
		$this->finance_update($sq_passport_info, $row_spec,$particular);

		if($GLOBALS['flag']){

			commit_t();
			echo "Passport Booking has been successfully updated.";
			exit;
		}
		else{
			rollback_t();
			exit;
		}
	}
}

public function finance_update($sq_passport_info, $row_spec,$particular){

	$passport_id = $_POST['passport_id'];
	$customer_id = $_POST['customer_id'];
	$passport_issue_amount = $_POST['passport_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$passport_total_cost = $_POST['passport_total_cost'];
	$roundoff = $_POST['roundoff'];
	$reflections = json_decode(json_encode($_POST['reflections']));
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $passport_issue_amount = ($value != "") ? $value : $passport_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		}
	}

	$created_at = $_POST['balance_date1'];
	$created_at = date('Y-m-d', strtotime($created_at));
	$year2 = explode("-", $created_at);
	$yr2 =$year2[0];

	$passport_sale_amount = $passport_issue_amount;
	$sq_pass = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from passport_payment_master where passport_id='$passport_id'"));
	$balance_amount = $passport_total_cost - $sq_pass['payment_amount'];

	global $transaction_master;
    //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

    //***========================Booking entries start=============================***//
    //**Sales**//

    $module_name = "Passport Booking";
    $module_entry_id = $passport_id;
    $transaction_id = "";
    $payment_amount = $passport_sale_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
    $old_gl_id = $gl_id = 93;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

    ////////////service charge/////////////
	$module_name = "Passport Booking";
	$module_entry_id = $passport_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
	$old_gl_id = $gl_id = ($reflections[0]->passport_sc != '') ? $reflections[0]->passport_sc : 194;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

	/////////Service Charge Tax Amount////////
	// Eg. CGST:(9%):24.77, SGST:(9%):24.77
	$service_tax_subtotal = explode(',',$service_tax_subtotal);
	$tax_ledgers = explode(',',$reflections[0]->passport_taxes);
	for($i=0;$i<sizeof($service_tax_subtotal);$i++){

		$service_tax = explode(':',$service_tax_subtotal[$i]);
		$tax_amount = $service_tax[2];
		$ledger = $tax_ledgers[$i];

		$module_name = "Passport Booking";
		$module_entry_id = $passport_id;
		$transaction_id = "";
		$payment_amount = $tax_amount;
		$payment_date = $created_at;
		$payment_particular = $particular;
		$ledger_particular = get_ledger_particular('To','Passport Sales');
		$old_gl_id = $gl_id = $ledger;
		$payment_side = "Credit";
		$clearance_status = "";
		$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	}

	/////////roundoff/////////
	$module_name = "Passport Booking";
	$module_entry_id = $passport_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
	$old_gl_id = $gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

	////////Customer Amount//////
	$module_name = "Passport Booking";
	$module_entry_id = $passport_id;
	$transaction_id = "";
	$payment_amount = $passport_total_cost;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Passport Sales');
	$old_gl_id = $gl_id = $cust_gl;
	$payment_side = "Debit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
}



public function passport_booking_email_send($passport_id)

{

	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

	global $app_name,$secret_key,$encrypt_decrypt;

	$link = BASE_URL.'view/customer';



	$sq_passport = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));

	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport[customer_id]'"));

	$date = $sq_passport['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];

	
	$email_id  = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];

	$password= $email_id;

	$username  = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$subject = 'Booking confirmation acknowledgement! ( '.get_passport_booking_id($passport_id,$year). ' )';

	$content = mail_login_box($username, $password, $link);

	global $model,$backoffice_email_id;

	$model->app_email_send('21',$sq_customer['first_name'],$email_id, $content,$subject);
	if($backoffice_mail_id != "")
	$model->app_email_send('21',"Team",$backoffice_email_id, $content, $subject);

}

public function employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id)
{
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   $link = BASE_URL.'view/customer';
  $content = mail_login_box($username, $password, $link);
  $subject ='Welcome aboard!';
  global $model;
  $model->app_email_send('2',$first_name,$email_id, $content,$subject,'1');
}
public function whatsapp_send(){
	global $app_contact_no,$secret_key,$encrypt_decrypt;
  
   $emp_id = $_POST['emp_id '];
   $booking_date = $_POST['booking_date'];
   $customer_id = $_POST['customer_id'];
  
   if($customer_id == '0'){
    $sq_customer = mysql_fetch_assoc(mysql_query("SELECT * FROM customer_master ORDER BY customer_id DESC LIMIT 1"));
  }
  else{
   $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  }
   $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
   $sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id= '$emp_id"));
   if($emp_id == 0){
	 $contact = $app_contact_no;
   }
   else{
	 $contact = $sq_emp_info['mobile_no'];
   }
   
   $whatsapp_msg = rawurlencode('Hello Dear '.$sq_customer[first_name].',
Hope you are doing great. This is to inform you that your booking is confirmed with us. We look forward to provide you a great experience.
*Booking Date* : '.get_date_user($booking_date).'
  
Please contact for more details : '.$contact.'
Thank you.');
   $link = 'https://web.whatsapp.com/send?phone='.$contact_no.'&text='.$whatsapp_msg;
   echo $link;
  }



}

?>