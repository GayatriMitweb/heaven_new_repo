<?php 
$flag = true;

class payment{
///////////////////////////////////***** Package Tour payment master save start *********/////////////////////////////////////////////////////////////
 public function package_tour_payment_master_save()
 {
      $booking_id = $_POST['booking_id'];
      $payment_date = $_POST['payment_date'];
      $payment_mode = $_POST['payment_mode'];
      $payment_amount = $_POST['payment_amount'];
      $bank_name = $_POST['bank_name'];
      $transaction_id = $_POST['transaction_id'];
      $payment_for = $_POST['payment_for'];
      $p_travel_type = $_POST['p_travel_type'];
      $bank_id = $_POST['bank_id'];
      $emp_id = $_POST['emp_id'];
      $branch_admin_id = $_POST['branch_admin_id'];
      $credit_charges = $_POST['credit_charges'];
      $credit_card_details = $_POST['credit_card_details'];
      $payment_date = date("Y-m-d", strtotime($payment_date));
      $clearance_status = ($payment_mode=="Cheque" || $payment_mode=="Credit Card") ? "Pending" : "";
      $financial_year_id = $_SESSION['financial_year_id'];
      
      begin_t();

      $sq = mysql_query("SELECT max(payment_id) as max FROM package_payment_master");
      $value = mysql_fetch_assoc($sq);
      $max_payment_id = $value['max'] + 1;

      $sq= mysql_query(" insert into package_payment_master (payment_id, booking_id, financial_year_id, branch_admin_id, emp_id, date, payment_mode, amount, bank_name, transaction_id, payment_for, travel_type, bank_id, clearance_status,credit_charges,credit_card_details ) values ('$max_payment_id', '$booking_id', '$financial_year_id', '$branch_admin_id', '$emp_id', '$payment_date', '$payment_mode', '$payment_amount', '$bank_name', '$transaction_id', '$payment_for', '$p_travel_type', '$bank_id', '$clearance_status','$credit_charges','$credit_card_details') ");

     
      if(!$sq)
	    {
        rollback_t();
	      echo "Error for payment information save.";
	      exit;
	    }
	    else
	    {	 
	       $booking_save = new booking_save();
	       $booking_save->package_receipt_master_save( $booking_id, $max_payment_id, $payment_for);

         //Finance Save
         $this->payment_finance_save($max_payment_id); 

         //Bank and Cash Book Save
         if($payment_mode != 'Credit Note'){
         $this->bank_cash_book_save($max_payment_id);
         }
   
         if($GLOBALS['flag']){
           commit_t();
           

           //Payment email notification
           $this->payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date);
     
           //Payment sms notification send
           $sq_c = mysql_fetch_assoc(mysql_query("SELECT customer_id FROM package_tour_booking_master where booking_id='$booking_id'"));
           if($payment_amount!=0){
            $this->payment_sms_notification_send($booking_id, $payment_amount, $payment_mode,$sq_c['customer_id']);
           }

           echo "Payment has been successfully saved.";  
         }
         else{
           rollback_t();
           echo "error--Payment not saved!";  
         }
        
	    }  
    
 }

 public function payment_finance_save($payment_id)
 {
    $row_spec = 'sales';
    $booking_id = $_POST['booking_id'];
    $payment_date1 = $_POST['payment_date'];
    $payment_mode = $_POST['payment_mode'];
    $payment_amount1 = $_POST['payment_amount'];
    $bank_name = $_POST['bank_name'];
    $transaction_id1 = $_POST['transaction_id'];
    $payment_for = $_POST['payment_for'];
    $p_travel_type = $_POST['p_travel_type'];
    $bank_id1 = $_POST['bank_id'];
    $credit_charges = $_POST['credit_charges'];
    $credit_card_details = $_POST['credit_card_details'];
  
    $payment_date = date('Y-m-d', strtotime($payment_date1));
    $year1 = explode("-", $payment_date);
    $yr1 =$year1[0];

    $sq_group_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_group_info['customer_id'];  
    global $transaction_master;


    //Getting cash/Bank Ledger
    if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
    else{ 
      $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
      $pay_gl = $sq_bank['ledger_id'];
      $type='BANK RECEIPT';
    } 
    $payment_amount1 = $payment_amount1 + $credit_charges;
     //Getting customer Ledger
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust['ledger_id'];

    if($payment_mode == 'Credit Card'){

      //////Customer Credit charges///////
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $credit_charges;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date, $credit_charges, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = $cust_gl;
      $payment_side = "Debit";
      $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
  
      //////Credit charges ledger///////
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $credit_charges;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date1, $credit_charges, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
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
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $finance_charges;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = 231;
      $payment_side = "Debit";
      $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
      //////Credit company amount///////
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $credit_company_amount;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = $company_gl;
      $payment_side = "Debit";
      $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
    else{
      //////Payment Amount///////
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $payment_amount1;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = $pay_gl;
      $payment_side = "Debit";
      $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
      ////////Customer Amount//////
      $module_name = "Package Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $payment_amount1;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id1,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = $cust_gl;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
 }

 public function bank_cash_book_save($payment_id)
{
  global $bank_cash_book_master;

  $booking_id = $_POST['booking_id'];
  $payment_date = $_POST['payment_date'];
  $payment_mode = $_POST['payment_mode'];
  $payment_amount = $_POST['payment_amount'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $payment_for = $_POST['payment_for'];
  $p_travel_type = $_POST['p_travel_type'];
  $bank_id = $_POST['bank_id'];
  $payment_date = date("Y-m-d", strtotime($payment_date));
  $year1 = explode("-", $payment_date);
  $yr1 =$year1[0];

  $sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from package_tour_booking_master where booking_id='$booking_id'"));    
  $sq_booking = mysql_fetch_assoc(mysql_query("select customer_id from tourwise_traveler_details where id='$sq_payment_info[tourwise_traveler_id]'"));
  $credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
  }
  
  $module_name = "Package Booking";
  $module_entry_id = $payment_id;
  $payment_date = $payment_date;
  $payment_amount = $payment_amount;
  $payment_mode = $payment_mode;
  $bank_name = $bank_name;
  $transaction_id = $transaction_id;
  $bank_id = $bank_id;
  $particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id);
  $clearance_status = ($payment_mode=="Cheque" ||$payment_mode=="Credit Card")  ? "Pending" : "";
  $payment_side = "Debit";
  $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

  $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
  
}
/////////////***** Package Tour payment master save end /////

////////////***** Package Tour Payment Master update start//////

function package_tour_payment_master_update()
{
  $payment_id = $_POST['payment_id'];
  $booking_id = $_POST['booking_id'];
  $payment_date = $_POST['payment_date'];
  $payment_mode = $_POST['payment_mode'];
  $payment_amount = $_POST['payment_amount'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $payment_for = $_POST['payment_for'];
  $p_travel_type = $_POST['p_travel_type'];
  $bank_id = $_POST['bank_id'];
  $payment_old_value = $_POST['payment_old_value']; 

	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
  $payment_date = date("Y-m-d", strtotime($payment_date));

  $financial_year_id = $_SESSION['financial_year_id'];

  $sq_payment_info = mysql_fetch_assoc(mysql_query("select * from package_payment_master where payment_id='$payment_id'"));

  $clearance_status = ( $payment_mode=='Cheque' && $payment_mode=="Credit Card") ? "Pending" : $sq_payment_info['clearance_status'];
  if($payment_mode=="Cash"){ $clearance_status = ""; }
  
  begin_t();

  $sq_payment = mysql_query("update package_payment_master set financial_year_id='$financial_year_id', booking_id='$booking_id', date='$payment_date', payment_mode='$payment_mode', amount='$payment_amount', bank_name='$bank_name', transaction_id='$transaction_id', payment_for='$payment_for', travel_type='$p_travel_type', bank_id='$bank_id', clearance_status='$clearance_status',credit_charges='$credit_charges' where payment_id='$payment_id' ");

  if(!$sq_payment)
  {
    rollback_t();
    echo "error--Details not updated.";
    exit;
  }  
  else
  {
    $sq_receipt = mysql_query("update package_receipt_master set receipt_of='$payment_for' where payment_id='$payment_id'");
    if(!$sq_receipt)
    {
      $GLOBALS['flag'] = false;
      echo "error--Receipt details not updated.";
    }

    //Finance Update
    $this->finance_update($sq_payment_info, $clearance_status);

    //Bank and Cash Book update
    $this->bank_cash_book_update($sq_payment_info, $clearance_status);


    if($GLOBALS['flag']){
      commit_t();

      //Payment email notification
      $this->payment_update_email_notification_send($payment_id);

      echo "Payment updated!";  
      exit;
    }

    
  }  
}

function finance_update($sq_payment_info, $clearance_status1)
{
    $row_spec ='sales';
    $payment_id = $_POST['payment_id'];
    $booking_id = $_POST['booking_id'];
    $payment_date = $_POST['payment_date'];
    $payment_mode = $_POST['payment_mode'];
    $payment_amount1 = $_POST['payment_amount'];
    $bank_name = $_POST['bank_name'];
    $transaction_id1 = $_POST['transaction_id'];
    $bank_id = $_POST['bank_id']; 
    $payment_old_value = $_POST['payment_old_value']; 
    $credit_charges = $_POST['credit_charges'];
    $credit_card_details = $_POST['credit_card_details'];
    $credit_charges_old = $_POST['credit_charges_old'];

    $payment_date = date('Y-m-d', strtotime($payment_date));
    $year1 = explode("-", $payment_date);
    $yr1 =$year1[0];

    $sq_group_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_group_info['customer_id'];  
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
    if($payment_amount1 != $payment_old_value){
      //////////Payment Amount///////////
      if($payment_mode == 'Credit Card'){

        $payment_old_value = $payment_old_value + $credit_charges_old;
        //////Customer Credit charges///////
        $module_name = "Package Booking";
        $module_entry_id = $payment_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $credit_charges_old;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date, $credit_charges_old, $customer_id, $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = $cust_gl;
        $payment_side = "Credit";
        $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
  
        //////Credit charges ledger///////
        $module_name = "Passport Booking";
        $module_entry_id = $payment_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $credit_charges_old;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date1, $credit_charges_old, $customer_id, $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
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
        $module_name = "Passport Booking";
        $module_entry_id = $payment_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $finance_charges;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = 231;
        $payment_side = "Credit";
        $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
  
        //////Credit company amount///////
        $module_name = "Passport Booking";
        $module_entry_id = $payment_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $credit_company_amount;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date, $credit_company_amount, $customer_id, $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = $company_gl;
        $payment_side = "Credit";
        $clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
      }
      else{
  
        $module_name = "Passport Booking";
        $module_entry_id = $payment_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $payment_old_value;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date, $payment_old_value, $sq_passport_info['customer_id'], $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = $pay_gl;
        $payment_side = "Credit";
        $clearance_status = ($payment_mode=="Cheque" || $payment_mode == 'Credit Card') ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
      }
  
      $module_name = "Passport Booking";
      $module_entry_id = $payment_id;
      $transaction_id = $transaction_id1;
      $payment_amount = $payment_old_value;
      $payment_date = $payment_date;
      $payment_particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr2), $payment_date, $payment_old_value, $sq_passport_info['customer_id'], $payment_mode, get_package_booking_id($passport_id,$yr1),$bank_id,$transaction_id1);
      $ledger_particular = get_ledger_particular('By','Cash/Bank');
      $gl_id = $cust_gl;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
   
}


public function bank_cash_book_update($sq_payment_info, $clearance_status)
{
  global $bank_cash_book_master;

  $payment_id = $_POST['payment_id'];
  $payment_date = $_POST['payment_date'];
  $payment_mode = $_POST['payment_mode'];
  $payment_amount = $_POST['payment_amount'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $payment_for = $_POST['payment_for'];
  $p_travel_type = $_POST['p_travel_type'];
  $bank_id = $_POST['bank_id'];
  $payment_date = date("Y-m-d", strtotime($payment_date));
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];

	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];
  $sq_booking_info = mysql_fetch_assoc(mysql_query("select customer_id from package_tour_booking_master where booking_id='$sq_payment_info[booking_id]'"));    
  if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}
  $module_name = "Package Booking";
  $module_entry_id = $payment_id;
  $payment_date = $payment_date;
  $payment_amount = $payment_amount;
  $payment_mode = $payment_mode;
  $bank_name = $bank_name;
  $transaction_id = $transaction_id;
  $bank_id = $bank_id;
  $particular = get_sales_paid_particular(get_package_booking_payment_id($payment_id,$yr1), $payment_date, $payment_amount, $sq_booking_info['customer_id'], $payment_mode, get_package_booking_id($sq_payment_info['booking_id'],$yr1));
  $clearance_status = $clearance_status;
  $payment_side = "Debit";
  $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

  $bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
}

