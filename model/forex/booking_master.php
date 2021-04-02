<?php 

$flag = true;

class booking_master{



public function booking_save()
{    
	$customer_id = $_POST['customer_id'];
    $emp_id = $_POST['emp_id'];
    $branch_admin_id = $_POST['branch_admin_id'];
	$manadatory_docs = $_POST['manadatory_docs'];
	$photo_proof_given = $_POST['photo_proof_given'];
	$residence_proof = $_POST['residence_proof'];
	$booking_type = $_POST['booking_type'];
	$currency_code = $_POST['currency_code'];
	$rate = $_POST['rate'];
	$forex_amount = $_POST['forex_amount'];
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
    $balance_date1 = $_POST['balance_date'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
    
    $payment_date = $_POST['payment_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];

	$payment_date = get_date_db($payment_date);
    $balance_date = get_date_db($balance_date1);
    
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
		  case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
		  case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		}
  }
  $roundoff = $_POST['roundoff'];

    if($payment_mode=="Cheque"||$payment_mode=="Credit Card"){ 
        $clearance_status = "Pending"; } 
    else {  $clearance_status = ""; }   
    $financial_year_id = $_SESSION['financial_year_id'];
	//**Starting Transaction
	begin_t();

    //Get Customer id
    if($customer_id == '0'){
        $sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
        $customer_id = $sq_max['max'];
    }

	//**Insert booking
	$sq_max = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from forex_booking_master"));
	$booking_id = $sq_max['max'] + 1;
    $reflections = json_encode($reflections);
    $bsmValues = json_encode($bsmValues);
    $sq_insert = mysql_query("INSERT into forex_booking_master (booking_id, customer_id, branch_admin_id,financial_year_id, manadatory_docs, photo_proof_given, residence_proof, booking_type, currency_code, rate, forex_amount, basic_cost, service_charge,service_tax_subtotal, net_total, created_at, emp_id, reflections, roundoff, bsm_values) values ('$booking_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$manadatory_docs', '$photo_proof_given', '$residence_proof', '$booking_type', '$currency_code', '$rate', '$forex_amount', '$basic_cost', '$service_charge','$service_tax_subtotal', '$net_total', '$balance_date', '$emp_id', '$reflections', '$roundoff', '$bsmValues')");
    

	if(!$sq_insert){

		$GLOBALS['flag'] = false;

		echo "error--Booking not saved!";

	}



	//**Saving Payment

	$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from forex_booking_payment_master"));

    $payment_id = $sq_max['max'] + 1;



    $sq_payment = mysql_query("insert into forex_booking_payment_master (payment_id, booking_id, financial_year_id, branch_admin_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$booking_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");

    if(!$sq_payment){

        $GLOBALS['flag'] = false;

        echo "error--Sorry, Payment not saved!";

    }


    if($booking_type=='Sale'){
        //Update customer credit note balance
        $payment_amount1 = $payment_amount;
        $sq_credit_note = mysql_query("select * from credit_note_master where customer_id='$customer_id'");
        $i=0;
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
    }
    //Get Particular
    $particular = $this->get_particular($customer_id,$balance_date);
    //Finance save
    if($booking_type=='Sale'){
     $this->finance_save($booking_id, $payment_id, $branch_admin_id,$particular);
    }
    //Bank and Cash Book Save
    $this->bank_cash_book_save($booking_id, $payment_id, $branch_admin_id);



    //**Ending Transaction

    if($GLOBALS['flag']){

        commit_t();

        if($booking_type=='Sale'){

            $this->booking_mail($booking_id, $customer_id);

        }

        //payment email send
        $payment_master  = new payment_master;
        $payment_master->payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date);
        $this->booking_sms($booking_id, $customer_id, $balance_date);
        
		//Visa payment sms send
		if($payment_amount != 0){
			$payment_master->payment_sms_notification_send($booking_id, $payment_amount, $payment_mode);
		}
        echo "Forex Booking has been successfully saved.";
        exit;
    }
    else{
        rollback_t();
        exit;
    }
}

function get_particular($customer_id,$date){

	$sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
  
    return 'Forex purchsed for '.$cust_name.' Dt.'.get_date_user($date);
  }
