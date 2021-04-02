<?php 
$flag = true;
class tour_cancelation_and_refund{

///////////// Cancel Tour Group start/////////////////////////////////////////////////////////////////////////////////////////
public function cancel_tour_group($tour_id, $tour_group_id)
{
  begin_t();
  for($i=0; $i<sizeof($tour_group_id); $i++)
  { 
    $sq1 = mysql_query("update tour_groups set status='Cancel' where tour_id='$tour_id' and group_id='$tour_group_id[$i]' ");
    if(!$sq1){
      $GLOBALS['flag'] = false;
    }

    $sq2 = mysql_query("update tourwise_traveler_details set tour_group_status='Cancel' where tour_id='$tour_id' and tour_group_id='$tour_group_id[$i]' ");
    if(!$sq2){
      $GLOBALS['flag'] = false;
    }
  } 

  if($GLOBALS['flag']){
    commit_t();
    echo "Tour has been successfully Cancelled.";
    exit;  
  }
  else{
    rollback_t();
    echo "Error in cancellation";
    exit;
  }
  
}
///////////// Cancel Tout Group End/////////////////////////////////////////////////////////////////////////////////////////

///////////// Refund Tour Group Fee Start/////////////////////////////////////////////////////////////////////////////////////////
public function refund_tour_group_fee_save()
{
  $tourwise_id = $_POST['tourwise_id'];
  $traveler_id = $_POST['traveler_id'];
  $refund_amount = $_POST['refund_amount'];
  $refund_date = $_POST['refund_date'];
  $refund_mode = $_POST['refund_mode'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $bank_id = $_POST['bank_id'];

  $clearance_status = ($refund_mode=="Cheque") ? "Pending" : "";
  $created_at = date('Y-m-d H:i:s');

  $financial_year_id = $_SESSION['financial_year_id']; 
  $branch_admin_id = $_SESSION['branch_admin_id'];

  $bank_balance_status = bank_cash_balance_check($refund_mode, $bank_id, $refund_amount);
  if(!$bank_balance_status){ echo bank_cash_balance_error_msg($refund_mode, $bank_id); exit; }  

  begin_t();

  $row2=mysql_query("select max(refund_id) as max from refund_tour_cancelation");
  $value2=mysql_fetch_assoc($row2);
  $max2=$value2['max']+1;

  $refund_date=date("Y-m-d", strtotime($refund_date));  
 
  $sq = mysql_query(" insert into refund_tour_cancelation(refund_id, tourwise_traveler_id, financial_year_id, traveler_id, refund_amount, refund_date, refund_mode, bank_name, transaction_id, bank_id, clearance_status) values ( '$max2', '$tourwise_id', '$financial_year_id', '$traveler_id', '$refund_amount', '$refund_date', '$refund_mode', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status') ");

  if($refund_mode == 'Credit Note'){
    $sq_group_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
    $customer_id = $sq_group_info['customer_id'];
        
    $sq_max = mysql_fetch_assoc(mysql_query("select max(id) as max from credit_note_master"));
    $id = $sq_max['max'] + 1;

    $sq_payment = mysql_query("insert into credit_note_master (id, financial_year_id, module_name, module_entry_id, customer_id, payment_amount,refund_id,created_at,branch_admin_id) values ('$id', '$financial_year_id', 'Group Booking', '$tourwise_id', '$customer_id','$refund_amount','$max2','$refund_date','$branch_admin_id') ");
  }
  if(!$sq)
  {
    rollback_t();
    echo "Refund not saved!";
    exit;
  }  
  else
  {

    if($refund_mode != 'Credit Note'){
      //Finance save
        $this->finance_save($max2);
    }

     //Bank and Cash Book Save
     $this->bank_cash_book_save($max2);

    if($GLOBALS['flag']){
      commit_t();
      //Refund sms notification send
      if($refund_amount!=0){
        $this->refund_sms_notification_send($tourwise_id);
      }
      //echo "Saved Successfully!";
      echo "Refund has been successfully saved.";  
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
  $traveler_id = $_POST['traveler_id'];
  $refund_amount = $_POST['refund_amount'];
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

  $particular = 'Payment through '.$refund_mode.' '.$tour_name.' for '.$cust_name.' for '.$numberOfNights.' Nights starting from '.get_date_user($sq_tourgroup['from_date']);

  ////////Refund Amount//////
    $module_name = "Group Booking Refund Paid";
    $module_entry_id = $tourwise_id;
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
    $module_name = "Group Booking Refund Paid";
    $module_entry_id = $tourwise_id;
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
  $tourwise_id = $_POST['tourwise_id'];
  $refund_charges = $_POST['refund_charges'];
  $refund_date = $_POST['refund_date'];
  $refund_amount = $_POST['refund_amount'];
  $refund_mode = $_POST['refund_mode'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id']; 
  $bank_id = $_POST['bank_id'];

  global $bank_cash_book_master;
  $refund_date = date('Y-m-d', strtotime($refund_date));
  $yr = explode("-", $refund_date);
  $year =$yr[0];

  $sq_group_info = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
  $customer_id = $sq_group_info['customer_id'];
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  $sq_tour = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$sq_group_info[tour_id]'"));
  $tour_name = $sq_tour['tour_name'];
  $sq_tourgroup = mysql_fetch_assoc(mysql_query("select from_date,to_date from tour_groups where group_id='$sq_group_info[tour_group_id]'"));
  $from_date = new DateTime($sq_tourgroup['from_date']);
  $to_date = new DateTime($sq_tourgroup['to_date']);
  $numberOfNights= $from_date->diff($to_date)->format("%a");

  $particular = 'Payment through '.$refund_mode.' '.$tour_name.' for '.$cust_name.' for '.$numberOfNights.' Nights starting from '.get_date_user($sq_tourgroup['from_date']);

  $module_name = "Group Booking Refund Paid";
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
///////////// Refund Tour Group Fee End/////////////////////////////////////////////////////////////////////////////////////////

///////////// Extra travel amount refund status update start/////////////////////////////////////////////////////////////////////////////////////////

function extra_travel_amount_refund_status_update()
{
  $tourwise_id = $_POST['tourwise_id'];
  $refund_mode = $_POST['refund_mode'];
  $refund_amount = $_POST['refund_amount'];
  $refund_date = date('Y-m-d');

  $refund_id = mysql_fetch_assoc(mysql_query("select max(refund_id) as max from refund_travel_extra_amount"));
  $refund_id = $refund_id['max']+1;

  $sq_refund = mysql_query("insert into refund_travel_extra_amount ( refund_id, tourwise_traveler_id, refund_amount, refund_mode, refund_date ) values ( '$refund_id', '$tourwise_id', '$refund_amount', '$refund_mode', '$refund_date' )");
  if($sq_refund)
  {  

    echo "Refund has been successfully saved.";
    exit;
  }
  else
  {
    echo "error--Refund not saved successfully";
    exit;
  }  
}

///////////// Extra travel amount refund status update end/////////////////////////////////////////////////////////////////////////////////////////

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