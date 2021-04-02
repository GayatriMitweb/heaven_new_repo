<?php
$flag = true;
class refund_estimate{
public function refund_estimate_update(){
  $row_spec ='sales';
  $booking_id = $_POST['booking_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  begin_t();
  $sq_refund = mysql_query("update car_rental_booking set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount' where booking_id='$booking_id'");
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
  	echo "Refund not saved!";
  	exit;
  }
}

public function finance_save($booking_id,$row_spec){
	$booking_id = $_POST['booking_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  $created_at = date("Y-m-d");
	$year1 = explode("-", $created_at);
	$yr1 =$year1[0];

  $sq_car_info = mysql_fetch_assoc(mysql_query("select * from car_rental_booking where booking_id='$booking_id'"));
  $customer_id = $sq_car_info['customer_id'];
  $taxation_type = $sq_car_info['taxation_type'];
  $service_tax_subtotal = $sq_car_info['service_tax_subtotal'];
  $service_charge = $sq_car_info['service_charge'];
  $markup = $sq_car_info['markup_cost'];
  $service_tax_markup = $sq_car_info['markup_cost_subtotal'];
  $reflections = json_decode($sq_car_info['reflections']);

  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];

  $car_sale_amount = $sq_car_info['other_charges'] + $sq_car_info['basic_amount'] + $sq_car_info['driver_allowance'] + $sq_car_info['permit_charges'] + $sq_car_info['toll_and_parking'] + $sq_car_info['state_entry_tax'];
  
  global $transaction_master;

    //////////Sales/////////////

    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $car_sale_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 19;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    ////////////service charge/////////////
    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_car_rental_booking_id($booking_id,$yr1), $created_at, $service_charge, $customer_id);
    $ledger_particular = '';
    $gl_id = ($reflections[0]->car_sc != '') ? $reflections[0]->car_sc : 191;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    
    /////////Service Charge Tax Amount////////
    $service_tax_subtotal = explode(',',$service_tax_subtotal);
    $tax_ledgers = explode(',',$reflections[0]->car_taxes);
    for($i=0;$i<sizeof($service_tax_subtotal);$i++){

      $service_tax = explode(':',$service_tax_subtotal[$i]);
      $tax_amount = $service_tax[2];
      $ledger = $tax_ledgers[$i];

      $module_name = "Car Rental Booking";
      $module_entry_id = $booking_id;
      $transaction_id = "";
      $payment_amount = $tax_amount;
      $payment_date = $created_at;
      $payment_particular = get_cancel_sales_particular(get_car_rental_booking_id($booking_id,$yr1), $created_at, $tax_amount, $customer_id);
      $ledger_particular = '';
      $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
  }

  ////////////markup/////////////
  $module_name = "Car Rental Booking";
  $module_entry_id = $booking_id;
  $transaction_id = "";
  $payment_amount = $markup;
  $payment_date = $created_at;
  $payment_particular = get_cancel_sales_particular(get_car_rental_booking_id($booking_id,$yr1), $created_at, $markup, $customer_id);
  $ledger_particular = '';
  $gl_id = ($reflections[0]->car_markup != '') ? $reflections[0]->car_markup : 203;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

  /////////Markup Tax Amount////////
  // Eg. CGST:(9%):24.77, SGST:(9%):24.77
  $service_tax_markup = explode(',',$service_tax_markup);
  $tax_ledgers = explode(',',$reflections[0]->car_markup_taxes);
  for($i=0;$i<sizeof($service_tax_markup);$i++){

    $service_tax = explode(':',$service_tax_markup[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $created_at;
    $payment_particular = get_cancel_sales_particular(get_car_rental_booking_id($booking_id,$yr1), $created_at, $tax_amount, $customer_id);
    $ledger_particular = '';
    $gl_id = $ledger;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
  }

    ////////Customer Sale Amount//////
    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_car_info['total_fees'];
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////Roundoff Value
    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_car_info['roundoff'];
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 230;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////////Cancel Amount//////
    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 161;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Customer Cancel Amount//////
    $module_name = "Car Rental Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cancel_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND'); 
  
}

}
?>