public function finance_save($booking_id, $payment_id, $branch_admin_id,$particular){

    $row_spec = 'sales';
    $customer_id = $_POST['customer_id'];
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
	$booking_type = $_POST['booking_type'];
    $booking_date = $_POST['balance_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
    $bank_id1 = $_POST['bank_id'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
    $reflections = json_decode(json_encode($_POST['reflections']));

    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
            switch($key){
            case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
            case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
            }
    }
    $roundoff = $_POST['roundoff'];

    $payment_date1 = date('Y-m-d', strtotime($payment_date));
	$booking_date = date('Y-m-d', strtotime($booking_date));
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
	$year2 = explode("-", $payment_date1);
	$yr2 =$year2[0];

    $forex_sale_amount = $basic_cost;
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
    $module_name = "Forex Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $forex_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Forex Sales');
    $gl_id = 22;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    ////////////service charge/////////////
    $module_name = "Forex Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Forex Sales');
    $gl_id =  ($reflections[0]->forex_sc != '') ? $reflections[0]->forex_sc : 195;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    ///////// Tax Amount////////
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->forex_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Forex Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Forex Sales');
    $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
  }

   ////Roundoff Value
   $module_name = "Forex Booking";
   $module_entry_id = $booking_id;
   $transaction_id = "";
   $payment_amount = $roundoff;
   $payment_date = $booking_date;
   $payment_particular = $particular;
   $ledger_particular = get_ledger_particular('To','Forex Sales');
   $gl_id = 230;
   $payment_side = "Credit";
   $clearance_status = "";
   $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

   ////////Customer Amount//////
   $module_name = "Forex Booking";
   $module_entry_id = $booking_id;
   $transaction_id = "";
   $payment_amount = $net_total;
   $payment_date = $booking_date;
   $payment_particular = $particular;
   $ledger_particular = get_ledger_particular('To','Forex Sales');
   $gl_id = $cust_gl;
   $payment_side = "Debit";
   $clearance_status = "";
   $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Forex Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_forex_booking_id($booking_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Forex Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_forex_booking_id($booking_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
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
			$module_name = "Forex Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_forex_booking_id($booking_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Forex Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_forex_booking_id($booking_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Forex Booking";
			$module_entry_id = $booking_id;
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
		$module_name = "Forex Booking";
		$module_entry_id = $booking_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_forex_booking_id($booking_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
    
}           

public function bank_cash_book_save($booking_id, $payment_id, $branch_admin_id){

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
    $booking_type = $_POST['booking_type'];
    
    $payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
    $yr1 = $year1[0];

	$booking_date = date('Y-m-d', strtotime($booking_date));
	$year2 = explode("-", $booking_date);
	$yr2 =$year2[0];
    
    if($payment_mode == 'Credit Card'){
        $payment_amount = $payment_amount + $credit_charges;
        $credit_card_details = explode('-',$credit_card_details);
        $entry_id = $credit_card_details[0];
        $sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
        $bank_id = $sq_credit_charges['bank_id'];
    }

    //Get Customer id
    if($customer_id == '0'){
        $sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
        $customer_id = $sq_max['max'];
    }
    
    $module_name = "Forex Booking";
    $module_entry_id = $payment_id;
    $payment_date = $payment_date;
    $payment_amount = $payment_amount;
    $payment_mode = $payment_mode;
    $bank_name = $bank_name;
    $transaction_id = $transaction_id;
    $bank_id = $bank_id;
    $particular = get_sales_paid_particular(get_forex_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_forex_booking_id($booking_id,$yr2),$bank_id,$transaction_id);
    $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
    $payment_side = ($booking_type=="Sale") ? "Debit" : "Credit";
    $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

    $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);
}


public function booking_mail($booking_id, $customer_id){

    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

    global $app_name,$secret_key,$encrypt_decrypt;

    $sq_visa = mysql_fetch_assoc(mysql_query("select * from  forex_booking_master where booking_id='$booking_id'"));
    $date = $sq_visa['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];

    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_visa[customer_id]'"));

    $email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 
    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
    $password = $email_id;
    
    $username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
    $link = BASE_URL.'view/customer';
    $subject = 'Booking confirmation acknowledgement! ( Booking ID : '.get_forex_booking_id($booking_id,$year). ' )';
    $content = mail_login_box($username, $password, $link);
    global $model,$backoffice_email_id,$password;
    $model->app_email_send('22',$sq_customer['first_name'],$email_id, $content, $subject);
}

public function booking_sms($booking_id, $customer_id, $created_at){

    global $model, $app_name,$secret_key,$encrypt_decrypt;
    $sq_customer_info = mysql_fetch_assoc(mysql_query("select contact_no from customer_master where customer_id='$customer_id'"));
    $mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
    $date = $created_at;
    $yr = explode("-", $date);
    $yr1 =$yr[0];
    
    $date = $created_at;
    $yr = explode("-", $date);
    $yr1 =$yr[0];
    $message = 'Thank you for booking with '.$app_name.'. Booking No : '.get_forex_booking_id($booking_id,$yr1).'  Date :'.get_date_user($created_at);
   
    $model->send_message($mobile_no, $message);  
}

function employee_sign_up_mail($cust_first_name, $cust_last_name, $username, $password, $email_id)
{
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   $link = BASE_URL.'view/customer';
  $content = mail_login_box($username, $password, $link);
  $subject ='Welcome aboard!';
  global $model;
 
  $model->app_email_send('2',$cust_first_name,$email_id, $content,$subject,'1');
}

public function booking_update()

{

    $booking_id = $_POST['booking_id'];

    $customer_id = $_POST['customer_id'];

    $manadatory_docs = $_POST['manadatory_docs'];

    $photo_proof_given = $_POST['photo_proof_given'];

    $residence_proof = $_POST['residence_proof'];

    $booking_type = $_POST['booking_type'];

    $currency_code = $_POST['currency_code'];

    $rate = $_POST['rate'];

    $forex_amount = $_POST['forex_amount'];

    $basic_cost = $_POST['basic_cost'];

    $service_charge = $_POST['service_charge'];

    $service_tax_subtotal = $_POST['service_tax_subtotal'];

    $net_total = $_POST['net_total'];
    $booking_date1 = $_POST['booking_date1'];

    $booking_date1 = date('Y-m-d', strtotime($booking_date1));

    $reflections = json_decode(json_encode($_POST['reflections']));
    //**Starting Transaction

    begin_t();
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
        switch($key){
            case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost ;break;
            case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
        }
    }
    $roundoff = $_POST['roundoff'];

    //**Old info

    $sq_booking_info = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'"));



    //**Update booking
    $reflections = json_encode($reflections);
    $bsmValues = json_encode($bsmValues);
    $sq_update = mysql_query("UPDATE forex_booking_master set customer_id='$customer_id', manadatory_docs='$manadatory_docs', photo_proof_given='$photo_proof_given', residence_proof='$residence_proof', booking_type='$booking_type', currency_code='$currency_code', rate='$rate', forex_amount='$forex_amount', basic_cost='$basic_cost', service_charge='$service_charge', service_tax_subtotal='$service_tax_subtotal', net_total='$net_total',created_at='$booking_date1',reflections='$reflections',roundoff='$roundoff',bsm_values='$bsmValues' where booking_id='$booking_id'");

    if(!$sq_update){

        $GLOBALS['flag'] = false;

        echo "error--Booking not updated!";

    }



    //Finance update
    if($booking_type == 'Sale'){
        //Get Particular
        $particular = $this->get_particular($customer_id,$booking_date1);
        $this->finance_update($sq_booking_info,$particular);    
    }



    //**Ending Transaction

    if($GLOBALS['flag']){

        commit_t();

        

        echo "Forex Booking has been successfully updated.";

        exit;

    }

    else{

        rollback_t();

        exit;

    }





}



public function finance_update($sq_booking_info,$particular)
{
    $row_spec = 'sales';
    $booking_id = $_POST['booking_id'];
    $customer_id = $_POST['customer_id'];
    $booking_type = $_POST['booking_type'];
    $basic_cost = $_POST['basic_cost'];
    $service_charge = $_POST['service_charge'];
    $service_tax_subtotal = $_POST['service_tax_subtotal'];
    $net_total = $_POST['net_total'];
    $reflections = json_decode(json_encode($_POST['reflections']));

    $created_at = $_POST['booking_date1'];
    $booking_date = get_date_db($created_at);
	$year1 = explode("-", $booking_date);
    $yr1 =$year1[0];
    
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
		  case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
		  case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		}
	}
	$roundoff = $_POST['roundoff'];

    $forex_sale_amount = $basic_cost;
    //get total payment against forex id
    $sq_forex = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from forex_booking_payment_master where booking_id='$booking_id'"));
    $balance_amount = $net_total - $sq_forex['payment_amount'];

    //Getting customer Ledger
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust['ledger_id'];


    global $transaction_master;

    ////////////Sales/////////////
    $module_name = "Forex Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $forex_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Forex Sales');
    $old_gl_id = $gl_id = 22;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

    ////////////service charge/////////////
	$module_name = "Forex Booking";
	$module_entry_id = $booking_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Forex Sales');
	$old_gl_id = $gl_id =  ($reflections[0]->forex_sc != '') ? $reflections[0]->forex_sc : 195;
	$payment_side = "Credit";
	$clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

     /////////Tax Amount////////
	$service_tax_subtotal = explode(',',$service_tax_subtotal);
	$tax_ledgers = explode(',',$reflections[0]->forex_taxes);
	for($i=0;$i<sizeof($service_tax_subtotal);$i++){
  
	  $service_tax = explode(':',$service_tax_subtotal[$i]);
	  $tax_amount = $service_tax[2];
	  $ledger = $tax_ledgers[$i];
  
	  $module_name = "Forex Booking";
	  $module_entry_id = $booking_id;
	  $transaction_id = "";
	  $payment_amount = $tax_amount;
	  $payment_date = $booking_date;
	  $payment_particular = $particular;
	  $ledger_particular = get_ledger_particular('To','Forex Sales');
	  $old_gl_id = $gl_id = $ledger;
	  $payment_side = "Credit";
	  $clearance_status = "";
	  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
    }
    
    /////////roundoff/////////
	$module_name = "Forex Booking";
	$module_entry_id = $booking_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Forex Sales');
	$old_gl_id = $gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

    ////////Customer Amount//////
	$module_name = "Forex Booking";
	$module_entry_id = $booking_id;
	$transaction_id = "";
	$payment_amount = $net_total;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Forex Sales');
	$old_gl_id = $gl_id = $cust_gl;
	$payment_side = "Debit";
	$clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

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