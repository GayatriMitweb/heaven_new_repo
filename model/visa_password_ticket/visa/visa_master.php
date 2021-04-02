<?php 

$flag = true;

class visa_master{
public function visa_master_save()
{
	$row_spec = 'sales';	
	$service_tax_no = strtoupper($_POST['service_tax_no']);
	$landline_no = $_POST['landline_no'];
	$alt_email_id = $_POST['alt_email_id'];
	$company_name = $_POST['company_name'];
	$cust_type = $_POST['cust_type'];
    $state = $_POST['state'];
	$username = $contact_no;
	$password = $email_id;

	$customer_id = $_POST['customer_id'];
	$emp_id = $_POST['emp_id'];
	$visa_issue_amount = $_POST['visa_issue_amount'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$financial_year_id = $_POST['financial_year_id'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$visa_total_cost = $_POST['visa_total_cost'];
	$roundoff = $_POST['roundoff'];
	$due_date = $_POST['due_date'];
	$balance_date = $_POST['balance_date'];

	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$reflections = json_decode(json_encode($_POST['reflections']));

	$first_name_arr = $_POST['first_name_arr'];
	$middle_name_arr = $_POST['middle_name_arr'];
	$last_name_arr = $_POST['last_name_arr'];
	$birth_date_arr = $_POST['birth_date_arr'];
	$adolescence_arr = $_POST['adolescence_arr'];
	$visa_country_name_arr = $_POST['visa_country_name_arr'];
	$visa_type_arr = $_POST['visa_type_arr'];
	$passport_id_arr = $_POST['passport_id_arr'];
	$issue_date_arr = $_POST['issue_date_arr'];
	$expiry_date_arr = $_POST['expiry_date_arr'];
	$nationality_arr = $_POST['nationality_arr'];
	$received_documents_arr = $_POST['received_documents_arr'];
	$appointment_date_arr = $_POST['appointment_date_arr'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$payment_date = date('Y-m-d', strtotime($payment_date));
	$balance_date = date("Y-m-d", strtotime($balance_date));
	$due_date = date("Y-m-d", strtotime($due_date));

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
	
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $visa_issue_amount = ($value != "") ? $value : $visa_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}

    //visa save
	$sq_max = mysql_fetch_assoc(mysql_query("select max(visa_id) as max from visa_master"));
	$visa_id = $sq_max['max'] + 1;

	$reflections = json_encode($reflections);
	$bsmValues = json_encode($bsmValues);
	
	$sq_visa = mysql_query("insert into visa_master (visa_id, customer_id,branch_admin_id,financial_year_id, visa_issue_amount, service_charge, service_tax_subtotal, visa_total_cost, roundoff, markup, markup_tax, reflections,created_at, due_date,emp_id, bsm_values) values ('$visa_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$visa_issue_amount', '$service_charge', '$service_tax_subtotal', '$visa_total_cost', '$roundoff','$markup','$service_tax_markup','$reflections','$balance_date', '$due_date', '$emp_id', '$bsmValues')");

	if(!$sq_visa){
		rollback_t();
		echo "error--Sorry visa information not saved successfully!";
		exit;
	}
	else{
		for($i=0; $i<sizeof($first_name_arr); $i++){

			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from visa_master_entries"));
			$entry_id = $sq_max['max'] + 1;

			$birth_date_arr[$i] = get_date_db($birth_date_arr[$i]);
			$issue_date_arr[$i] = get_date_db($issue_date_arr[$i]);
			$expiry_date_arr[$i] = get_date_db($expiry_date_arr[$i]);
			$appointment_date_arr[$i] = get_date_db($appointment_date_arr[$i]);

			$sq_entry = mysql_query("insert into visa_master_entries(entry_id, visa_id, first_name, middle_name, last_name, birth_date, adolescence, visa_country_name, visa_type, passport_id, issue_date, expiry_date,nationality, received_documents,appointment_date) values('$entry_id', '$visa_id', '$first_name_arr[$i]', '$middle_name_arr[$i]', '$last_name_arr[$i]', '$birth_date_arr[$i]', '$adolescence_arr[$i]', '$visa_country_name_arr[$i]', '$visa_type_arr[$i]', '$passport_id_arr[$i]', '$issue_date_arr[$i]', '$expiry_date_arr[$i]', '$nationality_arr[$i]', '$received_documents_arr[$i]','$appointment_date_arr[$i]')");

			if(!$sq_entry){
				$GLOBALS['flag'] = false;
				echo "error--Some Visa entries are not saved!";
				//exit;
			}
		}

		$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from visa_payment_master"));
		$payment_id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into visa_payment_master (payment_id, visa_id, financial_year_id, branch_admin_id,  payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$visa_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");
		if(!$sq_payment){
			$GLOBALS['flag'] = false;
			echo "error--Sorry, Payment not saved!";
		}

		//Update customer credit note balance
		$payment_amount1 = $payment_amount;
		$sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
		while($row_credit = mysql_fetch_assoc($sq_credit_note)) 
		{	
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
		$particular = $this->get_particular($customer_id,$visa_type_arr[0]);

		//Finance save
    	$this->finance_save($visa_id, $payment_id,$row_spec, $branch_admin_id,$particular);
    	//Bank and Cash Book Save
    	$this->bank_cash_book_save($visa_id, $payment_id, $branch_admin_id);

		if($GLOBALS['flag']){

			commit_t();
			//Visa Booking email send
			$sq_cms_count = mysql_num_rows(mysql_query("select * from cms_master_entries where id='11' and active_flag='Active'"));
          	if($sq_cms_count != '0'){
				$this->visa_booking_email_send($visa_id, $visa_country_name_arr, $visa_type_arr,$first_name_arr,$payment_amount);
			}
			$this->booking_sms($visa_id, $customer_id, $balance_date);

			//Visa payment email send
			$visa_payment_master  = new visa_payment_master;
			$visa_payment_master->payment_email_notification_send($visa_id, $payment_amount, $payment_mode, $payment_date);			

			//Visa payment sms send
			if($payment_amount != 0){
				$visa_payment_master->payment_sms_notification_send($visa_id, $payment_amount, $payment_mode);
			}

			echo "Visa Booking has been successfully saved.";
			exit;
		}

		else{

			rollback_t();

			exit;

		}
	}

}

public function booking_sms($booking_id, $customer_id, $created_at){

    global $model, $app_name, $encrypt_decrypt, $secret_key,$app_contact_no;
    $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
    
    $date = $created_at;
    $yr = explode("-", $date);
	$yr1 =$yr[0];
	
   
	$message = "Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", your Visa Tour booking is confirmed. Please send your documents as earlier. Please contact for more details .".$app_contact_no."";
    $model->send_message($mobile_no, $message);  
}

public function finance_save($visa_id, $payment_id, $row_spec,$branch_admin_id,$particular)
{
    $customer_id = $_POST['customer_id'];
	$visa_issue_amount = $_POST['visa_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$visa_total_cost = $_POST['visa_total_cost'];
	$roundoff = $_POST['roundoff'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$bank_id1 = $_POST['bank_id'];	
	$booking_date = $_POST['balance_date'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
	
	$reflections = json_decode(json_encode($_POST['reflections']));

	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];

	$booking_date = date("Y-m-d", strtotime($booking_date));
	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $booking_date);
	$year2 = explode("-", $payment_date1);
	$yr1 =$year1[0];
	$yr2 =$year2[0];

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $visa_issue_amount = ($value != "") ? $value : $visa_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}

	$visa_sale_amount = $visa_issue_amount;
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
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK RECEIPT';
     } 

    global $transaction_master;

    ////////////Sales/////////////

    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $visa_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $gl_id = 140;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	
	/////////Service Charge////////
    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 188;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',  $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	
	/////////Service Charge Tax Amount////////
    $customer_amount = $visa_issue_amount+$service_charge+$markup;
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Visa Booking";
      $module_entry_id = $visa_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Visa Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',  $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    }

	///////////Markup//////////
    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $markup;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $gl_id = ($reflections[0]->hotel_markup != '') ? $reflections[0]->hotel_markup : 200;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',  $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Markup Tax Amount////////
    $service_tax_markup = explode(',',$service_tax_markup);
    $tax_ledgers = explode(',',$reflections[0]->hotel_markup_taxes);
    for($i=0;$i<sizeof($service_tax_markup);$i++){

      $service_tax = explode(':',$service_tax_markup[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Visa Booking";
      $module_entry_id = $visa_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Visa Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'1' ,$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}

	////////Customer Amount//////
    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $visa_total_cost;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	
	////Roundoff Value
    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	
	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Visa Booking";
			$module_entry_id = $visa_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_visa_booking_id($visa_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Visa Booking";
			$module_entry_id = $visa_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_visa_booking_id($visa_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr1),$bank_id1,$transaction_id1);
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
			$module_name = "Visa Booking";
			$module_entry_id = $visa_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_visa_booking_id($visa_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Visa Booking";
			$module_entry_id = $visa_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_visa_booking_id($visa_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Visa Booking";
			$module_entry_id = $visa_id;
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
		$module_name = "Visa Booking";
		$module_entry_id = $visa_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_visa_booking_id($visa_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr1),$bank_id1,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}

}
public function bank_cash_book_save($visa_id, $payment_id,$branch_admin_id)
{
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

	$payment_date = date("Y-m-d", strtotime($payment_date));
	
	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}

	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];
	$year2 = explode("-", $booking_date);
	$yr2 =$year1[0];
	//Get Customer id
	if($customer_id == '0'){
		$sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
		$customer_id = $sq_max['max'];
	}
	$module_name = "Visa Booking";
	$module_entry_id = $payment_id;
	$payment_date = $payment_date;
	$payment_amount = $payment_amount;
	$payment_mode = $payment_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = get_sales_paid_particular(get_visa_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_visa_booking_id($visa_id,$yr2),$bank_id,$transaction_id);
	$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
	$payment_side = "Debit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type,$branch_admin_id);
}


public function visa_master_update(){
	$row_spec = "sales";	
	$visa_id = $_POST['visa_id'];
	$customer_id = $_POST['customer_id'];
	$visa_issue_amount = $_POST['visa_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$visa_total_cost = $_POST['visa_total_cost'];
	$roundoff = $_POST['roundoff'];
	$due_date1 = $_POST['due_date1'];
	$balance_date1 = $_POST['balance_date1'];
	$first_name_arr = $_POST['first_name_arr'];
	$middle_name_arr = $_POST['middle_name_arr'];
	$last_name_arr = $_POST['last_name_arr'];
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	$birth_date_arr = $_POST['birth_date_arr'];
	$adolescence_arr = $_POST['adolescence_arr'];
	$visa_country_name_arr = $_POST['visa_country_name_arr'];
	$visa_type_arr = $_POST['visa_type_arr'];
	$passport_id_arr = $_POST['passport_id_arr'];
	$issue_date_arr = $_POST['issue_date_arr'];
	$expiry_date_arr = $_POST['expiry_date_arr'];
	$received_documents_arr = $_POST['received_documents_arr'];
	$entry_id_arr = $_POST['entry_id_arr'];
	$nationality_arr = $_POST['nationality_arr'];
	$appointment_date_arr = $_POST['appointment_date_arr'];
	$sq_visa_info = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id='$visa_id'"));
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$reflections = json_decode(json_encode($_POST['reflections']));

	$issue_date = date('Y-m-d', strtotime($issue_date));
	$due_date1 = date('Y-m-d',strtotime($due_date1));
	$balance_date1 = date('Y-m-d',strtotime($balance_date1));
	$reflections = json_encode($reflections);

	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $visa_issue_amount = ($value != "") ? $value : $visa_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}
	begin_t();

	$reflections = json_encode($reflections);
	$bsmValues = json_encode($bsmValues);
	$sq_visa = mysql_query("update visa_master set customer_id='$customer_id', visa_issue_amount='$visa_issue_amount', service_charge='$service_charge' , service_tax_subtotal='$service_tax_subtotal', visa_total_cost='$visa_total_cost', due_date='$due_date1',created_at='$balance_date1',markup='$markup',markup_tax='$service_tax_markup',reflections='$reflections',bsm_values='$bsmValues' , roundoff='$roundoff' where visa_id='$visa_id' ");

	if(!$sq_visa){

		rollback_t();

		echo "error--Sorry, Visa information not updated successfully!";

		exit;

	}

	else{		



		for($i=0; $i<sizeof($first_name_arr); $i++){


			$birth_date_arr[$i] = get_date_db($birth_date_arr[$i]);
			$issue_date_arr[$i] = get_date_db($issue_date_arr[$i]);
			$expiry_date_arr[$i] = get_date_db($expiry_date_arr[$i]);
			$appointment_date_arr[$i] = get_date_db($appointment_date_arr[$i]);
			if($entry_id_arr[$i]==""){

				$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from visa_master_entries"));

				$entry_id = $sq_max['max'] + 1;

				$sq_entry = mysql_query("insert into visa_master_entries(entry_id, visa_id, first_name, middle_name, last_name, birth_date, adolescence, visa_country_name, visa_type, passport_id, issue_date, expiry_date, nationality, received_documents,appointment_date) values('$entry_id', '$visa_id', '$first_name_arr[$i]', '$middle_name_arr[$i]', '$last_name_arr[$i]', '$birth_date_arr[$i]', '$adolescence_arr[$i]', '$visa_country_name_arr[$i]', '$visa_type_arr[$i]', '$passport_id_arr[$i]', '$issue_date_arr[$i]', '$expiry_date_arr[$i]', '$nationality_arr[$i]', '$received_documents_arr[$i]','$appointment_date_arr[$i]')");

				if(!$sq_entry){
					$GLOBALS['flag'] = false;
					echo "error--Some Visa entries are not saved!";
					//exit;
				}	
			}
			else{
				$sq_entry = mysql_query("update visa_master_entries set first_name='$first_name_arr[$i]', middle_name='$middle_name_arr[$i]', last_name='$last_name_arr[$i]', birth_date='$birth_date_arr[$i]', adolescence='$adolescence_arr[$i]', visa_country_name='$visa_country_name_arr[$i]', visa_type='$visa_type_arr[$i]', passport_id='$passport_id_arr[$i]', issue_date='$issue_date_arr[$i]', expiry_date='$expiry_date_arr[$i]', received_documents='$received_documents_arr[$i]', nationality='$nationality_arr[$i]',appointment_date	='$appointment_date_arr[$i]' where entry_id='$entry_id_arr[$i]'");
				if(!$sq_entry){
					$GLOBALS['flag'] = false;
					echo "error--Some Visa entries are not updated!";
					//exit;
				}	
			}
		}



		//Get Particular
		$particular = $this->get_particular($customer_id,$visa_type_arr[0]);
		//Finance update
		$this->finance_update($sq_visa_info,$row_spec,$particular);

		if($GLOBALS['flag']){

			commit_t();

			echo "Visa Booking has been successfully updated.";

			exit;	

		}

		else{

			rollback_t();

			exit;

		}

		

	}

}

function get_particular($customer_id,$services){

	$sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
  
	return $services.' for '.$cust_name;
  }

public function finance_update($sq_visa_info, $row_spec,$particular)
{
	$row_spec = 'sales';
	$visa_id = $_POST['visa_id'];
	$customer_id = $_POST['customer_id'];
	$visa_issue_amount = $_POST['visa_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$visa_total_cost = $_POST['visa_total_cost'];
	$roundoff = $_POST['roundoff'];
	$balance_date1 = $_POST['balance_date1'];
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$created_at = date('Y-m-d',strtotime($balance_date1));
	$year1 = explode("-", $created_at);
	$yr1 =$year1[0];
	$reflections = json_decode(json_encode($_POST['reflections']));
	global $transaction_master;

	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $visa_issue_amount = ($value != "") ? $value : $visa_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}
    $visa_sale_amount = $visa_issue_amount;
    //get total payment against visa id
    $sq_visa = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from visa_payment_master where visa_id='$visa_id'"));
	$balance_amount = $visa_total_cost - $sq_visa['payment_amount'];

    //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];


    ////////////Sales/////////////

    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $visa_sale_amount;
    $payment_date = $created_at;
    $payment_particular =$particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $old_gl_id = $gl_id = 140;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	
	////////////service charge/////////////
	$module_name = "Visa Booking";
	$module_entry_id = $visa_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Visa Sales');
	$old_gl_id = $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 188;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

	/////////Service Charge Tax Amount////////
  $service_tax_subtotal = explode(',',$service_tax_subtotal);
  $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
  for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $old_gl_id = $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  }

  ////////////markup/////////////
  $module_name = "Visa Booking";
  $module_entry_id = $visa_id;
  $transaction_id = "";
  $payment_amount = $markup;
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Visa Sales');
  $old_gl_id = $gl_id = ($reflections[0]->hotel_markup != '') ? $reflections[0]->hotel_markup : 200;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

  /////////Markup Tax Amount////////
  // Eg. CGST:(9%):24.77, SGST:(9%):24.77
  $service_tax_markup = explode(',',$service_tax_markup);
  $tax_ledgers = explode(',',$reflections[0]->hotel_markup_taxes);
  for($i=0;$i<sizeof($service_tax_markup);$i++){

    $service_tax = explode(':',$service_tax_markup[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Visa Booking";
    $module_entry_id = $visa_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Visa Sales');
    $old_gl_id = $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '1',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  }
  /////////roundoff/////////
  $module_name = "Visa Booking";
  $module_entry_id = $visa_id;
  $transaction_id = "";
  $payment_amount = $roundoff;
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Visa Sales');
  $old_gl_id = $gl_id = 230;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

  ////////Customer Amount//////
  $module_name = "Visa Booking";
  $module_entry_id = $visa_id;
  $transaction_id = "";
  $payment_amount = $visa_total_cost;
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Visa Sales');
  $old_gl_id = $gl_id = $cust_gl;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
}

public function visa_booking_email_send($visa_id, $visa_country_name_arr, $visa_type_arr,$first_name_arr,$payment_amount)
{
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$currency_logo;
	global $app_name,$encrypt_decrypt,$secret_key;

	$link = BASE_URL.'view/customer';

	$sq_visa = mysql_fetch_assoc(mysql_query("select * from visa_master where visa_id='$visa_id'"));
	$date = $sq_visa['created_at'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_visa[customer_id]'"));

	$username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$password = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	
	$doc_link_content = '';

	for($i=0; $i<sizeof($visa_country_name_arr); $i++){



		$visa_docs_link = '../../../images/Visa-Documents/'.strtoupper($visa_country_name_arr[$i]).'/'.$visa_type_arr[$i].'.txt';



		if(is_file($visa_docs_link)){

		
		}

		else{

			$visa_docs_link = "";

		}
		if($visa_docs_link!=""){

			$visa_docs_link = BASE_URL.'images/Visa-Documents/'.strtoupper($visa_country_name_arr[$i]).'/'.$visa_type_arr[$i].'.txt';

			$doc_link_content .='

			<tr>
				<td>
					<span style="display: inline-block; padding: 14px 0 6px 0; border-bottom: 1px dotted #a0a0a0;">
						<a href="'.$visa_docs_link.'">Required Documents Link for</a> : <strong>'.$visa_country_name_arr[$i].'</strong>
					</span>
				</td>
			</tr>
			';	

		}
	}

	$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];

	$subject = 'Booking confirmation acknowledgement! ( '.get_visa_booking_id($visa_id,$year). ' )';

	$VisaDetails = mysql_query('SELECT * FROM `visa_master_entries` WHERE visa_id = '.$visa_id);
	$remaining_cost = $sq_visa['visa_total_cost'] - $payment_amount;
	$content = '<tr>
	<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '. number_format($sq_visa[visa_total_cost],2).'</td></tr>
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($payment_amount,2).'</td></tr> 
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($remaining_cost,2).'</td></tr>
		</table>
	  </tr>
	';

	while($rows = mysql_fetch_assoc($VisaDetails)){
		$content .= '<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
		  <tr><th colspan=2>Visa Details</th></tr>
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Concern Person</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $rows[first_name].'</td></tr>
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Country Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows[visa_country_name].'</td></tr> 
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Visa Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows[visa_type].'</td></tr>
		</table>
	  </tr>';
	}

	$content .= mail_login_box($username, $password, $link);

	global $model,$backoffice_email_id;

	$model->app_email_send('15',$first_name_arr[0],$password, $content, $subject);
	if($backoffice_email_id != "")
	$model->app_email_send('15',"Admin",$backoffice_email_id, $content,$subject);

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
	global $app_contact_no,$encrypt_decrypt,$secret_key;
  
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