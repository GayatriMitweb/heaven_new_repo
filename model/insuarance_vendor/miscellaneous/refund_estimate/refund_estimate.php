<?php 
$flag = true;
class refund_estimate{

public function refund_estimate_save()
{
	$booking_id = $_POST['booking_id'];
	$refund_basic_cost = $_POST['refund_basic_cost'];
	$refund_service_charge = $_POST['refund_service_charge'];
	$refund_service_tax_subtotal = $_POST['refund_service_tax_subtotal'];
	$refund_net_total = $_POST['refund_net_total'];

	//**Starting transaction
	begin_t();

	$sq_est = mysql_query("update miscellaneous_booking_master set refund_basic_cost='$refund_basic_cost', refund_service_charge='$refund_service_charge', refund_service_tax_subtotal='$refund_service_tax_subtotal', refund_net_total='$refund_net_total' where booking_id='$booking_id'");
	if(!$sq_est){
		$GLOBALS['flag'] = false;
		echo "error--Estimate not updated!";
	}

	//Finance save
    $this->finance_save();

    if($GLOBALS['flag']){
    	commit_t();
    	echo "Estimate saved!";
    	exit;
    }
    else{
    	rollback_t();
    	exit;
    }
}

public function finance_save()
{
    $booking_id = $_POST['booking_id'];
	$refund_basic_cost = $_POST['refund_basic_cost'];
	$refund_service_charge = $_POST['refund_service_charge'];
	$refund_service_tax_subtotal = $_POST['refund_service_tax_subtotal'];
	$refund_net_total = $_POST['refund_net_total'];

    $sq_booking = mysql_fetch_assoc(mysql_query("select taxation_type from miscellaneous_booking_master where booking_id='$booking_id'"));
    $taxation_type = $sq_booking['taxation_type'];

    $igst = get_igst_cost($refund_service_tax_subtotal, $taxation_type);
    $cgst = get_cgst_cost($refund_service_tax_subtotal, $taxation_type);
    $sgst = get_sgst_cost($refund_service_tax_subtotal, $taxation_type);
    $ugst = get_ugst_cost($refund_service_tax_subtotal, $taxation_type);

    global $transaction_master;
    global $cash_in_hand, $bank_account, $sundry_debitor, $service_tax_assets, $service_charge_received, $fiance_vars;

    $sq_booking = mysql_fetch_assoc(mysql_query("select booking_type_id from miscellaneous_booking_master where booking_id='$booking_id'"));

    $sq_count = mysql_num_rows(mysql_query("select * from finance_transaction_master where module_name='Miscellaneous Booking' and module_entry_id='$booking_id' and gl_id='$sundry_debitor' and payment_side='Credit'"));

    //***========================Booking entries start=============================***//
    //***Sales***//
    $sq_booking_type = mysql_fetch_assoc(mysql_query("select gl_id from miscellaneous_booking_type where booking_type_id='$sq_booking[booking_type_id]'"));
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $refund_basic_cost;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $refund_basic_cost, $customer_id);
    $old_gl_id = $gl_id = $sq_booking_type['gl_id'];
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**IGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $igst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $igst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['igst'];
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**CGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $cgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $cgst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['cgst'];
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**SGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sgst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $sgst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['sgst'];
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**UGST**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $ugst;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $ugst, $customer_id);
    $old_gl_id = $gl_id = $fiance_vars['ugst'];
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**Service charge**//
    $module_name="Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $refund_service_charge;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $refund_service_charge, $customer_id);
    $old_gl_id = $gl_id = $service_charge_received;
    $payment_side = "Debit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }

    //**Sundry debitor**//
    $module_name = "Miscellaneous Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $refund_net_total;
    $payment_date = $created_at;
    $payment_particular = get_sales_particular(get_miscellaneous_booking_id($booking_id), $created_at, $refund_net_total, $customer_id);
    $old_gl_id = $gl_id = $sundry_debitor;
    $payment_side = "Credit";
    $clearance_status = "";
    if($sq_count==0){
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, $payment_side, $clearance_status);  
    }
    else{
      $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id, $payment_side, $clearance_status);  
    }
    //***========================Booking entries end=============================***//


}

}
?>