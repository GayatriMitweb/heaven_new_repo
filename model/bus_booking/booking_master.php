<?php 

$flag = true;

class booking_master{
public function booking_save()
{
    $row_spec = 'sales';
	$customer_id = $_POST['customer_id'];
    $emp_id = $_POST['emp_id'];
	$branch_admin_id = $_POST['branch_admin_id'];	
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
    $balance_date1 = $_POST['balance_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];
    $company_name_arr = $_POST['company_name_arr'];
    $bus_type_arr = $_POST['bus_type_arr'];
    $bus_type_new_arr = $_POST['bus_type_new_arr'];
    $pnr_no_arr = $_POST['pnr_no_arr'];
    $origin_arr = $_POST['origin_arr'];
    $destination_arr = $_POST['destination_arr'];
    $date_of_journey_arr = $_POST['date_of_journey_arr'];
    $reporting_time_arr = $_POST['reporting_time_arr'];
    $boarding_point_access_arr = $_POST['boarding_point_access_arr'];
    $service_tax_markup = $_POST['service_tax_markup'];
    $markup = $_POST['markup'];
    $roundoff = $_POST['roundoff'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $financial_year_id = $_SESSION['financial_year_id'];
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    $credit_charges = $_POST['credit_charges'];
    $credit_card_details = $_POST['credit_card_details'];

    foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
        case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
        case 'markup' : $markup = ($value != "") ? $value : $markup;break;
        case 'discount' : $discount = ($value != "") ? $value : $discount;break;
        }
    }
	$journey_date = get_datetime_db($journey_date);
	$payment_date = get_date_db($payment_date);
	$balance_date = get_date_db($balance_date1);
    if($payment_mode=="Cheque"||$payment_mode=="Credit Card"){ 
        $clearance_status = "Pending"; } 
    else {  $clearance_status = ""; }

	//**Starting Transaction 

	begin_t();

    //Get Customer id
    if($customer_id == '0'){
        $sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
        $customer_id = $sq_max['max'];
    }
    
	//**Saving Booking

	$sq_max = mysql_fetch_assoc(mysql_query("select max(booking_id) as max from bus_booking_master"));

	$booking_id = $sq_max['max'] + 1;

    $reflections = json_encode($reflections);

    $bsmValues = json_encode($bsmValues);
	$sq_booking = mysql_query("insert into bus_booking_master (booking_id, customer_id, branch_admin_id,financial_year_id, basic_cost, service_charge, taxation_type, taxation_id, service_tax, service_tax_subtotal,markup,markup_tax, net_total, created_at, emp_id,reflections,bsm_values,roundoff) values ('$booking_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$basic_cost', '$service_charge', '$taxation_type', '$taxation_id', '$service_tax', '$service_tax_subtotal', '$markup','$service_tax_markup', '$net_total', '$balance_date', '$emp_id','$reflections','$bsmValues','$roundoff')");

	if(!$sq_booking){

		$GLOBALS['flag'] = false;

		echo "error--Booking not saved!";

	}



    //**Booking Entries
    for($i=0; $i<sizeof($company_name_arr); $i++){

        $date_of_journey_arr[$i] = get_datetime_db($date_of_journey_arr[$i]);
        $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from bus_booking_entries"));
        $entry_id = $sq_max['max'] + 1;

        $sq_entry = mysql_query("insert into bus_booking_entries(entry_id, booking_id, company_name, seat_type,bus_type, pnr_no, origin, destination, date_of_journey, reporting_time, boarding_point_access) values ('$entry_id', '$booking_id', '$company_name_arr[$i]', '$bus_type_arr[$i]','$bus_type_new_arr[$i]', '$pnr_no_arr[$i]', '$origin_arr[$i]', '$destination_arr[$i]', '$date_of_journey_arr[$i]', '$reporting_time_arr[$i]', '$boarding_point_access_arr[$i]')");

        if(!$sq_entry){
            $GLOBALS['flag'] = false;
            echo "error--Some entries not saved!";
        }
    }



	//**Saving Payment
	$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from bus_booking_payment_master"));
    $payment_id = $sq_max['max'] + 1;

    $sq_payment = mysql_query("insert into bus_booking_payment_master (payment_id, booking_id, financial_year_id, branch_admin_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$booking_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");

    if(!$sq_payment){

        $GLOBALS['flag'] = false;

        echo "error--Sorry, Payment not saved!";

    }
    
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


    //Get Particular
    $particular = $this->get_particular($customer_id,$pnr_no_arr[0], $origin_arr[0], $destination_arr[0],$date_of_journey_arr[0]);

    //Finance save

    $this->finance_save($booking_id, $payment_id, $row_spec, $branch_admin_id,$particular);



    //Bank and Cash Book Save
    if($payment_mode != 'Credit Note'){
    $this->bank_cash_book_save($booking_id, $payment_id, $branch_admin_id);
    }


    //**Ending Transaction

    if($GLOBALS['flag']){

        commit_t();
        $this->booking_mail($booking_id, $customer_id, $payment_amount);
        $this->booking_sms($booking_id, $customer_id, $balance_date);

        // payment email send
        $payment_master  = new payment_master;
        $payment_master->payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date);

        // payment sms send
        if($payment_amount != 0){
            $payment_master->payment_sms_notification_send($booking_id, $payment_amount, $payment_mode);
        }

        echo "Bus Booking has been successfully saved.";
        exit;
    }
    else{
        rollback_t();
        exit;
    }
}

