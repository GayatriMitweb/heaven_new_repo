<?php
$flag = true;
class cheque_clearance{
public function status_update($type){

	$register_id = $_POST['register_id'];
	$status = $_POST['status'];
	$status_date = $_POST['status_date'];
	$module_name = $_POST['module_name'];
	$module_entry_id = $_POST['module_entry_id'];
	$transaction_id = $_POST['transaction_id'];
	$payment_amount = $_POST['payment_amount'];
	$particular = $_POST['particular'];
	$type = $_POST['type1'];

	$payment_date = get_date_db($status_date);
	$sq_bank_cash_book_info = mysql_fetch_assoc(mysql_query("select * from bank_cash_book_master where register_id='$register_id'"));
	
	begin_t();
	$q = "update bank_cash_book_master set clearance_status='$status', payment_date='$payment_date' where register_id='$register_id'";
	$sq_bank_cash_book = mysql_query($q);

	$q1 = "update finance_transaction_master set clearance_status='$status' where module_name='$module_name' and transaction_id='$transaction_id' and payment_amount='$payment_amount'";
	$sq_fin = mysql_query($q1);

	if($sq_bank_cash_book){

		$module_name = $sq_bank_cash_book_info['module_name'];
		$module_entry_id = $sq_bank_cash_book_info['module_entry_id'];
		$transaction_id = $sq_bank_cash_book_info['transaction_id'];

		//B2B Deposit
		if($module_name=="B2b Deposit"){ 
			$table_name = 'b2b_registration';
			$id_name = 'register_id';
			$date_field = 'payment_date';
		}

		//B2B Booking
		if($module_name=="B2B Booking"){ 
			$table_name = 'b2b_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		//B2B Refund
		if($module_name=="B2B Booking Refund Paid"){ 
			$table_name = 'b2b_booking_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Visa Booking
		if($module_name=="Visa Booking"){ 
			$table_name = 'visa_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Visa Booking Refund Paid"){ 
			$table_name = 'visa_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}
		//miscelleneous Booking
		if($module_name=="Miscellaneous Booking"){ 
			$table_name = 'miscellaneous_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Miscellaneous Booking Refund Paid"){ 
			$table_name = 'miscellaneous_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

	
		//Passport Booking
		if($module_name=="Passport Booking"){ 
			$table_name = 'passport_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Passport Booking Refund Paid"){ 
			$table_name = 'passport_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Air Ticket Booking
		if($module_name=="Air Ticket Booking"){ 
			$table_name = 'ticket_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';

		}

		if($module_name=="Air Ticket Booking Refund Paid"){ 
			$table_name = 'ticket_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Train Ticket Booking
		if($module_name=="Train Ticket Booking"){ 
			$table_name = 'train_ticket_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Train Ticket Booking Refund Paid"){ 
			$table_name = 'train_ticket_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Hotel Booking
		if($module_name=="Hotel Booking"){ 
			$table_name = 'hotel_booking_payment';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Hotel Booking Refund Paid"){ 
			$table_name = 'hotel_booking_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Car Rental Booking
		if($module_name=="Car Rental Booking"){ 
			$table_name = 'car_rental_payment';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Car Rental Booking Refund Paid"){ 
			$table_name = 'car_rental_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Group Booking
		if($module_name=="Group Booking"){ 
			$table_name = 'payment_master';
			$id_name = 'payment_id';
			$date_field = 'date';
		}

		if($module_name=="Group Booking Refund Paid"){ 
			$table_name = 'refund_tour_cancelation';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		if($module_name=="Group Booking Traveller Refund Paid"){ 
			$table_name = 'refund_traveler_cancelation';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Package Booking
		if($module_name=="Package Booking"){ 
			$table_name = 'package_payment_master';
			$id_name = 'payment_id';
			$date_field = 'date';
		}	

		if($module_name=="Package Booking Traveller Refund Paid"){ 
			$table_name = 'package_refund_traveler_cancelation';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}

		//Employee Salary
		if($module_name=="Employee Salary"){ 
			$table_name = 'employee_salary_master';
			$id_name = 'salary_id';
			$date_field = 'payment_date';
		}

		//Office Expense
		if($module_name=="Other Expense Booking"){ 
			$table_name = 'other_expense_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		//Other Income
		if($module_name=="Other Income Payment"){ 
			$table_name = 'other_income_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}


		if($module_name=="Booker Incentive Payment"){ 
			$table_name = 'booker_incentive_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Corporate Advance Payment"){ 
			$table_name = 'corporate_advance_master';
			$id_name = 'advance_id';
			$date_field = 'payment_date';
		}
		
		if($module_name=="Airline Supplier Payment"){ 
			$table_name = 'flight_supplier_payment';
			$id_name = 'id';
			$date_field = 'payment_date';
		}

		if($module_name=="Visa Supplier Payment"){ 
			$table_name = 'visa_supplier_payment';
			$id_name = 'id';
			$date_field = 'payment_date';
		}

		//Vendor Payment
		if($module_name=="Vendor Payment"){ 
			$table_name = 'vendor_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}

		if($module_name=="Hotel Vendor"){ 
			$table_name = 'vendor_payment_master';
			$id_name = 'payment_id';
			$date_field = 'payment_date';
		}
		if($module_name=="Transport Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="DMC Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Car Rental Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Visa Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Ticket Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Excursion Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="DMC Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Cruise Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Train Ticket Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Passport Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Insurance Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}
		if($module_name=="Other Vendor"){ 

			$table_name = 'vendor_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		if($module_name=="Vendor Advance Payment"){ 

			$table_name = 'vendor_advance_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		if($module_name=="Vendor Refund Paid"){ 

			$table_name = 'vendor_refund_master';

			$id_name = 'refund_id';

			$date_field = 'payment_date';

		}



		//TDS

		if($module_name=="TDS Payment"){ 

			$table_name = 'tds_entry_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}



		//Miscellaneous

		if($module_name=="Miscellaneous Booking Payment"){ 

			$table_name = 'miscellaneous_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		if($module_name=="Miscellaneous Booking Refund"){ 

			$table_name = 'miscellaneous_refund_master';

			$id_name = 'refund_id';

			$date_field = 'refund_date';

		}



		//Bus

		if($module_name=="Bus Booking"){ 

			$table_name = 'bus_booking_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		if($module_name=="Bus Booking Refund Paid"){ 

			$table_name = 'bus_booking_refund_master';

			$id_name = 'refund_id';

			$date_field = 'refund_date';

		}

		//Forex
		if($module_name=="Forex Booking"){ 

			$table_name = 'forex_booking_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		//GST Paid

		if($module_name=="GST Monthly Payment"){ 

			$table_name = 'gst_payable_master';

			$id_name = 'id';

			$date_field = 'payment_date';

		}

		//Excursion Booking
		if($module_name=="Excursion Booking"){ 

			$table_name = 'exc_payment_master';

			$id_name = 'payment_id';

			$date_field = 'payment_date';

		}

		if($module_name=="Excursion Booking Refund Paid"){ 
			$table_name = 'exc_refund_master';
			$id_name = 'refund_id';
			$date_field = 'refund_date';
		}


		if($module_name=="B2B Booking"){
			$sq_payment = mysql_fetch_assoc(mysql_query("select * from b2b_payment_master where entry_id='$sq_bank_cash_book_info[module_entry_id]'"));
			$payment_id = $sq_payment['payment_id'];
			$q = "update $table_name set clearance_status='$status', $date_field='$payment_date' where $id_name='$payment_id'";
		}
		else{
			$q = "update $table_name set clearance_status='$status', $date_field='$payment_date' where $id_name='$sq_bank_cash_book_info[module_entry_id]'";
		}
		$sq_payment = mysql_query($q);

		if(!$sq_payment){
			$GLOBALS['flag'] = false;
		}

		if($GLOBALS['flag']){

			if($type === 'card' && $status == 'Cleared'){
				$this->finance_Save($module_name,$module_entry_id,$payment_amount,$payment_date,$table_name,$id_name,$particular);
			}
			echo "Status has been successfully saved.";

			commit_t();
			exit;
		}

	}
	else{
		rollback_t();
		echo "error--Sorry,Cheque status not updated!";
		exit;
	}
}

function finance_Save($module_name,$module_entry_id,$payment_amount,$payment_date,$table_name,$id_name,$particular){

	global $transaction_master;
	$branch_admin_id = $_SESSION['branch_admin_id'];
	$sq_credit = mysql_fetch_assoc(mysql_query("select credit_charges,credit_card_details from $table_name where $id_name='$module_entry_id'"));
	$credit_card_details = $sq_credit['credit_card_details'];
	$credit_card_details = explode('-',$credit_card_details);
	$entry_id = $credit_card_details[0];

	//Credit card company ledger
	$sq_cust1 = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$entry_id' and user_type='credit company'"));
	$company_gl = $sq_cust1['ledger_id'];

	$sq_credit_charges = mysql_fetch_assoc(mysql_query("select * from credit_card_company where entry_id ='$entry_id'"));
	//////company's credit card charges
	$company_card_charges = ($sq_credit_charges['charges_in'] =='Flat') ? $sq_credit_charges['credit_card_charges'] : ($payment_amount * ($sq_credit_charges['credit_card_charges']/100));
	//////company's tax on credit card charges
	$tax_charges = ($sq_credit_charges['tax_charges_in'] =='Flat') ? $sq_credit_charges['tax_on_credit_card_charges'] : ($company_card_charges * ($sq_credit_charges['tax_on_credit_card_charges']/100));
	$finance_charges = $company_card_charges + $tax_charges;
$finance_charges = number_format($finance_charges,2);
	$credit_company_amount = $payment_amount - $finance_charges;

	$sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$sq_credit_charges[bank_id]' and user_type='bank'"));
	$pay_gl = $sq_bank['ledger_id'];

	//Bank
	$module_name = $module_name;
	$module_entry_id = $module_entry_id;
	$transaction_id = '';
	$payment_amount = $credit_company_amount;
	$payment_date = $payment_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('By','Cash/Bank');
	$gl_id = $pay_gl;
	$payment_side = "Debit";
	$clearance_status = "Cleared";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, 'sales',$branch_admin_id,$ledger_particular,'BANK RECEIPT');

	//Credit company
	$module_name = $module_name;
	$module_entry_id = $module_entry_id;
	$transaction_id = '';
	$payment_amount = $credit_company_amount;
	$payment_date = $payment_date;
	$payment_particular = $particular;
	$ledger_particular = get_ledger_particular('By','Cash/Bank');
	$gl_id = $company_gl;
	$payment_side = "Credit";
	$clearance_status = "Cleared";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, 'sales',$branch_admin_id,$ledger_particular,'BANK RECEIPT');

}

}

?>