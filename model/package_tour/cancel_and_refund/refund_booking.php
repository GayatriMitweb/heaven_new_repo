<?php 
$flag = true;
class refund_booking{


///////////////////////////////////////Refund canceled traveler booking save start////////////////////////////////////////////////////////////////////////////// 
public function refund_canceled_traveler_save()
{

  $unique_timestamp = $_POST['unique_timestamp'];
  $booking_id = $_POST['booking_id'];

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

  $timestamp_count = mysql_num_rows( mysql_query("select refund_id from package_refund_traveler_cancelation where unique_timestamp='$unique_timestamp'") );
  if($timestamp_count>0)
  {
    echo "Sorry, Timestamp exists already.";
    exit;
  }
  
  $clearance_status = ($refund_mode=="Cheque") ? "Pending" : "";

  $financial_year_id = $_SESSION['financial_year_id'];   
  $branch_admin_id = $_SESSION['branch_admin_id'];

  begin_t();

  $sq_max_id = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from package_refund_traveler_cancelation"));
  $max_id = $sq_max_id['max']+1;

  $sq_refund = mysql_query("insert into package_refund_traveler_cancelation (refund_id, booking_id, financial_year_id, total_refund, refund_mode, refund_date, transaction_id, bank_name, bank_id, clearance_status, created_at, unique_timestamp) values ('$max_id', '$booking_id', '$financial_year_id', '$total_refund', '$refund_mode', '$refund_date', '$transaction_id', '$bank_name', '$bank_id', '$clearance_status', '$created_at', '$unique_timestamp' )");

  if($refund_mode == 'Credit Note'){
    $sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_package_info['customer_id'];
        
    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
    $id = $sq_max['max'] + 1;

    $sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$id', '$financial_year_id', 'Package Booking', '$booking_id', '$customer_id','$total_refund','$max_id','$refund_date','$branch_admin_id') ");
  }

  if(!$sq_refund)
  {
    rollback_t();
    echo "Refund not saved!";
    exit;
  }  
  else
  {
    for($i=0; $i<sizeof($traveler_id_arr); $i++)
    {
      $sq_max_entry_id = mysql_fetch_assoc( mysql_query("select max(id) as max from package_refund_traveler_cancalation_entries") );
      $max_entry_id = $sq_max_entry_id['max']+1;
      $sq_refund_entry = mysql_query("insert into package_refund_traveler_cancalation_entries (id, refund_id, traveler_id) values ('$max_entry_id', '$max_id', '$traveler_id_arr[$i]')");
      if(!$sq_refund_entry)
      {
        $GLOBALS['flag'] = false;
        echo "Traveler name not saved properly.";
        //exit;
      }  
    }

    //Finance Save
    $this->finance_save($max_id);

    //Bank and Cash Book Save
    $this->bank_cash_book_save($max_id);
    if($total_refund!=0){
      $this->refund_mail_send($max_id,$total_refund,$refund_date,$refund_mode,$transaction_id,$booking_id);
    }
    if($GLOBALS['flag']){
      commit_t();
      echo "Refund has been successfully saved.";  
      exit;
    }
    else{
      rollback_t();
      exit;
    }

    
  }  
}

public function finance_save($refund_id)
{
  $row_spec = 'sales';
  $booking_id = $_POST['booking_id'];
  $refund_date = $_POST['refund_date'];
  $total_refund = $_POST['total_refund'];
  $refund_mode = $_POST['refund_mode'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $bank_id = $_POST['bank_id']; 
  $entry_id_arr = $_POST['entry_id_arr']; 

  $refund_date = date('Y-m-d', strtotime($refund_date));
  $year1 = explode("-", $refund_date);
  $yr1 =$year1[0];

  global $transaction_master;

  $sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $customer_id = $sq_package_info['customer_id'];
  $year1 = explode("-", $sq_package_info['booking_date']);
  $year =$year1[0];

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


  ////////Refund Amount//////
  $module_name = "Package Booking Traveller Refund Paid";
  $module_entry_id = $booking_id;
  $transaction_id = $transaction_id;
  $payment_amount = $total_refund;
  $payment_date = $refund_date;
  $payment_particular = get_refund_paid_particular(get_package_booking_id($booking_id,$year), $refund_date, $total_refund, $refund_mode,get_package_booking_refund_id($refund_id,$yr1));
  $ledger_particular = '';
  $gl_id = $pay_gl;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);  

  ////////Refund Amount//////
  $module_name = "Package Booking Traveller Refund Paid";
  $module_entry_id = $booking_id;
  $transaction_id = $transaction_id;
  $payment_amount = $total_refund;
  $payment_date = $refund_date;
  $payment_particular = get_refund_paid_particular(get_package_booking_id($booking_id,$year), $refund_date, $total_refund, $refund_mode,get_package_booking_refund_id($refund_id,$yr1));
  $ledger_particular = '';
  $gl_id = $cust_gl;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,$type);
}


