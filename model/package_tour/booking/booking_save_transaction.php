<?php 

class booking_save_transaction{


function finance_save($booking_id, $row_spec, $branch_admin_id,$particular)
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
  $basic_amount = $_POST['basic_amount'];
  $tour_taxation_id = $_POST['tour_taxation_id']; 
  $tour_service_tax = $_POST['tour_service_tax'];
  $tour_service_tax_subtotal = $_POST['tour_service_tax_subtotal'];
  $total_travel_expense = $_POST['total_travel_expense']; 
  $actual_tour_cost = $_POST['actual_tour_cost']; 
  $net_total = $_POST['net_total'];
  //**Payment details
  $payment_date = $_POST['payment_date'];
  $payment_mode = $_POST['payment_mode'];
  $payment_amount = $_POST['payment_amount'];
  $bank_name = $_POST['bank_name'];
  $transaction_id = $_POST['transaction_id'];
  $payment_for = $_POST['payment_for'];
  $p_travel_type = $_POST['p_travel_type'];
  $bank_id_arr = $_POST['bank_id_arr'];
  $roundoff = $_POST['roundoff'];
  $credit_amount_arr = $_POST['credit_amount_arr'];
  $credit_charges_arr = $_POST['credit_charges_arr'];
  $credit_card_details_arr = $_POST['credit_card_details_arr'];
  $bsmValues = json_decode(json_encode($_POST['bsmValues']));
    foreach($bsmValues[0] as $key => $value){
        switch($key){
        case 'basic' : $basic_amount = ($value != "") ? $value : $basic_amount;break;
        case 'service' : $service_charge = ($value != "") ? $value : $service_charge;break;
        case 'markup' : $markup = ($value != "") ? $value : $markup;break;
        case 'discount' : $discount = ($value != "") ? $value : $discount;break;
        }
      }
  $reflections = json_decode(json_encode($_POST['reflections']));
  $booking_date = get_date_db($booking_date);
	$year1 = explode("-", $booking_date);
  $yr1 =$year1[0];
  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  $total_sale_amount = $basic_amount;

  ////////////Sales/////////////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $total_sale_amount;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Pacakge Sales');
    $gl_id = 91;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Service Charge////////
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $service_charge;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Package Sales');
    $gl_id = ($reflections[0]->hotel_sc != '') ? $reflections[0]->hotel_sc : 185;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');