function get_particular($customer_id,$pnr_no,$source,$dest,$date_of_journey){

    $sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
    $cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];

    return 'Towards the Bus Seat booking of '.$cust_name.' for '.$source.'-'.$dest.' PNR No '.$pnr_no.' Dt.'.get_datetime_user($date_of_journey);
}
public function booking_sms($booking_id, $customer_id, $created_at){

    global $model, $app_name,$encrypt_decrypt,$secret_key,$app_contact_no;
    $sq_customer_info = mysql_fetch_assoc(mysql_query("select contact_no,first_name,last_name from customer_master where customer_id='$customer_id'"));
    $mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
    
    $date = $created_at;
    $yr = explode("-", $date);
	$yr1 =$yr[0];
	
    $message = " Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", your Bus booking is confirmed. Seat details will send you shortly. Please contact for more details ".$app_contact_no.".";
    $model->send_message($mobile_no, $message);  
}


public function booking_mail($booking_id, $customer_id, $payment_amount)

{
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$currency_logo;
    global $app_name,$encrypt_decrypt,$secret_key;

    $sq_visa = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
    $date = $sq_visa['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];

    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

    $email_id = $sq_customer['email_id'];
    $email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);

    $customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
    $password= $email_id;
    $username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);

    $link = BASE_URL.'view/customer';

    $subject = 'Booking confirmation acknowledgement! ( '.get_bus_booking_id($booking_id,$year). ' )';

    

    $busDetails = mysql_query('SELECT * FROM `bus_booking_entries` WHERE booking_id = '.$booking_id);
	$remaining_cost = $sq_visa['net_total'] - $payment_amount;
    $content = '<tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Concern Person</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$customer_name.'</td></tr>
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '. number_format($sq_visa[net_total],2).'</td></tr>
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($payment_amount,2).'</td></tr> 
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($remaining_cost,2).'</td></tr>
		</table>
	  </tr>
	';

	while($rows = mysql_fetch_assoc($busDetails)){
		$content .= '<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
		  <tr><th colspan=2>Bus Details</th></tr>
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Bus</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $rows[company_name].'</td></tr>
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Seat Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows[seat_type].'</td></tr> 
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">PNR Number</td>   <td style="text-align:left;border: 1px solid #888888;">'.$rows[pnr_no].'</td></tr>
		</table>
	  </tr>';
	}




    $content .= mail_login_box($username, $password, $link);


    global $model,$backoffice_email_id;
    $model->app_email_send('19',$sq_customer['first_name'],$email_id, $content, $subject);
    if($backoffice_mail_id != "")
    $model->app_email_send('19',"Team",$backoffice_email_id, $content, $subject);
}


