<?php 

//Group booking ID return

function get_group_booking_id($tourwise_traveler_id,$year){ 
  global $app_version;
  $year = ($year == '') ? $app_version : $year;
  return 'GB/'.$year.'/'.$tourwise_traveler_id; }

function get_group_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'GB/'.$year.'/P/'.$payment_id; }

function get_group_booking_group_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'GB/'.$year.'/GR/'.$refund_id; }

function get_group_booking_traveler_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'GB/'.$year.'/TR/'.$refund_id; }



//Package booking ID return

function get_package_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PB/'.$year.'/'.$booking_id; }

function get_package_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PB/'.$year.'/P/'.$payment_id; }

function get_package_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PB/'.$year.'/R/'.$refund_id; }

function get_b2b_booking_id($booking_id,$year){
  return 'B2B/'.$year.'/'.$booking_id; }

function get_b2b_booking_refund_id($booking_id,$year){
  return 'B2B/'.$year.'/R/'.$booking_id;
}

//Visa booking ID return
function get_visa_booking_id($visa_id, $year){
  global $app_version;
  $year = ($year == '') ? $app_version : $year;
 return 'VS/'.$year.'/'.$visa_id; 
}

function get_visa_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'VS/'.$year.'/P/'.$payment_id; }

function get_visa_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'VS/'.$year.'/R/'.$refund_id; }



//Passport booking ID return

function get_passport_booking_id($passport_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PS/'.$year.'/'.$passport_id; }

function get_passport_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PS/'.$year.'/P/'.$payment_id; }

function get_passport_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'PS/'.$year.'/R/'.$refund_id; }



//Ticket booking ID return

function get_ticket_booking_id($ticket_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'FLT/'.$year.'/'.$ticket_id; }

function get_ticket_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'FLT/'.$year.'/P/'.$payment_id; }

function get_ticket_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'FLT/'.$year.'/R/'.$refund_id; }



//Train Ticket booking ID return

function get_train_ticket_booking_id($train_ticket_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'TTK/'.$year.'/'.$train_ticket_id; }

function get_train_ticket_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'TTK/'.$year.'/P/'.$payment_id; }

function get_train_ticket_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'TTK/'.$year.'/R/'.$refund_id; }



//Hotel booking ID return

function get_hotel_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'HB/'.$year.'/'.$booking_id; }

function get_hotel_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'HB/'.$year.'/P/'.$payment_id; }

function get_hotel_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'HB/'.$year.'/R/'.$refund_id; }



//Car rental booking ID return

function get_car_rental_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'CR/'.$year.'/'.$booking_id; }

function get_car_rental_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'CR/'.$year.'/P/'.$payment_id; }

function get_car_rental_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'CR/'.$year.'/R/'.$refund_id; }



//Car rental booking ID return

function ge_vendor_request_id($request_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'VQR/'.$year.'/'.$request_id; }



//Employee salary ID return

function get_emp_salary_id($salary_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'ES/'.$year.'/'.$salary_id; }



//Office Expense ID return

function get_other_expense_payment_id($expense_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'OEP/'.$year.'/'.$expense_id; }
function get_other_expense_booking_id($expense_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'OE/'.$year.'/'.$expense_id; }



//Other Income ID return

function get_other_income_payment_id($income_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'OIP/'.$year.'/'.$income_id; }





//Vendor Payment

function get_vendor_estimate_id($estimate_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'SE/'.$year.'/'.$estimate_id; }

function get_vendor_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'SP/'.$year.'/'.$payment_id; }

function get_vendor_refund_id($refund_id,$year){ global $app_version; return 'SR/'.$year.'/'.$refund_id; }



//TDS Payment

function get_tds_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'TDS/'.$year.'/'.$payment_id; }





//Get Booking IDS

function get_booking_id($module){ $booking_id = ""; if($module==""){  } global $app_version;
$year = ($year == '') ? $app_version : $year; return $booking_id; }



//Get Miscellaneous booking id

function get_misc_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'MB/'.$year.'/'.$booking_id; }
function get_misc_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;return 'MB/'.$year.'/P/'.$payment_id; }
function get_misc_booking_refund_id($refund_id,$year){  global $app_version;
  $year = ($year == '') ? $app_version : $year;return 'MB/'.$year.'/R/'.$refund_id; }

//Get Bus booking id

function get_bus_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'BB/'.$year.'/'.$booking_id; }

function get_bus_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'BB/'.$year.'/P/'.$payment_id; }

function get_bus_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'BB/'.$year.'/R/'.$refund_id; }



//Get Forex booking id

function get_forex_booking_id($booking_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'FB/'.$year.'/'.$booking_id; }

function get_forex_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'FB/'.$year.'/P/'.$payment_id; }



//Get Quotation ID

function get_quotation_id($quotation_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'QTP/'.$year.'/'.$quotation_id; }



//Get Enquiries ID

function get_enquiry_id($enquiry_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'ENQ/'.$year.'/'.$enquiry_id; }

//GST payment ID
function get_gst_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'GP/'.'/P/'.$payment_id; }

//Flight supplier payment ID
function get_flight_supplier_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'ASP/'.'/P/'.$payment_id; }

//visa supplier payment ID
function get_visa_supplier_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'VSP/'.'/P/'.$payment_id; }

//Visa booking ID return

function get_exc_booking_id($exc_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'AS/'.$year.'/'.$exc_id; }

function get_exc_booking_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'AS/'.$year.'/P/'.$payment_id; }

function get_exc_booking_refund_id($refund_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'AS/'.$year.'/R/'.$refund_id; }

function get_jv_entry_id($jv_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'JV/'.$year.'/'.$jv_id; }

function get_credit_note_id($credit_id){ global $app_version;
  return 'CN/'.$credit_id; }
function get_debit_note_id($debit_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year; return 'DN/'.$year.'/'.$debit_id; }

//customer Advance payment ID
function get_custadv_payment_id($payment_id,$year){ global $app_version;
  $year = ($year == '') ? $app_version : $year;  return 'CAP/'.$year.'/P/'.$payment_id; }
?>