    /////////Tax Amount/////////
    // tax_reflection_update('Package Booking',$tax_amount,$taxation_type,$booking_id,get_package_booking_id($booking_id,$yr1),$booking_date, $customer_id, $row_spec,$branch_admin_id);

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
      $payment_date = $booking_date;
      $payment_particular = $particular;
      $ledger_particular = get_ledger_particular('To','Package Sales');
      $gl_id = $ledger;
      $payment_side = "Credit";
      $clearance_status = "";
      $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    }
    ////Roundoff Value
    $module_name = "Package Booking";
    $module_entry_id = $booking_id;
    $transaction_id = "";
    $payment_amount = $roundoff;
    $payment_date = $booking_date;
    $payment_particular = $particular;
    $ledger_particular = get_ledger_particular('To','Package Sales');
    $gl_id = 230;
    $payment_side = "Credit";
    $clearance_status = "";
    $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
     ////////Customer Amount//////
     $module_name = "Package Booking";
     $module_entry_id = $booking_id;
     $transaction_id = "";
     $payment_amount = $net_total;
     $payment_date = $booking_date;
     $payment_particular = $particular;
     $ledger_particular = get_ledger_particular('To','Package Sales');
     $gl_id = $cust_gl;
     $payment_side = "Debit";
     $clearance_status = "";
     $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,'INVOICE');
    
}
public function payment_finance_save($booking_id, $payment_id, $branch_admin_id, $payment_date, $payment_mode, $payment_amount, $transaction_id1,$bank_id, $payment_date, $clearance_status,$credit_charges_arr,$credit_card_details_arr){

  $row_spec='sales';
  global $transaction_master;
  
  $payment_amount1 = $payment_amount+$credit_charges_arr;
  $customer_id = $_POST['customer_id'];
  $payment_date = get_date_db($payment_date);
	$year1 = explode("-", $payment_date);
	$yr1 =$year1[0];
  //Getting customer Ledger
  $sq_cust = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));
  $cust_gl = $sq_cust['ledger_id'];
  //Getting cash/Bank Ledger
  if($payment_mode == 'Cash') {  $pay_gl = 20; $type='CASH RECEIPT'; }
  else{ 
    $sq_bank = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$bank_id' and user_type='bank'"));
    $pay_gl = $sq_bank['ledger_id'];
    $type='BANK RECEIPT';
  }
  if($payment_mode != 'Credit Note'){
		
		if($payment_mode == 'Credit Card'){

			//////Customer Credit charges///////
			$module_name = "Package Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges_arr;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date1, $credit_charges_arr, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $cust_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Credit charges ledger///////
			$module_name = "Package Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_charges_arr;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date1, $credit_charges_arr, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 224;
			$payment_side = "Credit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);

			//////Get Credit card company Ledger///////
			$credit_card_details_arr1 = explode('-',$credit_card_details_arr);
      $entry_id = $credit_card_details_arr1[0];
      
			$sq_cust1 = mysql_fetch_assoc(mysql_query("select * from ledger_master where customer_id='$entry_id' and user_type='credit company'"));
			$company_gl = $sq_cust1['ledger_id'];
			//////Get Credit card company Charges///////
			$sq_credit_charges = mysql_fetch_assoc(mysql_query("select * from credit_card_company where entry_id='$entry_id'"));
			//////company's credit card charges
			$company_card_charges = ($sq_credit_charges['charges_in'] =='Flat') ? $sq_credit_charges['credit_card_charges'] : ($payment_amount1 * ($sq_credit_charges['credit_card_charges']/100));
			//////company's tax on credit card charges
			$tax_charges = ($sq_credit_charges['tax_charges_in'] =='Flat') ? $sq_credit_charges['tax_on_credit_card_charges'] : ($company_card_charges * ($sq_credit_charges['tax_on_credit_card_charges']/100));
      $finance_charges = $company_card_charges + $tax_charges;
      $finance_charges = number_format($finance_charges,2);
      
			$credit_company_amount = $payment_amount1 - $finance_charges;

			//////Finance charges ledger///////
			$module_name = "Package Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $finance_charges;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date1, $finance_charges, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = 231;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
			//////Credit company amount///////
			$module_name = "Package Booking";
			$module_entry_id = $booking_id;
			$transaction_id = $transaction_id1;
			$payment_amount = $credit_company_amount;
			$payment_date = $payment_date;
			$payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date1, $credit_company_amount, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
			$ledger_particular = get_ledger_particular('By','Cash/Bank');
			$gl_id = $company_gl;
			$payment_side = "Debit";
			$clearance_status = ($payment_mode=="Cheque"||$payment_mode=="Credit Card") ? "Pending" : "";
			$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
		}
		else{
        //////Payment Amount///////
        $module_name = "Package Booking";
        $module_entry_id = $booking_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $payment_amount1;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = $pay_gl;
        $payment_side = "Debit";
        $clearance_status = ($payment_mode=="Cheque" ||$payment_mode=="Credit Card") ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
    
        //////Customer Payment Amount///////
        $module_name = "Package Booking";
        $module_entry_id = $booking_id;
        $transaction_id = $transaction_id1;
        $payment_amount = $payment_amount1;
        $payment_date = $payment_date;
        $payment_particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date, $payment_amount1, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id1);
        $ledger_particular = get_ledger_particular('By','Cash/Bank');
        $gl_id = $cust_gl;
        $payment_side = "Credit";
        $clearance_status = ($payment_mode=="Cheque" ||$payment_mode=="Credit Card") ? "Pending" : "";
        $transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id,'', $payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular,$type);
    }
}

public function bank_cash_book_save($booking_id, $payment_id, $payment_date, $payment_mode, $payment_amount1, $transaction_id, $payment_date, $bank_name, $bank_id, $branch_admin_id,$credit_charges_arr,$credit_card_details_arr)
{

    global $bank_cash_book_master;

    

    $customer_id = $_POST['customer_id'];
    $payment_date = get_date_db($payment_date);
    $year1 = explode("-", $payment_date);
    $yr1 =$year1[0];


    if($payment_mode == 'Credit Card')
    {
      $payment_amount1 = $payment_amount1 + $credit_charges_arr;
      $credit_card_details = explode('-',$credit_card_details_arr);
      $entry_id = $credit_card_details[0];
      
      $sq_credit_charges = mysql_fetch_assoc(mysql_query("select bank_id from credit_card_company where entry_id ='$entry_id'"));
      $bank_id = $sq_credit_charges['bank_id'];
  
    }


    $module_name = "Package Booking";

    $module_entry_id = $payment_id;

    $payment_date = $payment_date;

    $payment_amount = $payment_amount1;

    $payment_mode = $payment_mode;

    $bank_name = $bank_name;

    $transaction_id = $transaction_id;

    $bank_id = $bank_id;

    $particular = get_sales_paid_particular(get_package_booking_id($booking_id,$yr1), $payment_date, $payment_amount, $customer_id, $payment_mode, get_package_booking_id($booking_id,$yr1),$bank_id,$transaction_id);
    $clearance_status = ($payment_mode=="Cheque" || $payment_mode=="Credit Card") ? "Pending" : "";

    $payment_side = "Debit";

    $payment_type = ($payment_mode=="Cash") ? "Cash" : "Bank";



    $bank_cash_book_master->bank_cash_book_master_save($module_name, $module_entry_id, $payment_date, $payment_amount, $payment_mode, $bank_name, $transaction_id, $bank_id, $particular, $clearance_status, $payment_side, $payment_type, $branch_admin_id);

    

}



}

?>