public function finance_save($booking_id, $payment_id, $row_spec, $branch_admin_id,$particular){
    $customer_id = $_POST['customer_id'];
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
	$payment_date = $_POST['payment_date'];
	$payment_amount1 = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id1 = $_POST['transaction_id'];	
	$bank_id1 = $_POST['bank_id'];	
    $booking_date = $_POST['balance_date'];
    $credit_charges = $_POST['credit_charges'];
    $credit_card_details = $_POST['credit_card_details'];

    $roundoff = $_POST['roundoff'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $service_tax_markup = $_POST['service_tax_markup'];
    $markup = $_POST['markup'];
    $booking_date = date('Y-m-d', strtotime($booking_date));
	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
	$year2 = explode("-", $payment_date1);
	$yr2 =$year2[0];

    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
        case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
        case 'markup' : $markup = ($value != "") ? $value : $markup;break;
        case 'discount' : $discount = ($value != "") ? $value : $discount;break;
        }
      }

    $bus_sale_amount = $basic_cost;
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

    global $transaction_master,$fiance_vars;

    ////////////Sales/////////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $bus_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $gl_id = 10;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Service Charge////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 190;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $customer_amount = $basic_cost+$service_charge+$markup;
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Bus Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Bus Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    }

    ///////////Markup//////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $markup;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $gl_id = ($reflections[0]->hotel_markup != '') ? $reflections[0]->hotel_markup : 202;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Markup Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_markup = explode(',',$service_tax_markup);
    $tax_ledgers = explode(',',$reflections[0]->hotel_markup_taxes);
    for($i=0;$i<sizeof($service_tax_markup);$i++){

      $service_tax = explode(':',$service_tax_markup[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Bus Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Bus Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'1', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    }
    
    ////Roundoff Value
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    
    ////////Customer Amount//////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $net_total;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	//////////Payment Amount///////////
	if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Bus Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
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
			$payment_date = $payment_date1;
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
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
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
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
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
			$payment_date = $payment_date1;
			$payment_particular = $particular;
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
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_bus_booking_id($booking_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
}



public function bank_cash_book_save($booking_id, $payment_id, $branch_admin_id)
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

    if($payment_mode == 'Credit Card'){
        $payment_amount = $payment_amount + $credit_charges;
        $credit_card_details = explode('-',$credit_card_details);
        $entry_id = $credit_card_details[0];
        $sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
        $bank_id = $sq_credit_charges['bank_id'];
    }

	$payment_date1 = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date1);
	$yr1 =$year1[0];

	$booking_date = date('Y-m-d', strtotime($booking_date));
	$year2 = explode("-", $booking_date);
	$yr2 =$year2[0];

    //Get Customer id
    if($customer_id == '0'){
      $sq_max = mysql_fetch_assoc(mysql_query("select max(customer_id) as max from customer_master"));
      $customer_id = $sq_max['max'];
    }

	$module_name = "Bus Booking";

	$module_entry_id = $payment_id;

	$payment_date = $payment_date;

	$payment_amount = $payment_amount;

	$payment_mode = $payment_mode;

	$bank_name = $bank_name;

	$transaction_id = $transaction_id;

	$bank_id = $bank_id;

	$particular = get_sales_paid_particular(get_bus_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_bus_booking_id($booking_id,$yr2),$bank_id,$transaction_id);

	$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";

	$payment_side = "Debit";

	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);

}



public function booking_update()

{

    $row_spec = 'sales';
	$booking_id = $_POST['booking_id'];
	$customer_id = $_POST['customer_id'];
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
    $balance_date1 = $_POST['balance_date1'];
    $balance_date1 = get_date_db($balance_date1);
    $company_name_arr = $_POST['company_name_arr'];
    $bus_type_arr = $_POST['bus_type_arr'];
    $bus_type_new_arr = $_POST['bus_type_new_arr'];
    $pnr_no_arr = $_POST['pnr_no_arr'];
    $origin_arr = $_POST['origin_arr'];
    $destination_arr = $_POST['destination_arr'];
    $date_of_journey_arr = $_POST['date_of_journey_arr'];
    $reporting_time_arr = $_POST['reporting_time_arr'];
    $boarding_point_access_arr = $_POST['boarding_point_access_arr'];
    $entry_id_arr = $_POST['entry_id_arr'];
    
    $service_tax_markup = $_POST['service_tax_markup'];
    $markup = $_POST['markup'];
    $roundoff = $_POST['roundoff'];
    
    $reflections = json_decode(json_encode($_POST['reflections']));
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
  foreach($bsmValues[0] as $key => $value){
      switch($key){
      case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
      case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
      case 'markup' : $markup = ($value != "") ? $value : $markup;break;
      case 'discount' : $discount = ($value != "") ? $value : $discount;break;
      }
    }
	//**Starting Transaction 
	begin_t();

	$sq_booking_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
    $reflections = json_encode($reflections);
    $bsmValues = json_encode($bsmValues);
	//**Saving Booking
	$sq_booking = mysql_query("update bus_booking_master set customer_id='$customer_id', basic_cost='$basic_cost', service_charge='$service_charge', taxation_type='$taxation_type', taxation_id='$taxation_id', service_tax='$service_tax', service_tax_subtotal='$service_tax_subtotal',markup='$markup', net_total='$net_total',created_at='$balance_date1',reflections='$reflections',markup_tax='$service_tax_markup',bsm_values='$bsmValues',roundoff='$roundoff'  where booking_id='$booking_id'");

	if(!$sq_booking){

		$GLOBALS['flag'] = false;

		echo "error--Booking not updated!";

	}



    //**Booking Entries

    for($i=0; $i<sizeof($company_name_arr); $i++){



        $date_of_journey_arr[$i] = get_datetime_db($date_of_journey_arr[$i]);

        if($entry_id_arr[$i] == ""){



            $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from bus_booking_entries"));

            $entry_id = $sq_max['max'] + 1;    



            $sq_entry = mysql_query("insert into bus_booking_entries(entry_id, booking_id, company_name,seat_type, bus_type, pnr_no, origin, destination, date_of_journey, reporting_time, boarding_point_access) values ('$entry_id', '$booking_id', '$company_name_arr[$i]', '$bus_type_arr[$i]','$bus_type_new_arr[$i]', '$pnr_no_arr[$i]', '$origin_arr[$i]', '$destination_arr[$i]', '$date_of_journey_arr[$i]', '$reporting_time_arr[$i]', '$boarding_point_access_arr[$i]')");

            if(!$sq_entry){

                $GLOBALS['flag'] = false;

                echo "error--Some entries not saved!";

            }    



        }

        else{



            $sq_entry = mysql_query("update bus_booking_entries set company_name='$company_name_arr[$i]', seat_type='$bus_type_arr[$i]',bus_type ='$bus_type_new_arr[$i]', pnr_no='$pnr_no_arr[$i]', origin='$origin_arr[$i]', destination='$destination_arr[$i]', date_of_journey='$date_of_journey_arr[$i]', reporting_time='$reporting_time_arr[$i]', boarding_point_access='$boarding_point_access_arr[$i]' where entry_id='$entry_id_arr[$i]'");

            if(!$sq_entry){

                $GLOBALS['flag'] = false;

                echo "error--Some entries not updated!";

            }



        }



        

    }


    //Get Particular
    $particular = $this->get_particular($customer_id,$pnr_no_arr[0], $origin_arr[0], $destination_arr[0],$date_of_journey_arr[0]);

	//Finance update

	$this->finance_update($sq_booking_info, $row_spec,$particular);



    //**Ending Transaction

    if($GLOBALS['flag']){

        commit_t();

        echo "Bus Booking has been successfully updated.";

        exit;

    }

    else{

        rollback_t();

        exit;

    }





}



