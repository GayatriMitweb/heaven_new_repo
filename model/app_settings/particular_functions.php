<?php
//===================== NEW ========================
function get_cash_deposit_particular($bank_id,$date){
  $date = get_date_user($date);
  $sq_bank_info = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$bank_id'"));
  $particular = "Cash Deposited at ".$sq_bank_info['bank_name'].'('.$sq_bank_info['branch_name'].')'.' on '.$date;

  return $particular;
}
function get_cash_withdraw_particular($bank_id,$date){

  $date = get_date_user($date);
  $sq_bank_info = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$bank_id'"));
  $particular = "Cash Withdrawal from ".$sq_bank_info['bank_name'].'('.$sq_bank_info['branch_name'].')'.' on '.$date;

  return $particular;
}
function get_bank_transfer_particular($f_bank_id,$t_bank_id,$date,$mode){

  $date = get_date_user($date);
  $sq_bank_info1 = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$f_bank_id'"));
  $sq_bank_info2 = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$t_bank_id'"));

  $particular = "Amount transferred from ".$sq_bank_info1['bank_name'].'('.$sq_bank_info1['branch_name'].")"."to ".$sq_bank_info2['bank_name'].'('.$sq_bank_info2['branch_name'].') on '.$date.' through '.$mode;

  return $particular;
}

function get_cancel_sales_particular($invoice_id, $customer_id){

  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  if($sq_customer_info['type']== 'Corporate'){
    $customer_name = $sq_customer_info['company_name'];
  }else{
    $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
  }
  $particular = "Being Sales against Inv. No ".$invoice_id." for ".$customer_name." cancelled";
  return $particular;
}

function get_cancel_purchase_particular($invoice_id){

  $particular = "Being purchase against Inv. No ".$invoice_id." cancelled";
  return $particular;
}

//===================================================
function get_sales_particular($invoice_id, $date, $amount, $customer_id){

  $date = get_date_user($date);
  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));

  if($sq_customer_info['type']== 'Corporate'){
    $customer_name = $sq_customer_info['company_name'];
  }else{
    $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
  }
  $particular = "Sales booked against Inv. No ".$invoice_id." from ".$customer_name;
  return $particular;
}

function get_purchase_partucular($invoice_id, $date, $amount, $vendor_type, $vendor_type_id){
  $date = get_date_user($date);
  $vendor_name = get_vendor_name($vendor_type, $vendor_type_id);
  $particular = "Being Purchases made against Inv. No ".$invoice_id." from ".$vendor_name;

  return $particular;
}

function get_sales_paid_particular($payment_id, $date, $amount, $customer_id, $payment_mode, $invoice,$bank_id,$cheque_no)

{

  $date = get_date_user($date);

  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));  
  if($sq_customer_info['type']== 'Corporate'){
    $customer_name = $sq_customer_info['company_name'];
  }else{
    $customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
  }

  $sq_bank = mysql_fetch_assoc(mysql_query("select bank_name from bank_master where bank_id='$bank_id'"));
  $bank_name = $sq_bank['bank_name'];

  $particular = "Received against Inv. No ".$invoice." through ".$payment_mode." from ".$customer_name." Dt. ".$date;
  if($payment_mode != 'Cash' && $payment_mode != 'Credit Card' && $payment_mode != ''){
    $particular .= ' of '.$bank_name.' Cheque no / ID . '.$cheque_no;
  }
  return $particular;

}



function get_purchase_paid_partucular($invoice_id, $date, $amount, $vendor_type, $vendor_type_id, $payment_mode='')

{
  $date = get_date_user($date);
  $vendor_name = get_vendor_name($vendor_type, $vendor_type_id);

  $particular = 'Paid to '.$vendor_name.' through '.$payment_mode.' on Dt '.$date;
  return $particular;
}



function get_expense_paid_particular($invoice_id, $expense_type_id, $date, $amount, $payment_mode)

{

  $date = get_date_user($date);



  $sq_expense_type = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$expense_type_id'"));

  $expense_type = $sq_expense_type['ledger_name'];


  if($payment_mode != ''){
    $particular = "Paid "." through ".$payment_mode.' on Dt. '.$date;
  }
  else{
    $particular = "Paid ".' on Dt. '.$date;
  }

  return $particular;

}