//////////////////***** Package Tour Payment Master update end /////////////


////////////////**Payment email notification send start**/////////////////
public function payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date){
   global $encrypt_decrypt,$secret_key;

   $sq_total_paid = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status!='Cancelled'"));
   $paid_amount = $sq_total_paid['sum'];

   $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
   $date = $sq_booking['booking_date'];
   $yr = explode("-", $date);
   $year =$yr[0];
   $total_amount = $sq_booking['total_travel_expense'] + $sq_booking['actual_tour_expense'];
   $due_date = ($sq_booking['due_date'] == '1970-01-01') ? '' : $sq_booking['due_date'];
   $subject = 'Payment Acknowledgement (Booking ID : '.get_package_booking_id($booking_id,$year).' )';
   global $model;
   $model->generic_payment_mail('45',$payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $due_date,$sq_booking['email_id'], $subject,$sq_booking['contact_person_name']);
 }
 //////////////////////////////////**Payment email notification send end**/////////////////////////////////////

//////////////////////////////////**Payment email notification send start**/////////////////////////////////////
 public function payment_update_email_notification_send($payment_id)
 {
   $sq_payment_info = mysql_fetch_assoc(mysql_query("select * from package_payment_master where payment_id='$payment_id' and clearance_status!='Cancelled'"));
   $payment_amount = $sq_payment_info['amount'];
   $payment_mode = $sq_payment_info['payment_mode'];
   $payment_date = $sq_payment_info['date'];
   $booking_id = $sq_payment_info['booking_id'];
   $update_payment = true;

   $sq_total_paid = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status!='Cancelled'"));
   $paid_amount = $sq_total_paid['sum'];

   $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
   $cust_info = mysql_fetch_assoc(mysql_query("select first_name from customer_master where customer_id='$sq_booking[customer_id]'"));
   $total_amount = $sq_booking['total_travel_expense'] + $sq_booking['actual_tour_expense'];
   $email_id = $sq_booking['email_id'];

   $date = $sq_booking['booking_date'];
   $yr = explode("-", $date);
   $year =$yr[0];
   $due_date = ($sq_booking['due_date'] == '1970-01-01') ? '' : $sq_booking['due_date'];

   $payment_id = get_package_booking_payment_id($payment_id,$year);
   $subject = 'Package Booking Payment Correction (Booking ID : '.get_package_booking_id($booking_id,$year).' )';
   global $model;
   $model->generic_payment_mail('56',$payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $due_date,$email_id,$subject, $cust_info['first_name']);
 }
