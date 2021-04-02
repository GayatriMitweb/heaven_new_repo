<?php 

$flag = true;

class passport_refund_estimate{



public function refund_estimate_update()

{
  $row_spec  ="sales";
  $passport_id = $_POST['passport_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];



  begin_t();



  $sq_refund = mysql_query("update passport_master set cancel_amount='$cancel_amount', total_refund_amount='$total_refund_amount' where passport_id='$passport_id'");

  if($sq_refund){



  	//Finance save

    $this->finance_save($passport_id,$row_spec);



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



public function finance_save($passport_id,$row_spec)

{

	$passport_id = $_POST['passport_id'];
  $cancel_amount = $_POST['cancel_amount'];
  $total_refund_amount = $_POST['total_refund_amount'];

  $created_at = date("Y-m-d");
	$year2 = explode("-", $created_at);
	$yr2 =$year2[0];

  $sq_passport = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));
  $customer_id = $sq_passport['customer_id'];
  $taxation_type = $sq_passport['taxation_type'];
  $service_tax_subtotal = $sq_passport['service_tax_subtotal'];
  $reflections = json_decode($sq_passport['reflections']);
  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  $passport_sale_amount = $sq_passport['passport_issue_amount'];

  $sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $cust_name = $sq_cust['first_name'].' '.$sq_cust['last_name'];
  global $transaction_master;
  $particular = 'Against Invoice no '.get_passport_booking_id($passport_id,$yr2).' for Passport renewal assistance for '.$cust_name;

  //////////Sales/////////////
  $module_name = "Passport Booking";
  $module_entry_id = $passport_id;
  $transaction_id = "";
  $payment_amount = $passport_sale_amount;
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = '';
  $gl_id = 94;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

  /////////Service Charge////////
  $module_name = "Passport Booking";
  $module_entry_id = $passport_id;
  $transaction_id = "";
  $payment_amount = $sq_passport['service_charge'];
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = '';
  $gl_id = ($reflections[0]->passport_sc != '') ? $reflections[0]->passport_sc : 194;
  $payment_side = "Debit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');

  /////////Service Charge Tax Amount////////
  $service_tax_subtotal = explode(',',$service_tax_subtotal);
  $tax_ledgers = explode(',',$reflections[0]->passport_taxes);
  for($i=0;$i<sizeof($service_tax_subtotal);$i++){

    $service_tax = explode(':',$service_tax_subtotal[$i]);
    $tax_amount = $service_tax[2];
    $ledger = $tax_ledgers[$i];

    $module_name = "Passport Booking";
    $module_entry_id = $passport_id;
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
  $module_name = "Passport Booking";
  $module_entry_id = $passport_id;
  $transaction_id = "";
  $payment_amount = $sq_passport['passport_total_cost'];
  $payment_date = $created_at;
  $payment_particular = $particular;
  $ledger_particular = '';
  $gl_id = $cust_gl;
  $payment_side = "Credit";
  $clearance_status = "";
  $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,'',$ledger_particular,'REFUND');    

  ////////Cancel Amount//////
  $module_name = "Passport Booking";
  $module_entry_id = $passport_id;
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
  $module_name = "Passport Booking";
  $module_entry_id = $passport_id;
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