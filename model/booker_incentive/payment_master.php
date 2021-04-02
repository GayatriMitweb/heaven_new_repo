<?php 

$flag = true;

class payment_master{



public function payment_save(){



  $emp_id = $_POST['emp_id'];

  $payment_amount = $_POST['payment_amount'];

  $payment_date = $_POST['payment_date'];

  $payment_mode = $_POST['payment_mode'];

  $bank_name = $_POST['bank_name'];

  $transaction_id = $_POST['transaction_id'];

  $bank_id = $_POST['bank_id'];
  $branch_admin_id = $_POST['branch_admin_id'];


  $created_at = date('Y-m-d H:i:s');

  $payment_date = date('Y-m-d', strtotime($payment_date));



  $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";



  $financial_year_id = $_SESSION['financial_year_id'];



  begin_t();



  $sq_max = mysql_fetch_assoc(mysql_query("select max(payment_id) as max from booker_incentive_payment_master"));

  $payment_id = $sq_max['max']+1;

  

  $sq_payment = mysql_query("insert into booker_incentive_payment_master(payment_id, emp_id, financial_year_id, branch_admin_id, payment_date, payment_mode, payment_amount, bank_name, transaction_id, bank_id, clearance_status, created_at) values ('$payment_id', '$emp_id', '$financial_year_id', '$branch_admin_id', '$payment_date', '$payment_mode', '$payment_amount', '$bank_name', '$transaction_id', '$bank_id', '$clearance_status', '$created_at')");

  if(!$sq_payment){

    rollback_t();

	  echo "error--Sorry, Payment not done!";

	  exit;

  }

  else{



    //Finance save

     $this->finance_save($payment_id);



    //Bank and Cash Book Save

     $this->bank_cash_book_save($payment_id);



    if($GLOBALS['flag']){

      commit_t();

      echo "Payment has been successfully saved.";

      exit;  

    }

    else{

      rollback_t();

      exit;

    }

    

  }



}





public function finance_save($payment_id)

{

    $emp_id = $_POST['emp_id'];

    $payment_amount1 = $_POST['payment_amount'];

    $payment_date = $_POST['payment_date'];

    $payment_mode = $_POST['payment_mode'];

    $bank_name = $_POST['bank_name'];

    $transaction_id1 = $_POST['transaction_id'];

    $bank_id1 = $_POST['bank_id'];



    $payment_date = date('Y-m-d', strtotime($payment_date));



    global $transaction_master;

    global $cash_in_hand, $bank_account, $sundry_creditor;



    //***========================Debit side entries start=============================***//

    //***Payment amount save***//

    $module_name = 'Booker Incentive Payment';

    $module_entry_id = $payment_id;

    $transaction_type = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular = get_incentive_paid_particular($emp_id);

    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;

    $payment_side = "Credit";

    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_type, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);



    //***Sundry debitor save***//

    $module_name = 'Booker Incentive Payment';

    $module_entry_id = $payment_id;

    $transaction_type = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular =get_incentive_paid_particular($emp_id);;

    $gl_id = '146';

    $payment_side = "Debit";

    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_type, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);    

    //***========================Debit side entries end=============================***//

}



public function bank_cash_book_save($payment_id)

{

    global $bank_cash_book_master;



    $emp_id = $_POST['emp_id'];

    $payment_amount = $_POST['payment_amount'];

    $payment_date = $_POST['payment_date'];

    $payment_mode = $_POST['payment_mode'];

    $bank_name = $_POST['bank_name'];

    $transaction_id = $_POST['transaction_id'];

    $bank_id = $_POST['bank_id'];



    //$sq_car_rental_info = mysql_fetch_assoc(mysql_query("select customer_id from car_rental_booking where booking_id='$booking_id'"));



    $module_name = "Booker Incentive Payment";

    $module_entry_id =$payment_id;

    $payment_date = $payment_date;

    $payment_amount = $payment_amount;

    $payment_mode = $payment_mode;

    $bank_name = $bank_name;

    $transaction_id = $transaction_id;

    $bank_id = $bank_id;

    $particular = get_incentive_paid_particular($emp_id);

    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

    $payment_side = "Credit";

    $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

    $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);



} 



public function payment_update()

{

  $payment_id = $_POST['payment_id'];

  $emp_id = $_POST['emp_id'];

  $payment_amount = $_POST['payment_amount'];

  $payment_date = $_POST['payment_date'];

  $payment_mode = $_POST['payment_mode'];

  $bank_name = $_POST['bank_name'];

  $transaction_id = $_POST['transaction_id'];

  $bank_id = $_POST['bank_id'];



  $payment_date = date('Y-m-d', strtotime($payment_date));



  $financial_year_id = $_SESSION['financial_year_id'];



  $sq_payment_info = mysql_fetch_assoc(mysql_query("select * from booker_incentive_payment_master where payment_id='$payment_id'"));



  $clearance_status = ($sq_payment_info['payment_mode']=='Cash' && $payment_mode!="Cash") ? "Pending" : $sq_payment_info['clearance_status'];

  if($payment_mode=="Cash"){ $clearance_status = ""; }



  begin_t();

  

  $sq_payment = mysql_query("update booker_incentive_payment_master set emp_id='$emp_id', financial_year_id='$financial_year_id', payment_date='$payment_date', payment_mode='$payment_mode', payment_amount='$payment_amount', bank_name='$bank_name', transaction_id='$transaction_id', bank_id='$bank_id', clearance_status='$clearance_status' where payment_id='$payment_id' ");

  if(!$sq_payment){

    rollback_t();

	  echo "error--Sorry, Payment not updated!";

	  exit;

  }

  else{



    //Finance Update

    //$this->finance_update($sq_payment_info, $clearance_status);



    //Bank and Cash Book Save

    $this->bank_cash_book_update($clearance_status);



    if($GLOBALS['flag']){

      commit_t();

      echo "Payment has been successfully saved.";

      exit;  

    }

    else{

      rollback_t();

      exit;

    }

    

  }



}

