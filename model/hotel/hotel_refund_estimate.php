<?php 

$flag = true;

class hotel_refund_estimate{



public function refund_estimate_update()

{
  $row_spec='sales';
  $booking_id = $_POST['booking_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];



  begin_t();



  $sq_refund = mysql_query("update hotel_booking_master set cancel_amount='$cancel_amount', refund_total_fee='$total_refund_amount'  where booking_id='$booking_id'");

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



public function finance_save($booking_id,$row_spec)

{

	$booking_id = $_POST['booking_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  $created_at = date("Y-m-d");
	$year2 = explode("-", $created_at);
  $yr1 =$year2[0];

  $sq_hotel_info = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
  $customer_id = $sq_hotel_info['customer_id'];
  $service_tax_subtotal = $sq_hotel_info['service_tax_subtotal'];
  $hotel_amount = $sq_hotel_info['sub_total'];
  $service_charge = $sq_hotel_info['service_charge'];
  $reflections = json_decode($sq_hotel_info['reflections']);
  $roundoff = $sq_hotel_info['roundoff'];
  $markup = $sq_hotel_info['markup'];
  $service_tax_markup = $sq_hotel_info['markup_tax'];

  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  
  //Particular
  $sq_ct = mysql_fetch_assoc(mysql_query("select first_name,last_name from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
  $sq_htm = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$booking_id'"));
  $sq_hte = mysql_fetch_assoc(mysql_query("select * from hotel_booking_entries where booking_id='$booking_id'"));

  $sq_ht = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id='$sq_hte[hotel_id]'"));
  $hotel_name = $sq_ht['hotel_name'];
  global $transaction_master;
    //////////Sales/////////////

    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $hotel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $hotel_amount, $customer_id);
    $ledger_particular = '';
    $gl_id = 64;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    /////////Service Charge////////
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $service_charge, $customer_id);
    $ledger_particular = '';
    $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 186;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    
    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Hotel Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $created_at;
      $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $service_charge, $customer_id);
      $ledger_particular = '';
      $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    }

    	///////////Markup//////////
      $module_name = "Hotel Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $markup;
      $payment_date = $created_at;
      $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $markup, $customer_id);
      $ledger_particular = '';
      $gl_id = ($reflections[0]->hotel_markup != '') ? $reflections[0]->hotel_markup : 198;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
  
      /////////Markup Tax Amount////////
      // Eg. CGST:(9%):24.77, SGST:(9%):24.77
      $service_tax_markup = explode(',',$service_tax_markup);
      $tax_ledgers = explode(',',$reflections[0]->hotel_markup_taxes);
      for($i=0;$i<sizeof($service_tax_markup);$i++){
  
        $service_tax = explode(':',$service_tax_markup[$i]);
        $tax_amount = $service_tax[2];
        $ledger = $tax_ledgers[$i];
  
        $module_name = "Hotel Booking";
        $module_entry_id = $booking_id;
        $transaction_id = "";
        $payment_amount = $tax_amount;
        $payment_date = $created_at;
        $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $tax_amount, $customer_id);
        $ledger_particular = '';
        $gl_id = $ledger;
        $payment_side = "Debit";
        $clearance_status = "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');
    }

    //////////Discount/////////////

    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_hotel_info['discount'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $sq_hotel_info['discount'], $customer_id);
    $ledger_particular = '';
    $gl_id = 36;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    //////////TDS/////////////

    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_hotel_info['tds'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $sq_hotel_info['tds'], $customer_id);
    $ledger_particular = '';
    $gl_id = 127;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    ////Roundoff Value
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $roundoff, $customer_id);
    $ledger_particular = '';
    $gl_id = 230;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////////Customer Sale Amount//////
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_hotel_info['total_fee'];
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $created_at, $sq_hotel_info['total_fee'], $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = 161;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Customer Cancel Amount//////
    $module_name = "Hotel Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_hotel_booking_id($booking_id,$yr1), $customer_id);
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND'); 

 
}

}

?>