<?php 

$flag = true;
class b2b_refund_estimate{
    function refund_estimate(){
        $row_spec='sales';
        $booking_id = $_POST['booking_id'];
        $cancel_amount = $_POST['cancel_amount'];
        $total_refund_amount = $_POST['total_refund_amount'];
        begin_t();

        $sq_refund = mysql_query("update b2b_booking_master set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount'  where booking_id='$booking_id'");

        if($sq_refund){
     	    //Finance save

            $this->finance_save($booking_id,$row_spec);

      	    if($GLOBALS['flag']){
                commit_t();
                echo "Refund estimate has been successfully saved.";
                exit;
      	    }
      	    else{
  		        rollback_t();
  		        exit;
  	        }
        }
        else{
          	rollback_t();
            echo "Refund estimate has not been saved!";
          	exit;
        }
    }
    
    public function finance_save($booking_id,$row_spec){

	$booking_id = $_POST['booking_id'];
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];
    
    $final_total = $_POST['final_total'];
    $main_tax_total = $_POST['main_tax_total'];
    $taxation_type = $_POST['taxation_type'];
    $total_booking = $_POST['total_booking'];

    $created_at = date("Y-m-d");
    $year2 = explode("-", $created_at);
    $yr1 =$year2[0];

    $sq_b2b_info = mysql_fetch_assoc(mysql_query("select * from b2b_booking_master where booking_id='$booking_id'"));
    $customer_id = $sq_b2b_info['customer_id'];

    //Getting customer Ledger
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust['ledger_id'];

    global $transaction_master;
    //////////Sales/////////////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $total_booking;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $created_at, $final_total, $customer_id);
    $ledger_particular = ''; 
    $gl_id = 177;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    /////////Tax Amount/////////
    tax_cancel_reflection_update('B2B Booking',$main_tax_total,$taxation_type,$booking_id,get_b2b_booking_id($booking_id,$yr1),$created_at, $customer_id, $row_spec);

    ////////Customer Sale Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $final_total;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $created_at, $final_total, $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = 161;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Customer Cancel Amount//////
    $module_name = "B2B Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_b2b_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND'); 
}
}