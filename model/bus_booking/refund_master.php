<?php 
$flag = true;
class refund_master{

public function refund_save()
{
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$created_at = date('Y-m-d H:i:s');
		
	if($refund_mode=="Cheque"){ 
		$clearance_status = "Pending"; } 
	else {  $clearance_status = ""; }	

	$financial_year_id = $_SESSION['financial_year_id'];  
	$branch_admin_id = $_SESSION['branch_admin_id'];
		 

	$bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }    

	//**Starting transaction
	begin_t();

	$sq_max = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from bus_booking_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into bus_booking_refund_master (refund_id, booking_id, financial_year_id, refund_date, refund_amount, refund_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$booking_id', '$financial_year_id', '$refund_date', '$refund_amount', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at') ");

	if($refund_mode == 'Credit Note'){
		$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
  	    $customer_id = $sq_bus_info['customer_id'];
  	    
		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
		$id = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$id', '$financial_year_id', 'Bus Booking', '$booking_id', '$customer_id','$refund_amount','$refund_id','$refund_date','$branch_admin_id') ");
	}
	if(!$sq_payment){
		$GLOBALS['flag'] = false;
		echo "error--Sorry, Refund has not been saved.!";		
	}
	
	if($refund_mode != 'Credit Note'){
		//Finance save
    	$this->finance_save($refund_id);

    }

	//Bank and Cash Book Save
	$this->bank_cash_book_save($refund_id);
	//refund email to customer
	if($refund_amount!=0){
		$this->refund_mail_send($booking_id,$refund_amount,$refund_date,$refund_mode,$transaction_id);
	}
	
	if($GLOBALS['flag']){
		commit_t();
		echo "Refund has been successfully saved.!";
		exit;	
	}
	else{
		rollback_t();
		exit;
	}
}


public function finance_save($refund_id)
{
	$row_spec = 'sales';
	$booking_id = $_POST['booking_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];
	$bank_id = $_POST['bank_id'];	
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year1 = explode("-", $refund_date);
	$yr1 =$year1[0];

	global $transaction_master;

	$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
  	$customer_id = $sq_bus_info['customer_id'];
	$year = explode("-", $sq_bus_info['created_at']);
	$yr =$year[0];

  	//Getting cash/Bank Ledger
    if($refund_mode == 'Cash') {  $pay_gl = 20; $type='CASH PAYMENT';  }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
     } 

  	//Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];
	//Particulars
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$sq_booking = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where booking_id='$booking_id'"));
  
	$particular = 'Payment through '.$refund_mode.' '.get_bus_booking_id($booking_id,$yr1).' for the Bus Seat booking of '.$cust_name.' for '.$sq_booking['origin'].'-'.$sq_booking['destination'].' PNR No '.$sq_booking['pnr_no'].' on Dt.'.get_date_user($sq_booking['date_of_journey']);

	////////Refund Amount//////
    $module_name = "Bus Booking Refund Paid";
    $module_entry_id = $booking_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

	////////Refund Amount//////
    $module_name = "Bus Booking Refund Paid";
    $module_entry_id = $booking_id;
    $transaction_id = $transaction_id;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

}


public function bank_cash_book_save($refund_id)
{
	$booking_id = $_POST['booking_id'];
	$refund_charges = $_POST['refund_charges'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year1 = explode("-", $refund_date);
	$yr1 =$year1[0];

	$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
	$year = explode("-", $sq_bus_info['created_at']);
	$customer_id = $sq_bus_info['customer_id'];
	$yr =$year[0];
	//Particulars
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$sq_booking = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where booking_id='$booking_id'"));
  
	$particular = 'Payment through '.$refund_mode.' '.get_bus_booking_id($booking_id,$yr1).' for the Bus Seat booking of '.$cust_name.' for '.$sq_booking['origin'].'-'.$sq_booking['destination'].' PNR No '.$sq_booking['pnr_no'].' on Dt.'.get_date_user($sq_booking['date_of_journey']);

	global $bank_cash_book_master;

	$module_name = "Bus Booking Refund Paid";
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


 public function refund_mail_send($booking_id,$refund_amount,$refund_date,$refund_mode,$transaction_id)
 {


	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$encrypt_decrypt,$secret_key,$currency_logo;
  	global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   
  $sq_sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$booking_id'"));
  $date = $sq_sq_bus_info['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $cust_email = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_sq_bus_info[customer_id]'"));
  $email_id = $encrypt_decrypt->fnDecrypt($cust_email['email_id'], $secret_key);

  $sq_payment_sum = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_refund_sum = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from bus_booking_refund_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$net_total = $sq_sq_bus_info['net_total'];
$paid_amount = $sq_payment_sum['sum'];
$cancel_amount = $sq_sq_bus_info['cancel_amount'];
$refund_amount = $sq_sq_bus_info['refund_net_total'];

  $content = '
  <tr>
  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
	  <tr><td style="text-align:left;border: 1px solid #888888;">Service Type</td>   <td style="text-align:left;border: 1px solid #888888;">Bus Booking</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Selling Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($net_total,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($paid_amount,2) .'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Cancellation Charges</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($cancel_amount,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($refund_amount,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
  </table>
</tr>';
		  
		  
    // if($transaction_id!= ''){ $content .= ' <tr><td style="text-align:left;border: 1px solid #888888;">Cheque No/ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$transaction_id.'</td></tr>';
    // }
          $content .= '</tr>';
  $subject = 'Bus Cancellation Refund( '.get_bus_booking_id($booking_id,$year).' )';
  global $model;
 
  $model->app_email_send('37',$cust_email['first_name'],$email_id, $content, $subject);
 }


}
?>