/*

public function finance_update($sq_payment_info, $clearance_status1)

{

    $booking_id = $_POST['booking_id'];

    $payment_id = $_POST['payment_id'];

    $payment_amount1 = $_POST['payment_amount'];

    $payment_date = $_POST['payment_date'];

    $payment_mode = $_POST['payment_mode'];

    $bank_name = $_POST['bank_name'];

    $transaction_id1 = $_POST['transaction_id'];

    $bank_id1 = $_POST['bank_id'];



    $payment_date = date('Y-m-d', strtotime($payment_date));



    $sq_car_rental_info = mysql_fetch_assoc(mysql_query("select customer_id from car_rental_booking where booking_id='$booking_id'"));



    global $transaction_master;

    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets;

*/



    //***========================Debit side entries start=============================***//

    //***Payment amount save***//

   /* $module_name = 'Car Rental Booking Payment';

    $module_entry_id = $payment_id;

    $transaction_id = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular = get_sales_paid_particular(get_car_rental_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_car_rental_info['customer_id'], $payment_mode, get_car_rental_booking_id($booking_id));

    $old_gl_id = ($sq_payment_info['payment_mode']=="Cash") ? $cash_in_hand : $bank_account;

    $gl_id = ($payment_mode=="Cash") ? $cash_in_hand : $bank_account;

    $payment_side = "Debit";

    $clearance_status = $clearance_status1;

    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);

*/

    //***Sundry debitor save***//

 /*   $module_name = 'Car Rental Booking Payment';

    $module_entry_id = $payment_id;

    $transaction_id = $transaction_id1;

    $payment_amount = $payment_amount1;

    $payment_date = $payment_date;

    $payment_particular = get_sales_paid_particular(get_car_rental_booking_payment_id($payment_id), $payment_date, $payment_amount1, $sq_car_rental_info['customer_id'], $payment_mode, get_car_rental_booking_id($booking_id));

    $old_gl_id = $gl_id = $sundry_debitor;

    $payment_side = "Credit";

    $clearance_status = $clearance_status1;

    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status); */

    //***========================Debit side entries end=============================***//

//}



public function bank_cash_book_update($clearance_status)

{

    global $bank_cash_book_master;



    $booking_id = $_POST['booking_id'];

    $payment_id = $_POST['payment_id'];

    $emp_id = $_POST['emp_id'];

    $payment_amount = $_POST['payment_amount'];

    $payment_date = $_POST['payment_date'];

    $payment_mode = $_POST['payment_mode'];

    $bank_name = $_POST['bank_name'];

    $transaction_id = $_POST['transaction_id'];

    $bank_id = $_POST['bank_id'];



   $module_name = "Booker Incentive Payment";

    $module_entry_id =$payment_id;

    $payment_date = $payment_date;

    $payment_amount = $payment_amount;

    $payment_mode = $payment_mode;

    $bank_name = $bank_name;

    $transaction_id = $transaction_id;

    $bank_id = $bank_id;

    $particular = get_incentive_paid_particular($emp_id);

    $clearance_status = ($payment_mode!="Cash") ? "Pending" : "";

    $payment_side = "Credit";

    $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";

    $bank_cash_book_master->bank_cash_book_master_update($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type);



} 



//////////////////////////////////**Payment email notification send start**/////////////////////////////////////

/*

public function payment_email_notification_send($booking_id, $payment_amount, $payment_mode, $payment_date, $payment_id)

{

   $sq_car_rental = mysql_fetch_assoc(mysql_query("select customer_id, total_fees from car_rental_booking where booking_id='$booking_id'"));

   $total_amount = $sq_car_rental['total_fees'];



   $sq_customer_info = mysql_fetch_assoc(mysql_query("select email_id from customer_master where customer_id='$sq_car_rental[customer_id]'"));

   $email_id = $sq_customer_info['email_id'];



   $sq_total_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from car_rental_payment where booking_id='$booking_id'"));

   $paid_amount = $sq_total_amount['sum'];



   $payment_id = get_car_rental_booking_payment_id($payment_id);



   global $model;

   $model->generic_payment_mail($payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $email_id, $payment_id);

}  */

//////////////////////////////////**Payment email notification send end**/////////////////////////////////////



//////////////////////////////////**Payment sms notification send start**/////////////////////////////////////

/*public function payment_sms_notification_send($booking_id, $payment_amount, $payment_mode)

{

  $sq_car_rental = mysql_fetch_assoc(mysql_query("select customer_id from car_rental_booking where booking_id='$booking_id'"));

  $customer_id = $sq_car_rental['customer_id'];



  $sq_customer_info = mysql_fetch_assoc(mysql_query("select contact_no from customer_master where customer_id='$customer_id'"));

  $mobile_no = $sq_customer_info['contact_no'];



  $message = "Acknowledge your payment of Rs. ".$payment_amount.", ".$payment_mode." which we received for Visa installment.";

    global $model;

    $model->send_message($mobile_no, $message);

} */

//////////////////////////////////**Payment sms notification send end**/////////////////////////////////////



} 

?>