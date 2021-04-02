<?php 
$flag = true;
class passport_refund{

public function passport_refund_save()
{
	$passport_id = $_POST['passport_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));

	$created_at = date('Y-m-d H:i:s');

	if($refund_mode == 'Cheque'){ 
		$clearance_status = "Pending"; } 
	else {  $clearance_status = ""; }	

	$financial_year_id = $_SESSION['financial_year_id'];   
	$branch_admin_id = $_SESSION['branch_admin_id'];

	$bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }

	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from passport_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into passport_refund_master (refund_id, passport_id, financial_year_id, refund_date, refund_amount, refund_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$passport_id', '$financial_year_id', '$refund_date', '$refund_amount', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at') ");


	if($refund_mode == 'Credit Note'){
		$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
  	    $customer_id = $sq_passport_info['customer_id'];
  	    
		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
		$id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount, refund_id, created_at,branch_admin_id) values ('$id', '$financial_year_id', 'Passport Booking', '$passport_id', '$customer_id','$refund_amount','$refund_id','$refund_date','$branch_admin_id') ");
	}


	if(!$sq_payment){
		rollback_t();
		echo "error--Sorry, Refund not saved!";
		exit;
	}
	else{

		for($i=0; $i<sizeof($entry_id_arr); $i++){

			$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from passport_refund_entries"));
			$id= $sq_max['max'] + 1;

			$sq_entry = mysql_query("insert into passport_refund_entries(id, refund_id, entry_id) values ('$id', '$refund_id', '$entry_id_arr[$i]')");
			if(!$sq_entry){
				$GLOBALS['glag'] = false;
				echo "error--Some entries not saved!";
				//exit;
			}

		}
		if($refund_mode != 'Credit Note'){
			//Finance save
	    	$this->finance_save($refund_id);

	    }
    	//Bank and Cash Book Save
		$this->bank_cash_book_save($refund_id);
		if($refund_amount!=0){
			$this->refund_mail_send($passport_id,$refund_amount,$refund_date,$refund_mode,$transaction_id);
		}

		if($GLOBALS['flag']){
			commit_t();
			echo "Passport refund has been successfully saved.";
			exit;	
		}
		else{
			rollback_t();
			exit;
		}

    	
	}
}

public function refund_mail_send($passport_id,$refund_amount,$refund_date,$refund_mode,$transaction_id){

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$encrypt_decrypt,$secret_key,$currency_logo;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

   
  $sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
  $date = $sq_passport_info['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $cust_email = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));
  $email_id = $encrypt_decrypt->fnDecrypt($cust_email['email_id'], $secret_key);

	$content = '<tr>
	<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
		<tr><td style="text-align:left;border: 1px solid #888888;">Booking ID </td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_passport_info['passport_id'].'</td></tr>
		<tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.$refund_amount.'</td></tr>
		<tr><td style="text-align:left;border: 1px solid #888888;">Payment Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
		<tr><td style="text-align:left;border: 1px solid #888888;">Payment Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>';
	if($transaction_id!= ''){ $content .= ' <tr><td style="text-align:left;border: 1px solid #888888;">Cheque No/ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$transaction_id.'</td></tr>';
	}
	  $content .= '</tr>';

  $subject = 'Passport Cancellation Refund ('.get_visa_booking_id($sq_passport_info['passport_id'],$year).' )';
  global $model;
  $model->app_email_send('110',$cust_email['first_name'],$email_id, $content, $subject);
}

public function finance_save($refund_id)
{
	$row_spec = 'sales';
	$passport_id = $_POST['passport_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];	
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year2 = explode("-", $refund_date);
	$yr2 =$year2[0];

	global $transaction_master;
	$sq_passport = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
  	$customer_id = $sq_passport['customer_id'];
  	$created_at = $sq_passport['created_at'];
	$year1 = explode("-", $created_at);
	$yr1 =$year1[0];

  	//Getting cash/Bank Ledger
    if($refund_mode == 'Cash') {  $pay_gl = 20; $type='CASH PAYMENT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
    } 

	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$particular = 'Payment through '.$refund_mode.' for '.get_passport_booking_id($passport_id,$yr1).' for Passport renewal assistance for '.$cust_name;

  	//Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

	////////Refund Amount//////
    $module_name = "Passport Booking Refund Paid";
    $module_entry_id = $passport_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

	////////Refund Amount//////
    $module_name = "Passport Booking Refund Paid";
    $module_entry_id = $passport_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

}


public function bank_cash_book_save($refund_id)
{
	$passport_id = $_POST['passport_id'];
	$refund_charges = $_POST['refund_charges'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	global $bank_cash_book_master;

	$refund_date = get_date_db($refund_date);
	$year1 = explode("-", $refund_date);
	$yr2 =$year1[0];
	
	$sq_passport = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
  	$customer_id = $sq_passport['customer_id'];
  	$created_at = $sq_passport['created_at'];
	$year1 = explode("-", $created_at);
	$yr1 = $year1[0];
	
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$particular = 'Payment through '.$refund_mode.' for '.get_passport_booking_id($passport_id,$yr1).' for Passport renewal assistance for '.$cust_name;

	$module_name = "Passport Booking Refund Paid";
	$module_entry_id = $refund_id;
	$payment_date = $refund_date;
	$payment_amount = $refund_amount;
	$payment_mode = $refund_mode;
	$bank_name = $bank_name;
	$transaction_id = $transaction_id;
	$bank_id = $bank_id;
	$particular = $particular;
	$clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
	$payment_side = "Credit";
	$payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";
	$bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);

}

}
?>