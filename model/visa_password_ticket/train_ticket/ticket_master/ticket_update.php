<?php 

$flag = true;

class ticket_update{



public function ticket_master_update(){

	$row_spec = 'sales';

	$train_ticket_id = $_POST['train_ticket_id'];
	$customer_id = $_POST['customer_id'];
	$type_of_tour = $_POST['type_of_tour'];
	$basic_fair = $_POST['basic_fair'];

	$service_charge = $_POST['service_charge'];

	$delivery_charges = $_POST['delivery_charges'];

	$gst_on = $_POST['gst_on'];

	$taxation_type = $_POST['taxation_type'];

	$taxation_id = $_POST['taxation_id'];

	$service_tax = $_POST['service_tax'];

	$service_tax_subtotal = $_POST['service_tax_subtotal'];

	$net_total = $_POST['net_total'];

	$payment_due_date = $_POST['payment_due_date'];
	$booking_date1 = $_POST['booking_date1'];


	$honorific_arr = $_POST['honorific_arr'];

	$first_name_arr = $_POST['first_name_arr'];

	$middle_name_arr = $_POST['middle_name_arr'];

	$last_name_arr = $_POST['last_name_arr'];

	$birth_date_arr = $_POST['birth_date_arr'];

	$adolescence_arr = $_POST['adolescence_arr'];

	$coach_number_arr = $_POST['coach_number_arr'];

	$seat_number_arr = $_POST['seat_number_arr'];

	$ticket_number_arr = $_POST['ticket_number_arr'];

	$entry_id_arr = $_POST['entry_id_arr'];



	$travel_datetime_arr = $_POST['travel_datetime_arr'];

	$travel_from_arr = $_POST['travel_from_arr'];

	$travel_to_arr = $_POST['travel_to_arr'];

	$train_name_arr = $_POST['train_name_arr'];

	$train_no_arr = $_POST['train_no_arr'];

	$ticket_status_arr = $_POST['ticket_status_arr'];

	$class_arr = $_POST['class_arr'];

	$booking_from_arr = $_POST['booking_from_arr'];

	$boarding_at_arr = $_POST['boarding_at_arr'];
	$arriving_datetime_arr = $_POST['arriving_datetime_arr'];
	$trip_entry_id = $_POST['trip_entry_id'];
	$roundoff = $_POST['roundoff'];
	$reflections = json_decode(json_encode($_POST['reflections']));
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	foreach($bsmValues[0] as $key => $value){
		switch($key){
		case 'basic' : $basic_fair = ($value != "") ? $value : $basic_fair;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		case 'discount' : $discount = ($value != "") ? $value : $discount;break;
		}
	  }
	$payment_due_date = get_date_db($payment_due_date);	
	$booking_date1 = get_date_db($booking_date1);	

	$reflections = json_encode($reflections);
	$bsmValues = json_encode($bsmValues);
	begin_t();



	$sq_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$train_ticket_id'"));





	//**Update ticket

	$sq_ticket = mysql_query("UPDATE train_ticket_master SET customer_id='$customer_id', type_of_tour='$type_of_tour', basic_fair='$basic_fair', service_charge='$service_charge', delivery_charges='$delivery_charges', gst_on='$gst_on', service_tax_subtotal='$service_tax_subtotal', net_total='$net_total', payment_due_date='$payment_due_date',created_at='$booking_date1',reflections='$reflections',bsm_values='$bsmValues',roundoff='$roundoff' WHERE train_ticket_id='$train_ticket_id'");

	if(!$sq_ticket){

		$GLOBALS['flag'] = false;

		echo "error--Sorry, Ticket not updated!";

	}



	//**Updating entries

	for($i=0; $i<sizeof($first_name_arr); $i++){



		$birth_date_arr[$i] = get_date_db($birth_date_arr[$i]);



		if($entry_id_arr[$i]==""){



			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from train_ticket_master_entries"));

			$entry_id = $sq_max['max'] + 1;



			$sq_entry = mysql_query("INSERT INTO train_ticket_master_entries (entry_id, train_ticket_id, honorific, first_name, middle_name, last_name, birth_date, adolescence, coach_number, seat_number, ticket_number) VALUES ('$entry_id', '$train_ticket_id', '$honorific_arr[$i]', '$first_name_arr[$i]', '$middle_name_arr[$i]', '$last_name_arr[$i]', '$birth_date_arr[$i]', '$adolescence_arr[$i]', '$coach_number_arr[$i]', '$seat_number_arr[$i]', '$ticket_number_arr[$i]')");
			if(!$sq_entry){

				$GLOBALS['flag'] = false;

				echo "error--Some entries not saved!";

			}



		}

		else{



			$sq_entry = mysql_query("UPDATE train_ticket_master_entries SET  honorific='$honorific_arr[$i]', first_name='$first_name_arr[$i]', middle_name='$middle_name_arr[$i]', last_name='$last_name_arr[$i]', birth_date='$birth_date_arr[$i]', adolescence='$adolescence_arr[$i]', coach_number='$coach_number_arr[$i]', seat_number='$seat_number_arr[$i]', ticket_number='$ticket_number_arr[$i]' WHERE entry_id='$entry_id_arr[$i]' ");

			if(!$sq_entry){

				$GLOBALS['flag'] = false;

				echo "error--Some entries not updated!";

			}



		}
		if($adolescence_arr[$i] != "Infant"){
			$pax++;
		}

		



	}



	//**Updating trip

	for($i=0; $i<sizeof($travel_datetime_arr); $i++){



		$travel_datetime_arr[$i] = get_datetime_db($travel_datetime_arr[$i]);

		$arriving_datetime_arr[$i] = get_datetime_db($arriving_datetime_arr[$i]);



		if($trip_entry_id[$i]==""){



			$sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from train_ticket_master_trip_entries"));

			$entry_id = $sq_max['max'] + 1;

			



			$sq_entry = mysql_query("INSERT INTO train_ticket_master_trip_entries (entry_id, train_ticket_id, travel_datetime, travel_from, travel_to, train_name, train_no, ticket_status, class, booking_from, boarding_at, arriving_datetime) VALUES ('$entry_id', '$train_ticket_id', '$travel_datetime_arr[$i]', '$travel_from_arr[$i]', '$travel_to_arr[$i]', '$train_name_arr[$i]', '$train_no_arr[$i]', '$ticket_status_arr[$i]', '$class_arr[$i]', '$booking_from_arr[$i]', '$boarding_at_arr[$i]', '$arriving_datetime_arr[$i]')");
			if(!$sq_entry){

				$GLOBALS['flag'] = false;

				echo "error--Some trip entries not saved!";

			}



		}

		else{



			$sq_entry = mysql_query("UPDATE train_ticket_master_trip_entries SET  travel_datetime='$travel_datetime_arr[$i]', travel_from='$travel_from_arr[$i]', travel_to='$travel_to_arr[$i]', train_name='$train_name_arr[$i]', train_no='$train_no_arr[$i]', ticket_status='$ticket_status_arr[$i]', class='$class_arr[$i]', booking_from='$booking_from_arr[$i]', boarding_at='$boarding_at_arr[$i]', arriving_datetime='$arriving_datetime_arr[$i]' WHERE entry_id='$trip_entry_id[$i]' ");

			if(!$sq_entry){

				$GLOBALS['flag'] = false;

				echo "error--Some trip entries not updated!";

			}



		}
		if($i == 0)
			$sector = $travel_from_arr[$i].'-'.$travel_to_arr[$i];
		if($i>0)
			$sector = $sector.','.$travel_from_arr[$i].'-'.$travel_to_arr[$i];

		



	}



	//Get Particular
	$particular = $this->get_particular($customer_id,$pax,$sector,$train_no_arr[0],$ticket_number_arr[0],$class_arr[0]);
	//Finance update
	$this->finance_update($sq_ticket_info, $row_spec, $particular);



	if($GLOBALS['flag']){

		commit_t();

		echo "Train Ticket Booking has been successfully updated.";

		exit;	

	}

	else{

		rollback_t();

		exit;

	}



		

}


function get_particular($customer_id,$pax,$sector,$train_no,$ticket_number,$class){
	$sq_ct = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	$cust_name = $sq_ct['first_name'].' '.$sq_ct['last_name'];
	return 'Towards the tkt of '.$cust_name.' * '.$pax.' traveling for '.$sector.' against ticket no '.$ticket_number.' by '.$train_no.'/'.$class;
}


public function finance_update($sq_ticket_info, $row_spec,$particular)
{
	$train_ticket_id = $_POST['train_ticket_id'];
	$customer_id = $_POST['customer_id'];
	$basic_fair = $_POST['basic_fair'];
	$service_charge = $_POST['service_charge'];
    $delivery_charges = $_POST['delivery_charges'];
	$gst_on = $_POST['gst_on'];
	$taxation_type = $_POST['taxation_type'];
	$taxation_id = $_POST['taxation_id'];
	$service_tax = $_POST['service_tax'];
	$service_tax_subtotal = $_POST['service_tax_subtotal'];
	$net_total = $_POST['net_total'];
	$bank_id1 = $_POST['bank_id'];
	$booking_date1 = $_POST['booking_date1'];
	$roundoff = $_POST['roundoff'];
	$credit_charges = $_POST['credit_charges'];
	$credit_card_details = $_POST['credit_card_details'];

	if($payment_mode == 'Credit Card'){

		$payment_amount = $payment_amount + $credit_charges;
		$credit_card_details = explode('-',$credit_card_details);
		$entry_id = $credit_card_details[0];
		$sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
		$bank_id = $sq_credit_charges['bank_id'];
	}
	
	$reflections = json_decode(json_encode($_POST['reflections']));
	$bsmValues = json_decode(json_encode($_POST['bsmValues']));
	$booking_date = get_date_db($booking_date1);
	$year2 = explode("-", $booking_date);
	$yr2 = $year2[0];

	foreach($bsmValues[0] as $key => $value){
		switch($key){
		case 'basic' : $basic_fair = ($value != "") ? $value : $basic_fair;break;
		case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
		case 'markup' : $markup = ($value != "") ? $value : $markup;break;
		case 'discount' : $discount = ($value != "") ? $value : $discount;break;
		}
	  }
	$train_sale_amount = $basic_fair;
	//get total payment against train_ticket id
  	$sq_train_ticket = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as payment_amount from train_ticket_payment_master where train_ticket_id='$train_ticket_id'"));
	$balance_amount = $net_total - $sq_train_ticket['payment_amount'];

  	//Getting customer Ledger
	$sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
	$cust_gl = $sq_cust['ledger_id'];

	//Getting cash/Bank Ledger
	if($payment_mode == 'Cash') {  $pay_gl = 20; }
	else{ 
		$sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id1' and user_type='bank'"));
		$pay_gl = $sq_bank['ledger_id'];
		}

	global $transaction_master;

	////////////Sales/////////////
	$module_name = "Train Ticket Booking";
	$module_entry_id = $train_ticket_id;
	$transaction_id = "";
	$payment_amount = $train_sale_amount;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
	$old_gl_id = $gl_id = 133;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	////////////service charge/////////////
	$module_name = "Train Ticket Booking";
	$module_entry_id = $train_ticket_id;
	$transaction_id = "";
	$payment_amount = $service_charge;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
	$old_gl_id = $gl_id = ($reflections[0]->train_sc != '') ? $reflections[0]->train_sc : 189;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');

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
		$payment_date = $booking_date;
		$payment_particular = $particular;
		$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
		$old_gl_id = $gl_id = $ledger;
		$payment_side = "Credit";
		$clearance_status = "";
		$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	}
	/////////roundoff/////////
	$module_name = "Train Ticket Booking";
	$module_entry_id = $train_ticket_id;
	$transaction_id = "";
	$payment_amount = $roundoff;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
	$old_gl_id = $gl_id = 230;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	///////// Delivery charges //////////
	$module_name = "Train Ticket Booking";
	$module_entry_id = $train_ticket_id;
	$transaction_id = "";
	$payment_amount = $delivery_charges;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
	$old_gl_id = $gl_id = 33;
	$payment_side = "Credit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $old_gl_id, $gl_id,'', $payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	////////Customer Amount//////
	$module_name = "Train Ticket Booking";
	$module_entry_id = $train_ticket_id;
	$transaction_id = "";
	$payment_amount = $net_total;
	$payment_date = $booking_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('To','Train Ticket Sales');
	$old_gl_id = $gl_id = $cust_gl;
	$payment_side = "Debit";
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular,'INVOICE');
	

}



}

?>