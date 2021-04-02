<?php 
$flag = true;
class ticket_refund{

public function ticket_refund_save()
{
	$ticket_id = $_POST['ticket_id'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];
	$entry_id_arr = $_POST['entry_id_arr'];	

	$refund_date = date('Y-m-d', strtotime($refund_date));

	$created_at = date('Y-m-d H:i:s');
	
	if($refund_mode == "Cheque"){ 
		$clearance_status = "Pending"; } 
	else {  $clearance_status = ""; }	

	$financial_year_id = $_SESSION['financial_year_id'];  
	$branch_admin_id = $_SESSION['branch_admin_id'];

	$bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
	if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }

	begin_t(); 

	$sq_max = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from ticket_refund_master"));
	$refund_id = $sq_max['max'] + 1;

	$sq_payment = mysql_query("insert into ticket_refund_master (refund_id, ticket_id, financial_year_id, refund_date, refund_amount, refund_mode, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$refund_id', '$ticket_id', '$financial_year_id', '$refund_date', '$refund_amount', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at') ");

	if($refund_mode == 'Credit Note'){
		$sq_sq_exc_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
  	    $customer_id = $sq_sq_exc_info['customer_id'];
  	    
		$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
		$cid = $sq_max['max'] + 1;

		$sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$cid', '$financial_year_id', 'Air Ticket Booking', '$ticket_id', '$customer_id','$refund_amount','$refund_id','$refund_date','$branch_admin_id') ");
	}

	if(!$sq_payment){
		rollback_t();
		echo "error--Sorry, Refund not saved!";
		exit;
	}
	else{

		for($i=0; $i<sizeof($entry_id_arr); $i++){

			$sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from ticket_refund_entries"));
			$id= $sq_max['max'] + 1;;

			$sq_entry = mysql_query("insert into ticket_refund_entries(id, refund_id, entry_id) values ('$id', '$refund_id', '$entry_id_arr[$i]')");
			if(!$sq_entry){
				$GLOBALS['flag'] = false;
				echo "error--Some entries not saved!";
				//exit;
			}

		}


		if($refund_mode != 'Credit Note'){
			//Finance save
	    	$this->finance_save($refund_id,$cid);

	    }

    	//Bank and Cash Book Save
		$this->bank_cash_book_save($refund_id);
		//refund email to customer
		if($refund_amount!=0){
			$this->refund_mail_send($ticket_id,$refund_amount,$refund_date,$refund_mode,$transaction_id);
		}

		if($GLOBALS['flag']){
			commit_t();
			echo "Ticket refund saved successfully!";
			exit;	
		}
		else{
			rollback_t();
			exit;
		}
    	
	}
}


