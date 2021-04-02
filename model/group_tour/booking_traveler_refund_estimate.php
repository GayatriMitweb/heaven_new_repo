<?php 

$flag = true;

class booking_traveler_refund_estimate{



public function refund_estimate_update()

{
    $row_spec ='sales';
    $tourwise_id = $_POST['tourwise_id'];
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];

    begin_t();

    $created_at = date('Y-m-d H:i:s');

    $sq_max = mysql_fetch_assoc(mysql_query("select max(estimate_id) as max from refund_traveler_estimate"));
    $estimate_id = $sq_max['max'] + 1;

    $sq_est = mysql_query("insert into refund_traveler_estimate(estimate_id, tourwise_traveler_id, cancel_amount, total_refund_amount, created_at) values ('$estimate_id', '$tourwise_id','$cancel_amount', '$total_refund_amount', '$created_at')");       

    if($sq_est){

        if($GLOBALS['flag']){

            commit_t();
            $this->finance_save($row_spec);
            echo "Refund estimate has been successfully saved!";
            exit;
        }
        else{
            rollback_t();
            exit;   
        }
    }
    else{
        rollback_t();
        echo "error--Sorry, Estimate not saved!";
        exit;
    }

}


public function finance_save($row_spec)
{
    $tourwise_id = $_POST['tourwise_id'];
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];

    $created_at = date("Y-m-d");
    $year = date('Y');
    $sq_booking = mysql_fetch_assoc(mysql_query("select * from tourwise_traveler_details where id='$tourwise_id'"));
    $customer_id = $sq_booking['customer_id'];
    $taxation_type = $sq_booking['taxation_type'];
    $total_discount = $sq_booking['repeater_discount'] + $sq_booking['adjustment_discount'];
    $total_sale_amount = $sq_booking['net_total']+$total_discount;
    $service_tax = $sq_booking['service_tax'];
    $reflections = json_decode($sq_booking['reflections']);

   //Getting customer Ledger
   $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
   $cust_gl = $sq_cust['ledger_id'];
   $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
   $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
   $sq_tour = mysql_fetch_assoc(mysql_query("select tour_name from tour_master where tour_id='$sq_booking[tour_id]'"));
   $tour_name = $sq_tour['tour_name'];
   $sq_tourgroup = mysql_fetch_assoc(mysql_query("select from_date,to_date from tour_groups where group_id='$sq_booking[tour_group_id]'"));
   $from_date = new DateTime($sq_tourgroup['from_date']);
   $to_date = new DateTime($sq_tourgroup['to_date']);
   $numberOfNights= $from_date->diff($to_date)->format("%a");
 
   $particular = 'Against Invoice no '.get_group_booking_id($tourwise_id,$year).' for '.$tour_name.' for '.$cust_name.' for '.$numberOfNights.' Nights starting from '.get_date_user($sq_tourgroup['from_date']);

   global $transaction_master;

    

    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    // $customer_amount = $sub_total+$service_charge+$markup+$tds-$discount;
    $service_tax_subtotal = explode(',',$service_tax);
    $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
    $total_tax = 0;
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $total_tax += $tax_amount;
      $ledger = $tax_ledgers[$i];

      $module_name = "Group Booking";
      $module_entry_id = $tourwise_traveler_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $created_at;
      $payment_particular = get_cancel_sales_particular(get_group_booking_id($tourwise_traveler_id,$yr1),$customer_id);
      $ledger_particular = '';
      $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    }
    //////////Sales/////////////

    $module_name = "Group Booking";
    $module_entry_id = $tourwise_id;
    $transaction_id = "";
    $payment_amount = $total_sale_amount - $total_tax;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 60;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    // Discount 
    $module_name = "Group Booking";
    $module_entry_id = $tourwise_id;
    $transaction_id = "";
    $payment_amount = $total_discount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 36;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////////Customer Sale Amount//////
    $module_name = "Group Booking";
    $module_entry_id = $tourwise_id;
    $transaction_id = "";
    $payment_amount = $sq_booking['net_total'];
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "Group Booking";
    $module_entry_id = $tourwise_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 161;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Customer Cancel Amount//////
    $module_name = "Group Booking";
    $module_entry_id = $tourwise_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
}

}

?>