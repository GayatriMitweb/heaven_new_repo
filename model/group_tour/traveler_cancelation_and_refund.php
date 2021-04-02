<?php 
$flag = true;
class traveler_cancelation_and_refund
{

///////////////////////////////////////Cancel Traveler Booking start ///////////////////////////////////////////////////////////////////////////////////////// 
public function cancel_traveler_booking($tourwise_id, $traveler_id_arr, $first_names_arr)
{
  begin_t();
  for($i=0; $i<sizeof($traveler_id_arr); $i++)
  {
    $sq_cancel = mysql_query("update travelers_details set status='Cancel' where traveler_id='$traveler_id_arr[$i]'");
    if(!$sq_cancel)
    {
      $GLOBALS['flag'] = false;
      echo "error--Sorry, some members are not canceled.";
      //exit;
    }  
  }  


  if($GLOBALS['flag']){
    commit_t();
    //Cancelation mail send
    $this->traveler_cancelation_mail_send($tourwise_id, $traveler_id_arr);

    //Cancelation sms send
    $this->traveler_cancelation_sms_send($tourwise_id);

    echo "Group Booking Cancellation is successfully done.";
    exit;
  }
  else{
    rollback_t();
    exit;
  }

  
}
///////////////////////////////////////Cancel Traveler Booking end /////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////Traveler Cancelation mail send start/////////////////////////////////////////////////////////////////////////////////////////
public function traveler_cancelation_mail_send($tourwise_id, $traveler_id_arr){
  $sq_tourwise = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $date = $sq_tourwise['form_date'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $sq_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));
  $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_tourwise[tour_id]'"));
  $sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$sq_tourwise[tour_group_id]'"));

  $sq_traveler = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_group_id='$sq_tourwise[traveler_group_id]'"));

  $tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' To '.date('d-m-Y', strtotime($sq_tour_group['to_date']));

  $content1 = '';

  for($i=0; $i<sizeof($traveler_id_arr); $i++){
    $sq_traveler_info = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_id='$traveler_id_arr[$i]'"));
    $content1 .= '
    <tr>
      <td style="text-align:left;border: 1px solid #888888;">'.($i+1).'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_traveler_info['first_name'].' '.$sq_traveler_info['last_name'].'</td>   
    </tr>   
    ';    
  }

  global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
  $content = '
  <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
    <td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tour[tour_name].'</td>   
    <tr>
      <td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_group .'</td>   
    </tr>   
  </tr>   
    </table>
  </tr>
  <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Guest Name
      </th>
    </tr>
    
      '.$content1.'
    
