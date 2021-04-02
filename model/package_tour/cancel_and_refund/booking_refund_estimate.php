<?php 

$flag = true;

class booking_refund_estimate{



public function refund_estimate_update()

{
    $row_spec= 'sales';
	$booking_id = $_POST['booking_id'];  
    $cancel_amount = $_POST['cancel_amount'];
    $total_refund_amount = $_POST['total_refund_amount'];

	$sq_booking = mysql_fetch_assoc(mysql_query("select customer_id, taxation_type from package_tour_booking_master where booking_id='$booking_id'"));

    $customer_id = $sq_booking['customer_id'];

	$taxation_type = $sq_booking['taxation_type'];



	begin_t();



		$created_at = date('Y-m-d H:i:s');



		$sq_max = mysql_fetch_assoc(mysql_query("select max(estimate_id) as max from package_refund_traveler_estimate"));

		$estimate_id = $sq_max['max'] + 1;
        $q = "insert into package_refund_traveler_estimate(estimate_id, booking_id, cancel_amount, total_refund_amount, created_at) values ('$estimate_id', '$booking_id', '$cancel_amount', '$total_refund_amount', '$created_at')";
		$sq_est = mysql_query($q);		

	if($sq_est){

		if($GLOBALS['flag']){

            $this->finance_save($booking_id,$row_spec);
			commit_t();

			echo "Refund Estimate has been successfully saved.";

			exit;

		}

		else{

			rollback_t();

			exit;	

		}



	}

	else{

		rollback_t();

		echo "error--Sorry, Cancellation not done!";

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

  $sq_pck_info = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $customer_id = $sq_pck_info['customer_id'];
  $total_sale_amount = $sq_pck_info['basic_amount'];
  $tour_service_tax_subtotal = $sq_pck_info['tour_service_tax_subtotal'];
  $reflections = json_decode($sq_pck_info['reflections']);
  $service_charge = $sq_pck_info['service_charge'];
    //Getting customer Ledger
    $sq_cust1 = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
    $cust_gl = $sq_cust1['ledger_id'];
    $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];;
    $particular = 'Against Invoice no '.get_package_booking_id($booking_id,$yr1).' for '.$sq_pck_info['tour_name'].' for '.$cust_name.' for '.$sq_pck_info['total_tour_days'].' Nights starting from '.get_date_user($sq_pck_info['tour_from_date']);

    global $transaction_master;

    //////////Sales/////////////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $total_sale_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 92;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    /////////Service Charge////////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 185;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    /////////Service Charge Tax Amount////////
    // Eg. CGST:(9%):24.77, SGST:(9%):24.77
    // $customer_amount = $sub_total+$service_charge+$markup+$tds-$discount;
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
      $payment_date = $created_at;
      $payment_particular = $particular;
      $ledger_particular = '';
      $gl_id = $ledger;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    }

    ////////Customer Sale Amount//////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $sq_pck_info['net_total'];
    $payment_date = $created_at;
    $payment_particular =  $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
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
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
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