public function finance_save($refund_id,$cid)
{
	$row_spec = 'sales';
	$ticket_id = $_POST['ticket_id'];
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

	$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
  	$customer_id = $sq_exc_info['customer_id'];
	$refund_date = date('Y-m-d', strtotime($sq_exc_info['created_at']));
	$year = explode("-", $refund_date);
	$yr =$year[0];

  	//Getting cash/Bank Ledger
    if($refund_mode == 'Cash') {  $pay_gl = 20; $type='CASH PAYMENT'; }
    else{ 
	    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
	    $pay_gl = $sq_bank['ledger_id'];
		$type='BANK PAYMENT';
    } 

  	//Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

	//Particular	
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$pax = $sq_exc_info['adults'] + $sq_exc_info['childrens'];
	
	$sq_trip1 = mysql_query("select * from ticket_trip_entries where ticket_id='$ticket_id'");
	$i=0;
	while($sq_trip = mysql_fetch_assoc($sq_trip1)){
  
		$dep = explode('(',$sq_trip['departure_city']);
		$arr = explode('(',$sq_trip['arrival_city']);
		if($i == 0)
			$sector = str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		else
			$sector = $sector.','.str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		$i++;
	}
	$sq_trip2 = mysql_fetch_assoc(mysql_query("select airlin_pnr from ticket_trip_entries where ticket_id='$ticket_id'"));
	$pnr = $sq_trip2['airlin_pnr'];
	$sq_trip3 = mysql_fetch_assoc(mysql_query("select ticket_no from ticket_master_entries where ticket_id='$ticket_id'"));
	$ticket_no = $sq_trip3['ticket_no'];
  
	$particular .= 'Payment through '.$refund_mode.' '.get_ticket_booking_id($ticket_id,$yr).' for '.$cust_name.' * '.$pax.' traveling for '.$sector.' against ticket no '.$ticket_no.'/PNR No '.$pnr;

	////////Refund Amount//////
    $module_name = "Air Ticket Booking Refund Paid";
    $module_entry_id = $ticket_id;
    $transaction_id = $transaction_id ;
    $payment_amount = $refund_amount;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);

	////////Refund Amount//////
    $module_name = "Air Ticket Booking Refund Paid";
    $module_entry_id = $ticket_id;
    $transaction_id = $transaction_id ;
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
	$ticket_id = $_POST['ticket_id'];
	$refund_charges = $_POST['refund_charges'];
	$refund_date = $_POST['refund_date'];
	$refund_amount = $_POST['refund_amount'];
	$refund_mode = $_POST['refund_mode'];
	$bank_name = $_POST['bank_name'];
	$transaction_id = $_POST['transaction_id'];	
	$bank_id = $_POST['bank_id'];

	global $bank_cash_book_master;
	$refund_date = date('Y-m-d', strtotime($refund_date));
	$year1 = explode("-", $refund_date);
	$yr1 =$year1[0];

	$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
	$customer_id = $sq_exc_info['customer_id'];
	$refund_date1 = date('Y-m-d', strtotime($sq_exc_info['created_at']));
	$year = explode("-", $refund_date1);
	$yr =$year[0];
	//Particular
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
	$pax = $sq_exc_info['adults'] + $sq_exc_info['childrens'];
	
	$sq_trip1 = mysql_query("select * from ticket_trip_entries where ticket_id='$ticket_id'");
	$i=0;
	while($sq_trip = mysql_fetch_assoc($sq_trip1)){
  
		$dep = explode('(',$sq_trip['departure_city']);
		$arr = explode('(',$sq_trip['arrival_city']);
		if($i == 0)
			$sector = str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		else
			$sector = $sector.','.str_replace(')','',$dep[1]).'-'.str_replace(')','',$arr[1]);
		$i++;
	}
	$sq_trip2 = mysql_fetch_assoc(mysql_query("select airlin_pnr from ticket_trip_entries where ticket_id='$ticket_id'"));
	$pnr = $sq_trip2['airlin_pnr'];
	$sq_trip3 = mysql_fetch_assoc(mysql_query("select ticket_no from ticket_master_entries where ticket_id='$ticket_id'"));
	$ticket_no = $sq_trip3['ticket_no'];
  
	$particular .= 'Payment through '.$refund_mode.' '.get_ticket_booking_id($ticket_id,$yr).' for '.$cust_name.' * '.$pax.' traveling for '.$sector.' against ticket no '.$ticket_no.'/PNR No '.$pnr;

	$module_name = "Air Ticket Booking Refund Paid";
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


public function refund_mail_send($ticket_id,$refund_amount,$refund_date,$refund_mode,$transaction_id){

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$encrypt_decrypt,$secret_key,$currency_logo;
   
  $sq_sq_flight_info = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$ticket_id'"));
  $date = $sq_sq_flight_info['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $cust_email = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_sq_flight_info[customer_id]'"));
  $email_id = $encrypt_decrypt->fnDecrypt($cust_email['email_id'], $secret_key);

  $sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from ticket_payment_master where ticket_id='$sq_ticket_info[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_refund_amount = mysql_fetch_assoc(mysql_query("select sum(refund_amount)as sum from ticket_refund_master where ticket_id='$sq_ticket_info[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_pend_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from ticket_refund_master where ticket_id='$ticket_id' and clearance_status='Pending'"));
$sq_canl_pay=mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from ticket_refund_master where ticket_id='$ticket_id' and clearance_status='Cancelled'"));

$total_refund_sum =mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from ticket_refund_master where ticket_id='$ticket_id' "));

$total_sum=$total_refund_sum['sum'] - $sq_canl_pay['sum'];

$sale_amount = $sq_ticket_info['ticket_total_cost'];
$paid_amt = $sq_paid_amount['sum'];
$cancel_amount = $sq_ticket_info['cancel_amount'];

  $content = '
  <tr>
  <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
	  <tr><td style="text-align:left;border: 1px solid #888888;">Service Type</td>   <td style="text-align:left;border: 1px solid #888888;">Flight Ticket Booking</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Selling Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sale_amount,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($total_refund,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Cancellation Charges</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($cancel_amount,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($refund_amount,2).'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>
	  <tr><td style="text-align:left;border: 1px solid #888888;">Refund Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
  </table>
</tr>';


	  
// if($transaction_id!= ''){ $content .= ' <tr><td style="text-align:left;border: 1px solid #888888;">Cheque No/ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$transaction_id.'</td></tr>';
// }
	  $content .= '</tr>';
 
  $subject = 'Flight Cancellation Refund( '.get_ticket_booking_id($sq_sq_flight_info['ticket_id'],$year).' )';
  global $model;
 
  $model->app_email_send('33',$cust_email['first_name'],$email_id, $content,$subject);
}


}
?>