  </table>
</tr>      
  ';
  $subject = 'Tour Cancellation Confirmation ('.get_group_booking_id($tourwise_id,$year).' ,'.$sq_tour['tour_name'].' )';
  global $model;
 $model->app_email_send('26',$sq_traveler['first_name'],$sq_personal_info['email_id'], $content, $subject);
 
}
///////////////////////////////////////Traveler Cancelation mail send end/////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////Traveler Cancelation sms send start/////////////////////////////////////////////////////////////////////////////////////////
public function traveler_cancelation_sms_send($tourwise_id)
{
  $sq_tourwise = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $sq_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));
  $sq_tour = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$sq_tourwise[tour_id]'"));
  $sq_tour_group = mysql_fetch_assoc(mysql_query("select * from tour_groups where group_id='$sq_tourwise[tour_group_id]'"));

  $sq_traveler = mysql_fetch_assoc(mysql_query("select * from travelers_details where traveler_group_id='$sq_tourwise[traveler_group_id]'"));

  $tour_group = date('d-m-Y', strtotime($sq_tour_group['from_date'])).' to '.date('d-m-Y', strtotime($sq_tour_group['to_date']));

  $message = 'We are accepting your cancellation request with below details. Tour Name : '.$sq_tour['tour_name'].' Tour Date :'.$tour_group;
  global $model;
  $model->send_message($sq_personal_info['mobile_no'], $message);
}
///////////////////////////////////////Traveler Cancelation sms send end/////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////Refund canceled traveler booking save start////////////////////////////////////////////////////////////////////////////// 
public function refund_canceled_traveler_save(){

  $unique_timestamp = $_POST['unique_timestamp'];
  $tourwise_id = $_POST['tourwise_id'];

  $total_refund = $_POST['total_refund'];
  $refund_mode = $_POST['refund_mode'];
  $refund_date = $_POST['refund_date'];
  $transaction_id = $_POST['transaction_id'];
  $bank_name = $_POST['bank_name'];
  $bank_id = $_POST['bank_id'];

  $traveler_id_arr = $_POST['traveler_id_arr'];
  $refund_date = date('Y-m-d', strtotime($refund_date));
  $created_at = date('Y-m-d');

  $bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $total_refund);
  if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }  

  $timestamp_count = mysql_num_rows( mysql_query("select refund_id from refund_traveler_cancelation where unique_timestamp='$unique_timestamp'") );
  if($timestamp_count>0)
  {
    echo "Sorry, Timestamp exists already.";
    exit;
  } 

  $clearance_status = ($refund_mode=="Cheque") ? "Pending" : "";

  $financial_year_id = $_SESSION['financial_year_id']; 
  $branch_admin_id = $_SESSION['branch_admin_id'];  

  begin_t();

  $sq_max_id = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from refund_traveler_cancelation"));
  $max_id = $sq_max_id['max']+1;

  $sq_refund = mysql_query("insert into refund_traveler_cancelation (refund_id, tourwise_traveler_id, financial_year_id, total_refund, refund_mode, refund_date, transaction_id, bank_name, bank_id, clearance_status, created_at, unique_timestamp) values ('$max_id', '$tourwise_id', '$financial_year_id', '$total_refund', '$refund_mode', '$refund_date', '$transaction_id', '$bank_name', '$bank_id', '$clearance_status', '$created_at', '$unique_timestamp' )");

  if($refund_mode == 'Credit Note'){
    $sq_group_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
    $customer_id = $sq_group_info['customer_id'];
        
    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
    $id = $sq_max['max'] + 1;

    $sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$id', '$financial_year_id', 'Group Booking', '$tourwise_id', '$customer_id','$total_refund','$max_id','$refund_date','$branch_admin_id') ");
  }

  if(!$sq_refund)
  {
    $GLOBALS['flag'] = false;
    echo "Refund not saved.";
    //exit;
  }  
  else
  {
    for($i=0; $i<sizeof($traveler_id_arr); $i++)
    {
      $sq_max_entry_id = mysql_fetch_assoc( mysql_query("select max(id) as max from refund_traveler_cancalation_entries") );
      $max_entry_id = $sq_max_entry_id['max']+1;
      $sq_refund_entry = mysql_query("insert into refund_traveler_cancalation_entries (id, refund_id, traveler_id) values ('$max_entry_id', '$max_id', '$traveler_id_arr[$i]')");
      if(!$sq_refund_entry)
      {
        $GLOBALS['flag'] = false;
        echo "Traveler name not saved properly.";
        //exit;
      }  
    }  

    if($refund_mode != 'Credit Note'){
      //Finance save
        $this->finance_save($max_id);
    }

    //Bank and Cash Book Save
    $this->bank_cash_book_save($max_id);
    $this->refund_mail_send($tourwise_id,$total_refund,$refund_date,$refund_mode);

    if($GLOBALS['flag']){

      commit_t();
      //Refund sms notification send
      //$this->refund_sms_notification_send($tourwise_id);
      
      echo "Refund has been successfully saved";  
      exit;
    }
    else{
      rollback_t();
      exit;
    }    
  }  
}

