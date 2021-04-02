<?php 

$flag = true;

class train_ticket_refund_estimate{



public function refund_estimate_update()

{
  $row_spec ='sales';
  $train_ticket_id = $_POST['train_ticket_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  begin_t();

  $sq_refund = mysql_query("update train_ticket_master set cancel_amount='$cancel_amount', refund_net_total='$total_refund_amount' where train_ticket_id='$train_ticket_id'");

  if($sq_refund){
  	//Finance save

    $this->finance_save($train_ticket_id,$row_spec);



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

  	echo "Cancellation not saved!";

  	exit;

  }



}



public function finance_save($train_ticket_id,$row_spec){

	$train_ticket_id = $_POST['train_ticket_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  $created_at = date("Y-m-d");
	$year2 = explode("-", $created_at);
	$yr2 =$year2[0];

  $sq_train_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$train_ticket_id'"));
  $customer_id = $sq_train_info['customer_id'];
  $taxation_type = $sq_train_info['taxation_type'];
  $service_tax_subtotal = $sq_train_info['service_tax_subtotal'];
  $service_charge = $sq_train_info['service_charge'];
  $sale_amount = $sq_train_info['basic_fair'];
  $reflections = json_decode($sq_train_info['reflections']);
  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];

  //Particular
  $pax = 0;
  $j = 0;
  $sq_traine = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
  while($row_traine = mysql_fetch_assoc($sq_traine)){
    if($row_traine['adolescence']!= "Infant") $pax++;
    if($j == 0){ $ticket_number = $row_traine['ticket_number']; } 
    $j++;
  }

  $sq_traine3 = mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$train_ticket_id'");
  $i = 0;
  while($row_traine1 = mysql_fetch_assoc($sq_traine3)){
    if($i == 0){
      $train_no = $row_traine1['train_no'];
      $class = $row_traine1['class'];
      $sector = $row_traine1['travel_from'].'-'.$row_traine1['travel_to'];
    }
    if($i>0)
      $sector = $sector.','.$row_traine1['travel_from'].'-'.$row_traine1['travel_to'];
    $i++;
  }

  $sq_ct = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
  $particular = 'Against Invoice no '.get_train_ticket_booking_id($train_ticket_id,$yr1).' for tkt of '.$cust_name.' * '.$pax.' traveling for '.$sector.' against ticket no '.$ticket_number.' by '.$train_no.'/'.$class;

  global $transaction_master;
    //////////Sales/////////////

    $module_name = "Train Ticket Booking";
    $module_entry_id = $train_ticket_id;
    $transaction_id = "";
    $payment_amount = $sale_amount;
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = 134;
    $payment_side = "Debit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

    /////////Service Charge////////
		$module_name = "Train Ticket Booking";
		$module_entry_id = $train_ticket_id;
		$transaction_id = "";
		$payment_amount = $service_charge;
		$payment_date = $created_at;
		$payment_particular = $particular;
		$ledger_particular = '';
		$gl_id = ($reflections[0]->train_sc != '') ? $reflections[0]->train_sc : 189;
		$payment_side = "Debit";
		$clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');
    
    /////////Service Charge Tax Amount////////
		// Eg. CGST:(9%):24.77, SGST:(9%):24.77			
			$service_tax_subtotal = explode(',',$service_tax_subtotal);
			$tax_ledgers = explode(',',$reflections[0]->train_taxes);
			for($i=0;$i<sizeof($service_tax_subtotal);$i++){

			$service_tax = explode(':',$service_tax_subtotal[$i]);
			$tax_amount = $service_tax[2];
			$ledger = $tax_ledgers[$i];

			$module_name = "Train Ticket Booking";
			$module_entry_id = $train_ticket_id;
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

    ///////// Delivery charges //////////
      $module_name = "Train Ticket Booking";
      $module_entry_id = $train_ticket_id;
      $transaction_id = "";
      $payment_amount = $sq_train_info['delivery_charges'];
      $payment_date = $created_at;
      $payment_particular = $particular;
      $gl_id = 33;
      $payment_side = "Debit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'REFUND');

    ////////Customer Sale Amount//////
    $module_name = "Train Ticket Booking";
    $module_entry_id = $train_ticket_id;
    $transaction_id = "";
    $payment_amount = $sq_train_info['net_total'];
    $payment_date = $created_at;
    $payment_particular = $particular;
    $ledger_particular = '';
    $gl_id = $cust_gl;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'',$payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

    ////////Cancel Amount//////
    $module_name = "Train Ticket Booking";
    $module_entry_id = $train_ticket_id;
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
    $module_name = "Train Ticket Booking";
    $module_entry_id = $train_ticket_id;
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