public function bank_cash_book_save($payment_id)
{
  global $bank_cash_book_master;

  $booking_id = $_POST['booking_id'];

  $refund_charges = $_POST['refund_charges'];
  $train_refund = $_POST['train_refund'];
  $plane_refund = $_POST['plane_refund'];
  $total_travel_refund = $_POST['total_travel_refund'];
  $total_tour_refund = $_POST['total_tour_refund'];

  $total_refund = $_POST['total_refund'];
  $refund_mode = $_POST['refund_mode'];
  $refund_date = $_POST['refund_date'];
  $transaction_id = $_POST['transaction_id'];
  $bank_name = $_POST['bank_name'];
  $bank_id = $_POST['bank_id'];
  $traveler_id_arr = $_POST['traveler_id_arr'];
  
  $sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $customer_id = $sq_package_info['customer_id'];
  $year1 = explode("-", $sq_package_info['booking_date']);
  $year =$year1[0];
  
  $refund_date = date('Y-m-d', strtotime($refund_date));
  $year1 = explode("-", $refund_date);
  $yr =$year1[0];
  
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];;
  $particular = 'Payment through '.$refund_mode.' '.get_package_booking_id($booking_id,$yr1).' for '.$sq_package_info['tour_name'].' for '.$cust_name.' for '.$sq_package_info['total_tour_days'].' Nights starting from '.get_date_user($sq_package_info['tour_from_date']);

  $module_name = "Package Booking Traveller Refund Paid";
  $module_entry_id = $payment_id;
  $payment_date = $refund_date;
  $payment_amount = $total_refund;
  $payment_mode = $refund_mode;
  $bank_name = $bank_name;
  $transaction_id = $transaction_id;
  $bank_id = $bank_id;
  $particular = $particular;
  $clearance_status = ($payment_mode=="Cheque") ? "Pending" : "";
  $payment_side = "Credit";
  $payment_type = ($refund_mode=="Cash") ? "Cash" : "Bank";

  $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);
  
}
///////////////////////////////////////Refund canceled traveler booking save end////////////////////////////////////////////////////////////////////////////// 

public function refund_mail_send($max_id,$total_refund,$refund_date,$refund_mode,$transaction_id,$booking_id){
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$currency_logo;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
   
  $sq_package_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $date = $sq_package_info['booking_date'];
  $yr = explode("-", $date);
  $year =$yr[0];

  $sq_total_tour_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and payment_for='Tour' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

$sq_total_travel_paid_amount = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and payment_for='Travelling' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));
$sq_refund_estimate = mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$booking_id'"));

$sq_total_ref_paid_amount = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id'"));
$sq_cancelled = mysql_fetch_assoc(mysql_query("select sum(total_refund) as sum from package_refund_traveler_cancelation where booking_id='$booking_id' and clearance_status='Cancelled' "));
$sale_Amount=$sq_package_info['total_travel_expense']+$sq_package_info['actual_tour_expense'];
$paid_amount = $sq_total_travel_paid_amount['sum']+ $sq_total_tour_paid_amount['sum'];
$cancel_amount = $sq_refund_estimate['cancel_amount'];

  $content = ' 
    <tr>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Service Type</td>   <td style="text-align:left;border: 1px solid #888888;">Package Tour</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Selling Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sale_Amount,2).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($paid_amount,2).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Cancellation Charges</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($cancel_amount,2).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Refund Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($total_refund,2).'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Refund Mode</td>   <td style="text-align:left;border: 1px solid #888888;">'.$refund_mode.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Refund Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($refund_date).'</td></tr>
        </table>
    </tr>';

    // if($transaction_id!= ''){ $content .= ' <tr><td style="text-align:left;border: 1px solid #888888;">Cheque No/ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$transaction_id.'</td></tr>';
    // }
          $content .= '</tr>';

  $subject = 'Tour Cancellation Refund (Booking ID : '.get_package_booking_id($booking_id,$year).' , Tour Name : '.$sq_package_info['tour_name'].' )';
  global $model;
 
  $model->app_email_send('29',$sq_package_info['contact_person_name'],$sq_package_info['email_id'], $content,$subject);
}

}
?>