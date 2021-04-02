<?php
class payment_email{

function payment_remainder_notification_send()
 {
 	$due_date=date('Y-m-d');

 	$sq_tour_details = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where due_date='$due_date' and tour_status!='cancel'"));

 	$booking_id = $sq_tour_details['booking_id'];
 	$total_tour_fee = $sq_tour_details['actual_tour_expense'];
 	$total_travel_fee = $sq_tour_details['total_travel_expense'];
 	$tour_name = $sq_tour_details['tour_name'];
 	$customer_id = $sq_tour_details['customer_id'];

 	$total_amount = $sq_tour_details['total_travel_expense'] + $sq_tour_details['total_tour_fee'];

   $sq_total_paid = mysql_fetch_assoc(mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status='Cleared'"));

   $paid_amount = $sq_total_paid['sum'];

   $balance_amount = $total_amount - $paid_amount;

   $email_id = $sq_tour_details['email_id'];

  if($balance_amount>0){
  	$subject = 'Package Tour Payment Reminder ( Booking ID :'.$booking_id.' ).';
    global $model;
   $model->generic_payment_remainder_mail($balance_amount, $tour_name, $booking_id, $customer_id, $email_id, $subject );

   }
}

}
 ?>