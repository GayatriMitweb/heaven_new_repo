<?php
$flag = true;
class exc_master{
public function exc_master_save(){
	$row_spec = 'sales';	
	$customer_id = $_POST['customer_id'];
	$emp_id = $_POST['emp_id'];
	$exc_issue_amount = $_POST['exc_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$exc_total_cost = $_POST['exc_total_cost'];
	$branch_admin_id = $_POST['branch_admin_id'];
	$due_date = $_POST['due_date'];
	$balance_date = $_POST['balance_date'];
	$payment_date = $_POST['payment_date'];
	$payment_amount = $_POST['payment_amount'];
	$payment_mode = $_POST['payment_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$exc_date_arr = $_POST['exc_date_arr'];
	$city_id_arr = $_POST['city_id_arr'];
	$exc_name_arr = $_POST['exc_name_arr'];
	$transfer_arr = $_POST['transfer_arr'];
	$total_adult_arr = $_POST['total_adult_arr'];
	$total_child_arr = $_POST['total_child_arr'];
	$adult_cost_arr = $_POST['adult_cost_arr'];
	$child_cost_arr = $_POST['child_cost_arr'];
	$total_amt_arr = $_POST['total_amt_arr'];
	$roundoff = $_POST['roundoff'];
	$total_amt_arr = $_POST['total_amt_arr'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$markup = $_POST['markup'];

	$service_tax_markup = $_POST['service_tax_markup'];
	$reflections = json_decode(json_encode($_POST['reflections']));
	$total_adults=0;
	$total_childs=0;
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$balance_date = date("Y-m-d", strtotime($balance_date));
	$due_date = date("Y-m-d", strtotime($due_date));
	if($payment_mode=="Cheque" || $payment_mode == "Credit Card"){ 
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
			case 'basic' : $exc_issue_amount = ($value != "") ? $value : $exc_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}
	//Activity
	$sq_max = mysql_fetch_assoc(mysql_query("select max(exc_id) as max from excursion_master"));
	$exc_id = $sq_max['max'] + 1;
	$reflections = json_encode($reflections);
	$bsmValues = json_encode($bsmValues);
	$sq_exc = mysql_query("INSERT into excursion_master (exc_id, customer_id, branch_admin_id,financial_year_id, exc_issue_amount, service_charge, service_tax_subtotal, exc_total_cost, created_at, markup, service_tax_markup, reflections, due_date,emp_id , bsm_values , roundoff) values ('$exc_id', '$customer_id', '$branch_admin_id','$financial_year_id', '$exc_issue_amount', '$service_charge','$service_tax_subtotal', '$exc_total_cost', '$balance_date', '$markup','$service_tax_markup','$reflections','$due_date', '$emp_id' , '$bsmValues', '$roundoff')");

	if(!$sq_exc){
		rollback_t();
		echo "error--Sorry Activity information not saved successfully!";
		exit;
	}
	else{

		for($i=0; $i<sizeof($exc_date_arr); $i++){
			$total_adults=$total_adults +$total_adult_arr[$i];
			$total_childs = $total_childs + $total_child_arr[$i];
			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_entries"));
			$entry_id = $sq_max['max'] + 1;

			$exc_date_arr[$i] = get_datetime_db($exc_date_arr[$i]);

			$sq_entry = mysql_query("insert into excursion_master_entries(entry_id, exc_id, exc_date, city_id, exc_name,transfer_option, total_adult, total_child, adult_cost, child_cost, total_cost, status) values('$entry_id', '$exc_id', '$exc_date_arr[$i]','$city_id_arr[$i]', '$exc_name_arr[$i]','$transfer_arr[$i]', '$total_adult_arr[$i]', '$total_child_arr[$i]', '$adult_cost_arr[$i]', '$child_cost_arr[$i]', '$total_amt_arr[$i]', '')");

			if(!$sq_entry){
				$GLOBALS['flag'] = false;
				echo "error--Some Activity entries are not saved!";
			}

		}

		$sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from exc_payment_master"));
		$payment_id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into exc_payment_master (payment_id, exc_id, financial_year_id, branch_admin_id, payment_date, payment_amount, payment_mode, bank_name, transaction_id, bank_id, clearance_status,credit_charges,credit_card_details) values ('$payment_id', '$exc_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_amount', '$payment_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");

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
		$particular = $this->get_particular($customer_id,$exc_name_arr[0],$total_adults,$total_childs,$exc_date_arr[0]);

		//Finance save
    	$this->finance_save($exc_id, $payment_id,$row_spec, $branch_admin_id,$particular);

    	//Bank and Cash Book Save
    	$this->bank_cash_book_save($exc_id, $payment_id, $branch_admin_id);

   
		if($GLOBALS['flag']){

			commit_t();
			//exc Booking email send
			$this->exc_booking_email_send($exc_id, $payment_amount);
			$this->booking_sms($exc_id, $customer_id, $balance_date);
			//exc payment email send
			$exc_payment_master  = new exc_payment_master;
			if($payment_amount != 0){
				$exc_payment_master->payment_email_notification_send($exc_id, $payment_amount, $payment_mode, $payment_date);			

				//exc payment sms send
				$exc_payment_master->payment_sms_notification_send($exc_id, $payment_amount, $payment_mode);
			}
			echo "Activity Booking has been successfully saved.";
			exit;
		}
		else{
			echo "Activity Booking has not been saved.";
			rollback_t();
			exit;
		}
	}
}

public function finance_save($exc_id, $payment_id, $row_spec, $branch_admin_id,$particular)
{

  $customer_id = $_POST['customer_id'];
	$exc_issue_amount = $_POST['exc_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$exc_total_cost = $_POST['exc_total_cost'];
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
	$yr1 =$year1[0];
	$year2 = explode("-", $payment_date1);
	$yr2 =$year2[0];
	$created_at = date("Y-m-d");
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $exc_issue_amount = ($value != "") ? $value : $exc_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}
	$excursion_sale_amount = $exc_issue_amount;
	$payment_amount1 = $payment_amount1 + $credit_charges;
	$balance_amount = $exc_total_cost - $payment_amount1;

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

    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $excursion_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
    $gl_id = 44;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	
	/////////Service Charge////////
    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Excursion Sales');
    $gl_id = ($reflections[0]->act_sc != '') ? $reflections[0]->act_sc : 192;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	/////////Service Charge Tax Amount////////
    $customer_amount = $exc_issue_amount+$service_charge+$markup;
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->act_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Excursion Booking";
      $module_entry_id = $exc_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Excursion Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}
	
	///////////Markup//////////
    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $markup;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Excursion Sales');
    $gl_id = ($reflections[0]->act_markup != '') ? $reflections[0]->act_markup : 204;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Markup Tax Amount////////
    $service_tax_markup = explode(',',$service_tax_markup);
    $tax_ledgers = explode(',',$reflections[0]->act_markup_taxes);
    for($i=0;$i<sizeof($service_tax_markup);$i++){

      $service_tax = explode(':',$service_tax_markup[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Excursion Booking";
      $module_entry_id = $exc_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Excursion Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'1', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
	}
	////Roundoff Value
    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Excursion Sales');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    

	////////Customer Amount//////
    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $exc_total_cost; ////////////////////////////////////////////
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Excursion Sales');
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

	if($payment_mode != 'Credit Note'){

		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Excursion Booking";
			$module_entry_id = $exc_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_exc_booking_id($exc_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Excursion Booking";
			$module_entry_id = $exc_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_exc_booking_id($exc_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id1,$transaction_id1);
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
			$module_name = "Excursion Booking";
			$module_entry_id = $exc_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_exc_booking_id($exc_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Excursion Booking";
			$module_entry_id = $exc_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date1;
			$payment_particular = get_sales_paid_particular(get_exc_booking_id($exc_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id1,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{

			$module_name = "Excursion Booking";
			$module_entry_id = $exc_id;
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
		$module_name = "Excursion Booking";
		$module_entry_id = $exc_id;
		$transaction_id = $transaction_id1;
		$payment_amount = $payment_amount1;
		$payment_date = $payment_date1;
		$payment_particular = get_sales_paid_particular(get_exc_booking_id($exc_id,$yr1), $payment_date1, $payment_amount1, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id1,$transaction_id1);
		$ledger_particular = get_ledger_particular('By','Cash/Bank');
		$gl_id = $cust_gl;
		$payment_side = "Credit";
		$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
		$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
	}
}



public function bank_cash_book_save($exc_id, $payment_id, $branch_admin_id)

{

	global $bank_cash_book_master;
	$customer_id = $_POST['customer_id'];

	$payment_date = $_POST['payment_date'];

	$payment_amount = $_POST['payment_amount'];

	$payment_mode = $_POST['payment_mode'];

	$bank_name = $_POST['bank_name'];

	$transaction_id = $_POST['transaction_id'];	
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	$bank_id = $_POST['bank_id'];
	$payment_date = date('Y-m-d', strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	if($payment_mode == 'Credit Card')
	{
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

	$module_name = "Excursion Booking";

	$module_entry_id = $payment_id;

	$payment_date = $payment_date;

	$payment_amount = $payment_amount;

	$payment_mode = $payment_mode;

	$bank_name = $bank_name;

	$transaction_id = $transaction_id;

	$bank_id = $bank_id;

	$particular = get_sales_paid_particular(get_exc_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_exc_booking_id($exc_id,$yr1),$bank_id,$transaction_id);

	$clearance_status = ($payment_mode=="Cheque" ||$payment_mode=="Credit Card") ? "Pending" : "";

	$payment_side = "Debit";

	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";



	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);

}



function get_particular($customer_id,$exc_name,$total_adults,$total_childs,$exc_date){

	$sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
	$sq_t = mysql_fetch_assoc(mysql_query("select excursion_name from excursion_master_tariff where entry_id='$exc_name'"));
	$service_name = $sq_t['excursion_name'];
  
	return 'Towards the '.$service_name.' for '.$cust_name.' * '.($total_adults+$total_childs).' on Dt.'.get_date_user($exc_date);
}



public function exc_master_update()
{
	$row_spec = "sales";	
	$exc_id = $_POST['exc_id'];
	$customer_id = $_POST['customer_id'];
	$exc_issue_amount = $_POST['exc_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$exc_total_cost = $_POST['exc_total_cost'];
	$due_date1 = $_POST['due_date1'];
	$balance_date1 = $_POST['balance_date'];
	$exc_check_arr = $_POST['exc_check_arr'];
	$exc_date_arr = $_POST['exc_date_arr'];
	$city_id_arr = $_POST['city_id_arr'];
	$exc_name_arr = $_POST['exc_name_arr'];
	$total_adult_arr = $_POST['total_adult_arr'];
	$total_child_arr = $_POST['total_child_arr'];
	$adult_cost_arr = $_POST['adult_cost_arr'];
	$child_cost_arr = $_POST['child_cost_arr'];
	$total_amt_arr = $_POST['total_amt_arr'];
	$entry_id_arr = $_POST['entry_id_arr'];
	$transfer_option_arr = $_POST['transfer_option_arr'];
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	$roundoff = $_POST['roundoff'];
	$total_adults=0;
	$total_childs=0;
	$reflections = json_decode(json_encode($_POST['reflections']));
	
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));

	$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$exc_id'"));

	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $exc_issue_amount = ($value != "") ? $value : $exc_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}

	begin_t();

	$reflections = json_encode($reflections);
	$bsmValues = json_encode($bsmValues);
	$due_date1 = get_date_db($due_date1);
	$balance_date1 = get_date_db($balance_date1);

	$sq_exc = mysql_query("UPDATE excursion_master set customer_id='$customer_id', exc_issue_amount='$exc_issue_amount', service_charge='$service_charge',service_tax_subtotal='$service_tax_subtotal', exc_total_cost='$exc_total_cost', due_date='$due_date1',created_at='$balance_date1',markup='$markup',service_tax_markup='$service_tax_markup',reflections='$reflections',roundoff='$roundoff' , bsm_values='$bsmValues' where exc_id='$exc_id' ");

	if(!$sq_exc){

		rollback_t();

		echo "error--Sorry, Activity information not update successfully!";

		exit;

	}

	else{		

		for($i=0; $i<sizeof($exc_date_arr); $i++){
			if($exc_check_arr[$i] != 'true'){
				$sq_exc = mysql_query("delete from excursion_master_entries where entry_id='$entry_id_arr[$i]'");
				if(!$sq_exc){
					echo "error--Activity information not deleted!";
					exit;
				}
			}
			else{
				$exc_date_arr[$i] = get_datetime_db($exc_date_arr[$i]);
				if($entry_id_arr[$i]==""){
					$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from excursion_master_entries"));
					$entry_id = $sq_max['max'] + 1;

					$sq_entry = mysql_query("insert into excursion_master_entries(entry_id, exc_id, exc_date, city_id, exc_name,transfer_option, total_adult, total_child, adult_cost, child_cost, total_cost, status) values('$entry_id', '$exc_id','$exc_date_arr[$i]','$city_id_arr[$i]', '$exc_name_arr[$i]', '$transfer_option_arr[$i]','$total_adult_arr[$i]', '$total_child_arr[$i]', '$adult_cost_arr[$i]', '$child_cost_arr[$i]', '$total_amt_arr[$i]', '')");
					if(!$sq_entry){

						$GLOBALS['flag'] = false;
						echo "error--Some Activity entries are not saved!";
						//exit;
					}
				}
				else{
					$sq_entry = mysql_query("update excursion_master_entries set exc_date='$exc_date_arr[$i]', city_id='$city_id_arr[$i]', exc_name='$exc_name_arr[$i]', transfer_option='$transfer_option_arr[$i]',total_adult='$total_adult_arr[$i]', total_child='$total_child_arr[$i]', adult_cost='$adult_cost_arr[$i]', child_cost='$child_cost_arr[$i]', total_cost='$total_amt_arr[$i]' where entry_id='$entry_id_arr[$i]'");

					if(!$sq_entry){
						$GLOBALS['flag'] = false;
						echo "error--Some Activity entries are not updated!";
						//exit;
					}	
				}
			}
		}

		//Get Particular
		$particular = $this->get_particular($customer_id,$exc_name_arr[0],$total_adults,$total_childs,$exc_date_arr[0]);

		//Finance update
		$this->finance_update($sq_exc_info,$row_spec,$particular);

		if($GLOBALS['flag']){
			commit_t();
			echo "Activity Booking has been successfully updated.";
			exit;	
		}
		else{
			rollback_t();
			exit;
		}		
	}
}

public function finance_update($sq_exc_info, $row_spec,$particular)
{
	$exc_id = $_POST['exc_id'];
	$customer_id = $_POST['customer_id'];
	$exc_issue_amount = $_POST['exc_issue_amount'];
	$service_charge = $_POST['service_charge'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$exc_total_cost = $_POST['exc_total_cost'];
	$roundoff = $_POST['roundoff'];
	$balance_date1 = $_POST['balance_date'];
	$created_at = date('Y-m-d',strtotime($balance_date1));
	$year1 = explode("-", $created_at);
	$yr1 =$year1[0];

	$reflections = json_decode(json_encode($_POST['reflections']));
	$markup = $_POST['markup'];
	$service_tax_markup = $_POST['service_tax_markup'];
	
	global $transaction_master;
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
			case 'basic' : $exc_issue_amount = ($value != "") ? $value : $exc_issue_amount;break;
			case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
			case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		}
	}
    $exc_sale_amount = $exc_issue_amount;
    //get total payment against Activity Id
    $sq_excursion = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from exc_payment_master where exc_id='$exc_id'"));
	$balance_amount = $exc_total_cost - $sq_excursion['payment_amount'];

    //Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];


    ////////////Sales/////////////
    $module_name = "Excursion Booking";
    $module_entry_id = $exc_id;
    $transaction_id = "";
    $payment_amount = $exc_sale_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
    $old_gl_id = $gl_id = 44;
    $payment_side = "Credit";
    $clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	
	////////////service charge/////////////
	$module_name = "Excursion Booking";
	$module_entry_id = $exc_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
	$old_gl_id = $gl_id = ($reflections[0]->act_sc != '') ? $reflections[0]->act_sc : 192;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

	/////////Service Charge Tax Amount////////
	$service_tax_subtotal = explode(',',$service_tax_subtotal);
	$tax_ledgers = explode(',',$reflections[0]->act_taxes);
	for($i=0;$i<sizeof($service_tax_subtotal);$i++){
  
	  $service_tax = explode(':',$service_tax_subtotal[$i]);
	  $tax_amount = $service_tax[2];
	  $ledger = $tax_ledgers[$i];
  
	  $module_name = "Excursion Booking";
	  $module_entry_id = $exc_id;
	  $transaction_id = "";
	  $payment_amount = $tax_amount;
	  $payment_date = $created_at;
	  $payment_particular = $particular;
	  $ledger_particular = get_ledger_particular('To','Excursion Sales');
	  $old_gl_id = $gl_id = $ledger;
	  $payment_side = "Credit";
	  $clearance_status = "";
	  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	}

	////////////markup/////////////
	$module_name = "Excursion Booking";
	$module_entry_id = $exc_id;
	$transaction_id = "";
	$payment_amount = $markup;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
	$old_gl_id = $gl_id = ($reflections[0]->act_markup != '') ? $reflections[0]->act_markup : 204;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  
	/////////Markup Tax Amount////////
	// Eg. CGST:(9%):24.77, SGST:(9%):24.77
	$service_tax_markup = explode(',',$service_tax_markup);
	$tax_ledgers = explode(',',$reflections[0]->act_markup_taxes);
	for($i=0;$i<sizeof($service_tax_markup);$i++){
  
	  $service_tax = explode(':',$service_tax_markup[$i]);
	  $tax_amount = $service_tax[2];
	  $ledger = $tax_ledgers[$i];
  
	  $module_name = "Excursion Booking";
	  $module_entry_id = $exc_id;
	  $transaction_id = "";
	  $payment_amount = $tax_amount;
	  $payment_date = $created_at;
	  $payment_particular = $particular;
	  $ledger_particular = get_ledger_particular('To','Excursion Sales');
	  $old_gl_id = $gl_id = $ledger;
	  $payment_side = "Credit";
	  $clearance_status = "";
	  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'1', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	}

	/////////roundoff/////////
	$module_name = "Excursion Booking";
	$module_entry_id = $exc_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
	$old_gl_id = $gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  

	////////Customer Amount//////
	$module_name = "Excursion Booking";
	$module_entry_id = $exc_id;
	$transaction_id = "";
	$payment_amount = $exc_total_cost;
	$payment_date = $created_at;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Excursion Sales');
	$old_gl_id = $gl_id = $cust_gl;
	$payment_side = "Debit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

}



public function exc_booking_email_send($exc_id, $payment_amount)

{
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
	global $app_name,$secret_key,$encrypt_decrypt;
	$link = BASE_URL.'view/customer';

	$sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$exc_id'"));
	$date = $sq_exc['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc[customer_id]'"));
	$subject = 'Booking confirmation acknowledgement! ( '.get_exc_booking_id($exc_id,$year). ' )';
	
	$password = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$username = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key); 
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);;
	$customer_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
	
	$excDetails = mysql_query('SELECT * FROM `excursion_master_entries` WHERE exc_id = '.$exc_id);
	$remaining_cost = $sq_exc['exc_total_cost'] - $payment_amount;
	

	$content = '<tr>
	<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Concern Person</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $customer_name.'</td></tr>
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'. $sq_exc[exc_total_cost].'</td></tr>
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$payment_amount.'</td></tr> 
	<tr><td style="text-align:left;border: 1px solid #888888;width:50%">Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$remaining_cost.'</td></tr>
		</table>
	  </tr>
	';

	while($rows = mysql_fetch_assoc($excDetails)){
		$exctypeDetails = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id = ".$rows['exc_name']));
		$content .= '<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
		  <tr><th colspan=2>Activity Details</th></tr>
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Activity Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$exctypeDetails[excursion_name].'</td></tr> 
		  <tr><td style="text-align:left;border: 1px solid #888888;width:50%">Date/Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_datetime_user($rows[exc_date]).'</td></tr>
		</table>
	  </tr>';
	}
	$content .= mail_login_box($username, $password, $link);

	global $model,$backoffice_email_id;
	$model->app_email_send('94',$sq_customer['first_name'],$email_id, $content,$subject);
	$model->app_email_send('94',"Team",$backoffice_email_id, $content, $subject);

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

public function booking_sms($booking_id, $customer_id, $created_at){

    global $model, $app_name,$secret_key,$encrypt_decrypt,$app_contact_no;
	$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$mobile_no = $encrypt_decrypt->fnDecrypt($sq_customer_info['contact_no'], $secret_key);
   
    
    $date = $created_at;
    $yr = explode("-", $date);
	$yr1 =$yr[0];
	
	$message = "Dear ".$sq_customer_info['first_name']." ".$sq_customer_info['last_name'].", your excursion booking is confirmed. Voucher details will send you shortly. Please contact for more details ".$app_contact_no."";
	
    $model->send_message($mobile_no, $message);  
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