public function finance_update($sq_booking_info, $row_spec, $particular)
{

	$booking_id = $_POST['booking_id'];
	$customer_id = $_POST['customer_id'];
	$basic_cost = $_POST['basic_cost'];
	$service_charge = $_POST['service_charge'];
    $taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
    $reflections = json_decode(json_encode($_POST['reflections']));
    $service_tax_markup = $_POST['service_tax_markup'];
    $markup = $_POST['markup'];
    $created_at = $_POST['balance_date1'];
    $booking_date = get_date_db($created_at);
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
    $roundoff = $_POST['roundoff'];
    $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $basic_cost = ($value != "") ? $value : $basic_cost;break;
        case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
        case 'markup' : $markup = ($value != "") ? $value : $markup;break;
        case 'discount' : $discount = ($value != "") ? $value : $discount;break;
        }
      }
	global $transaction_master;

    $bus_sale_amount = $basic_cost ;
    //get total payment against bus id
    $sq_bus = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from bus_booking_payment_master where booking_id='$booking_id'"));
    $balance_amount = $net_total - $sq_bus['payment_amount'];

    //Getting customer Ledger
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust['ledger_id'];

    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; }
    else{ 
        $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
        $pay_gl = $sq_bank['ledger_id'];
     } 

    global $transaction_master;

    ////////////Sales/////////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $bus_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id = $gl_id = 10;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  
    ////////////service charge/////////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id =$gl_id= ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 190;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id = $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
    }

    ////////////markup/////////////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $markup;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id = $gl_id = ($reflections[0]->hotel_markup != '') ? $reflections[0]->hotel_markup : 202;
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

        $module_name = "Bus Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $tax_amount;
        $payment_date = $booking_date;
        $payment_particular = $particular;
        $ledger_particular = get_ledger_particular('To','Bus Sales');
        $old_gl_id = $gl_id = $ledger;
        $payment_side = "Credit";
        $clearance_status = "";
        $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'1', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
    }
    
    /////////roundoff/////////
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id = $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
    ////////Customer Amount//////
    $module_name = "Bus Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $net_total;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Bus Sales');
    $old_gl_id = $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

}
function employee_sign_up_mail($cust_first_name, $cust_last_name, $username, $password, $email_id)
{
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   $link = BASE_URL.'view/customer';
  $content = '
  <tr>
    <td colspan="2">
      <table style="padding:0 30px">
      
        <tr>
          <td colspan="2">
            '.mail_login_box($username, $password, $link).'
          </td>
        </tr>
      </table>  
      </td>
    </tr>
  ';
  $subject ='Welcome aboard!';
  global $model;
 
  $model->app_email_send('2',$cust_first_name,$email_id, $content,$subject,'1');
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