public function finance_save($refund_id){
  $row_spec = 'sales';
  $tourwise_id = $_POST['tourwise_id'];
  $total_refund = $_POST['total_refund'];
  $refund_date = $_POST['refund_date'];
  $refund_mode = $_POST['refund_mode'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $bank_id = $_POST['bank_id'];

  $refund_date = date('Y-m-d', strtotime($refund_date));
  $yr = explode("-", $refund_date);
  $year =$yr[0];

  global $transaction_master;

  $sq_group_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $customer_id = $sq_group_info['customer_id'];

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
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
    $sq_tour = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$sq_group_info[tour_id]'"));
    $tour_name = $sq_tour['tour_name'];
    $sq_tourgroup = mysql_fetch_assoc(mysql_query("select from_date,to_date from tour_groups where group_id='$sq_group_info[tour_group_id]'"));
    $from_date = new DateTime($sq_tourgroup['from_date']);
    $to_date = new DateTime($sq_tourgroup['to_date']);
    $numberOfNights= $from_date->diff($to_date)->format("%a");
  
    $particular = 'Payment through '.$refund_mode.' for '.$tour_name.' for '.$cust_name.' for '.$numberOfNights.' Nights starting from '.get_date_user($sq_tourgroup['from_date']);
  
  ////////Refund Amount//////
    $module_name = "Group Booking Traveller Refund Paid";
    $module_entry_id = $tourwise_id;
    $transaction_id = $transaction_id;
    $payment_amount = $total_refund;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $pay_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

  ////////Refund Amount//////
    $module_name = "Group Booking Traveller Refund Paid";
    $module_entry_id = $tourwise_id;
    $transaction_id = $transaction_id;
    $payment_amount = $total_refund;
    $payment_date = $refund_date;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

}


public function bank_cash_book_save($refund_id){
  $tourwise_id = $_POST['tourwise_id'];
  $refund_charges = $_POST['refund_charges'];
  $refund_date = $_POST['refund_date'];
  $total_refund = $_POST['total_refund'];
  $refund_mode = $_POST['refund_mode'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id']; 
  $bank_id = $_POST['bank_id'];

  global $bank_cash_book_master;
  $refund_date = date('Y-m-d', strtotime($refund_date));
  $yr = explode("-", $refund_date);
  $year =$yr[0];

  $sq_package_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $customer_id = $sq_package_info['customer_id'];
  $year1 = explode("-", $sq_package_info['form_date']);
  $yr1 = $year1[0];

  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  $sq_tour = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$sq_package_info[tour_id]'"));
  $tour_name = $sq_tour['tour_name'];
  $sq_tourgroup = mysql_fetch_assoc(mysql_query("select from_date,to_date from tour_groups where group_id='$sq_package_info[tour_group_id]'"));
  $from_date = new DateTime($sq_tourgroup['from_date']);
  $to_date = new DateTime($sq_tourgroup['to_date']);
  $numberOfNights= $from_date->diff($to_date)->format("%a");

  $particular = 'Payment through '.$refund_mode.' for '.$tour_name.' for '.$cust_name.' for '.$numberOfNights.' Nights starting from '.get_date_user($sq_tourgroup['from_date']);

  $module_name = "Group Booking Traveller Refund Paid";
  $module_entry_id = $refund_id;
  $payment_date = $refund_date;
  $payment_amount = $total_refund;
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
///////////////////////////////////////Refund canceled traveler booking save end////////////////////////////////////////////////////////////////////////////// 


public function refund_mail_send($tourwise_id,$total_refund,$refund_date,$refund_mode){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website, $currency_logo;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color,$encrypt_decrypt,$secret_key;
   
  $sq_sq_train_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $date = $sq_sq_train_info['form_date'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='Tour' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

  $sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='Travelling' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

  $paid_amount = $sq_total_travel_paid_amount['sum'] + ($sq_total_tour_paid_amount['sum']);
  $sq_tour_info = mysql_fetch_assoc(mysql_query("select * from refund_traveler_estimate where tourwise_traveler_id='$tourwise_id'"));
  
  $cust_email = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_sq_train_info[customer_id]'"));
  $customer_email_id = $encrypt_decrypt->fnDecrypt($cust_email['email_id'], $secret_key);
  
  $content = '
  <tr>
      <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
          <tr><td style="text-align:left;border: 1px solid #888888;">Service Type</td>   <td style="text-align:left;border: 1px solid #888888;">Group Tour</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Selling Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sq_sq_train_info['total_tour_fee'],2).'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($paid_amount,2).'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Cancellation Charges</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sq_tour_info['cancel_amount'],2).'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($total_refund,2).'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Refund Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Refund Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
      </table>
  </tr>
  ';
  $subject = 'Group Tour Refund Confirmation (Booking ID : '.get_group_booking_id($tourwise_id,$year).' )';

  global $model;
  $model->app_email_send('27',$cust_email['first_name'],$customer_email_id, $content, $subject);
 }



/////////////Refund sms reminder send start/////////////////////////////////////////////////////////////////////////////////////////
function refund_sms_notification_send($tourwise_id)
{
  $sq_personal_info = mysql_fetch_assoc(mysql_query("select mobile_no from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));
  $mobile_no = $sq_personal_info['mobile_no'];

  $message = "We are providing the refunds considering your cancellation request of the genuine reason. Pls, contact us for the future journey.";
  global $model;
  $model->send_message($mobile_no, $message);
}
/////////////Refund sms reminder send end/////////////////////////////////////////////////////////////////////////////////////////


}
?>