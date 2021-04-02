<?php 
class booking_update_transaction{

public function finance_update($booking_id, $row_spec,$particular)
{
    global $transaction_master;
  $row_spec = 'sales';
  $customer_id = $_POST['customer_id'];
  $booking_date = $_POST['booking_date'];
  $taxation_type = $_POST['taxation_type'];


  //** Traveling information overall
  $train_expense = $_POST['train_expense'];
  $train_service_charge = $_POST['train_service_charge'];
  $train_taxation_id = $_POST['train_taxation_id'];
  $train_service_tax_subtotal = $_POST['train_service_tax_subtotal'];
  $total_train_expense = $_POST['total_train_expense'];
  
  $plane_expense = $_POST['plane_expense'];
  $plane_service_charge = $_POST['plane_service_charge'];
  $plane_taxation_id = $_POST['plane_taxation_id'];
  $plane_service_tax_subtotal = $_POST['plane_service_tax_subtotal'];
  $total_plane_expense = $_POST['total_plane_expense'];

  $cruise_expense = $_POST['cruise_expense'];
  $cruise_service_charge = $_POST['cruise_service_charge'];
  $cruise_taxation_id = $_POST['cruise_taxation_id'];
  $cruise_service_tax_subtotal = $_POST['cruise_service_tax_subtotal'];
  $total_cruise_expense = $_POST['total_cruise_expense'];
  
  $visa_amount = $_POST['visa_amount'];
  $visa_service_charge = $_POST['visa_service_charge'];
  $visa_taxation_id = $_POST['visa_taxation_id'];
  $visa_service_tax_subtotal = $_POST['visa_service_tax_subtotal'];
  $visa_total_amount = $_POST['visa_total_amount'];
  
  $insuarance_amount = $_POST['insuarance_amount'];
  $insuarance_service_charge = $_POST['insuarance_service_charge'];
  $insuarance_taxation_id = $_POST['insuarance_taxation_id'];
  $insuarance_service_tax_subtotal = $_POST['insuarance_service_tax_subtotal'];
  $insuarance_total_amount = $_POST['insuarance_total_amount'];


  //**tour details
  $service_charge = $_POST['service_charge'];
  $subtotal = $_POST['subtotal'];

	$service_tax_subtotal = $_POST['service_tax_subtotal'];
  $basic_amount = $_POST['basic_amount'];
  $subtotal_with_rue = $_POST['subtotal_with_rue'];
  $tour_taxation_id = $_POST['tour_taxation_id']; 
  $tour_service_tax = $_POST['tour_service_tax'];
  $tour_service_tax_subtotal = $_POST['tour_service_tax_subtotal'];
  $total_travel_expense = $_POST['total_travel_expense']; 
  $actual_tour_cost = $_POST['actual_tour_cost']; 
  $net_total = $_POST['net_total'];

  //**Payment details
  $payment_date = $_POST['payment_date'];
  $payment_amount = $_POST['payment_amount'];
  $roundoff = $_POST['roundoff'];
  $booking_date = get_date_db($booking_date);
	$year1 = explode("-", $booking_date);
	$yr1 =$year1[0];
   //Getting customer Ledger
   $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
   $cust_gl = $sq_cust['ledger_id'];

   $reflections = json_decode(json_encode($_POST['reflections']));
   
   $bsmValues = json_decode(json_encode($_POST['bsmValues']));
     foreach($bsmValues[0] as $key => $value){
         switch($key){
         case 'basic' : $basic_amount = ($value != "") ? $value : $basic_amount;break;
         case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
         case 'markup' : $markup = ($value != "") ? $value : $markup;break;
         case 'discount' : $discount = ($value != "") ? $value : $discount;break;
         }
       }
   
   $total_sale_amount = $basic_amount;
  // $total_sale_amount = $train_expense + $train_service_charge + $plane_expense + $plane_service_charge + $cruise_expense + $cruise_service_charge + $visa_amount + $visa_service_charge + $insuarance_amount + $insuarance_service_charge + $subtotal_with_rue;

  // $tax_amount = $train_service_tax_subtotal + $plane_service_tax_subtotal + $cruise_service_tax_subtotal + $visa_service_tax_subtotal + $insuarance_service_tax_subtotal + $tour_service_tax_subtotal;
  ////////////Sales/////////////

    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $total_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('By','Cash/Bank');
    $old_gl_id = $gl_id = 91;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

    ////////////service charge/////////////
  $module_name = "Package Booking";
  $module_entry_id = $booking_id;
  $transaction_id = "";
  $payment_amount = $service_charge;
  $payment_date = $booking_date;
  $payment_particular = $particular;
  $ledger_particular = get_ledger_particular('To','Package Sales');
  $old_gl_id = $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 185;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

  /////////Service Charge Tax Amount////////
  // Eg. CGST:(9%):24.77, SGST:(9%):24.77
  $service_tax_subtotal = explode(',',$tour_service_tax_subtotal);
  $tax_ledgers = explode(',',$reflections[0]->hotel_taxes);
  for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $tax_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Package Sales');
    $old_gl_id = $gl_id = $ledger;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
  }
 
    /////////roundoff/////////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Package Sales');
    $old_gl_id = $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
   ////////Customer Amount//////
   $module_name = "Package Booking";
   $module_entry_id = $booking_id;
   $transaction_id = "";
   $payment_amount = $net_total;
   $payment_date = $booking_date;
   $payment_particular = $particular;
   $ledger_particular = get_ledger_particular('To','Package Sales');
   $old_gl_id = $gl_id = $cust_gl;
   $payment_side = "Debit";
   $clearance_status = "";
   $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
    /////////Tax Amount/////////
    // tax_reflection_update('Package Booking',$tax_amount,$taxation_type,$booking_id,get_package_booking_id($booking_id,$yr1),$booking_date, $customer_id, $row_spec);

    $sq_pay = mysql_fetch_assoc(mysql_query("select sum(amount) as amount from package_payment_master where booking_id='$booking_id'"));
    $total_tour_expense = $total_travel_expense + $actual_tour_cost;
    $balance_amount = $total_tour_expense - $sq_pay['amount'];

}

}
?>