function get_gst_paid_particular($invoice_id, $date, $amount, $payment_mode)
{

  $date = get_date_user($date);
  if($payment_mode != ''){
    $particular = "Being TAX paid against Invoice No. ".$invoice_id." by payment mode ".$payment_mode;
  }
  else{
    $particular = "Being TAX paid against Invoice No. ".$invoice_id;
  }

  return $particular;

}



function get_salary_paid_particular($login_id, $month, $year, $date){

  $date = get_date_user($date);
  $month_year = $month.' '.$year;

  $sq_login = mysql_fetch_assoc(mysql_query("select emp_id from roles where id='$login_id'"));

  $emp_id = $sq_login['emp_id'];

  $sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));

  $employee_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];

  $particular = "Salary paid to ".$employee_name." for the month of ".$month_year;

  return $particular;

}


function get_advance_particular($customer_id,$payment_mode,$date)
{

  $date = get_date_user($date);
  $sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
  $customer_name = $sq_customer_info['company_name'];

  $particular = "Advance received from ".$customer_name.' through '.$payment_mode.' on Dt. '.$date;
  return $particular;
}

function get_advance_purchase_particular($supplier_name,$payment_mode,$date)
{
  $date = get_date_user($date);
  $particular = "Advance paid to ".$supplier_name.' through '.$payment_mode.' on Dt. '.$date;
  return $particular;
}

function get_other_income_particular($payment_mode, $date, $description, $amount, $cheque_no1)
{

  $date = get_date_user($date);

  if($payment_mode == 'Cash'){
    $cheque_no = ''; 
  }else{
    $cheque_no = '('.$cheque_no1.')'; 
  }
  $particular = "Payment Received against selling asset (".$description.") through ".$payment_mode.$cheque_no;

  return $particular;

}

function get_flight_supplier_particular($vendor)

{

  $particular = "Flight Deposit paid to ".$vendor;

  return $particular;

}


function get_visa_supplier_particular($vendor)

{
  $particular = "Visa Deposit paid to ".$vendor;

  return $particular;

}


function get_incentive_paid_particular($emp_id)

{

  $sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
  $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
  $particular = "Incentive paid to ".$emp_name;

  return $particular;

}



function get_refund_paid_particular($invoice_id, $date, $amount, $payment_mode, $refund_id)

{
  $date = get_date_user($date);
  if($invoice_id!=''){
    $invoice_str = " against Invoice no ".$invoice_id;  
  }
  else{
    $invoice_str = "";
  }
  $particular = "Refund paid".$invoice_str." by ".$payment_mode." for refund id ".$refund_id;

  return $particular;

}



function get_refund_charges_particular($invoice_id, $refund_id,$vendor_type, $vendor_type_id,$date, $payment_mode='')

{


  $cur_date = date('d-m-Y');
  $vendor_name = get_vendor_name($vendor_type, $vendor_type_id);

  $particular = 'Payment received through'.$payment_mode.' for '.$vendor_type.' Services from '.$vendor_name.' on '.$cur_date.' against Inv. No '.$invoice_str.' dt '.$date;

  return $particular;

}



function get_ledger_particular($side,$service)
{
  $particular = $side.' '.$service;  
  return $particular;
}

//Opening balance particular
function get_bank_opening_balance_particular($bank_name,$branch_name,$opening_balance,$as_of_date)
{
  $as_of_date = get_date_user($as_of_date);
  $particular = "Being Opening balance added for bank ".$bank_name.'('.$branch_name.') As of date '.$as_of_date.' of amount '.$opening_balance.' Rs.';

  return $particular;
}
function get_sup_opening_balance_particular($vendor_type,$opening_balance,$as_of_date,$username)
{
  $as_of_date = get_date_user($as_of_date);
  $particular = "Being Opening balance added for ".$vendor_type.'('.$username.')'.' As of date '.$as_of_date.' of amount '.$opening_balance.' Rs.';

  return $particular;
}
function get_b2b_deposit_particular($bank_id,$deposit)
{
  $sq_bank_info = mysql_fetch_assoc(mysql_query("select * from bank_master where bank_id='$bank_id'"));
  if($sq_bank_info != ''){ $particular = 'Being Deposit of '.$deposit.' received in bank '.$sq_bank_info['bank_name'].'('.$sq_bank_info['branch_name'].')'; }
  else{
    $particular = 'Being Deposit of '.$deposit.' received by Cash';
  }

  return $particular;
}
?>