//////////////////////////////////**Payment email notification send end**/////////////////////////////////////

//////////////////////////////////**Payment sms notification send start**/////////////////////////////////////
 public function payment_sms_notification_send($booking_id, $payment_amount, $payment_mode,$customer_id){
    global $app_name,$model,$currency;
   
    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $fname = $sq_customer['first_name'];
    $lname = $sq_customer['last_name'];
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
    $mobile_no = $sq_booking['mobile_no'];
    $sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$currency'"));
    $currency_code = $sq_currency['currency_code'];
    $message = "Dear ". $fname." ". $lname.", Acknowledge your payment of ".$payment_amount." ".$currency_code." , which we received for Package Tour installment.";

  
    $model->send_message($mobile_no, $message);
}
//////////////////////////////////**Payment sms notification send end**///////////////////////////////////// 
public function whatsapp_send(){
	global $app_contact_no,$session_emp_id,$currency_logo;
  
   $booking_id = $_POST['booking_id'];
   $payment_amount = $_POST['payment_amount'];
   $currency = "Rs.";
   $sq_booking_info = mysql_fetch_assoc(mysql_query("select total_travel_expense,actual_tour_expense,customer_id from package_tour_booking_master where booking_id='$booking_id'"));
  
   $total_amount = $sq_booking_info['total_travel_expense'] + $sq_booking_info['actual_tour_expense'];

   $sq_total_paid = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status!='Cancelled'"));

   $paid_amount = $sq_total_paid['sum'];
   $outstanding =  $total_amount - ($paid_amount+$payment_amount);
  
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id= '$session_emp_id"));
if($session_emp_id == 0){
   $contact = $app_contact_no;
}
else{
   $contact = $sq_emp_info['mobile_no'];
}

$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id=".$sq_booking_info['customer_id']));
   
$whatsapp_msg = rawurlencode('Hello Dear '.$sq_customer[first_name].',
Hope you are doing great. This is to inform you that we have received your payment. We look forward to provide you a great experience.
*Total Amount* : '.$currency_logo.' '.$total_amount.'
*Paid Amount* : '.$currency_logo.' '.$payment_amount.'
*Balance Amount* : '.$currency_logo.' '.$outstanding.'
  
Please do not hesitate to call us on '.$contact.' if you have any concern. 
Thank you. ');
   $link = 'https://web.whatsapp.com/send?phone='.$sq_customer['contact_no'].'&text='.$whatsapp_msg;
   echo $link;
  }
}
?>
