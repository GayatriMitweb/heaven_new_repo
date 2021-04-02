<?php
include_once('../model.php');
 
 	$due_date=date('Y-m-d');

 	$sq_package = mysql_num_rows(mysql_query("select * from package_tour_booking_master where due_date='$due_date' and tour_status!='cancel'"));

 	if($sq_package>0){

	 	$sq_tour_details = mysql_query("select * from package_tour_booking_master where due_date='$due_date' and tour_status!='cancel'");

	 	while($row_tour_details= mysql_fetch_assoc($sq_tour_details)){

	 	$booking_id = $row_tour_details['booking_id'];
	 	$total_tour_fee = $row_tour_details['actual_tour_expense'];
	 	$total_travel_fee = $row_tour_details['total_travel_expense'];
	 	$tour_name = $row_tour_details['tour_name'];
	 	$customer_id = $row_tour_details['customer_id'];
	 	$email_id = $row_tour_details['email_id'];

	 	$total_amount = $total_travel_fee + $total_tour_fee;

	   $sq_total_paid =  mysql_query("select sum(amount) as sum from package_payment_master where booking_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");
	   $customer_name = mysql_fetch_assoc(mysql_query("select first_name from customer_master where customer_id='$customer_id'"));
	   while ($row_paid = mysql_fetch_assoc($sq_total_paid)) {

	   $paid_amount = $row_paid['sum'];

	   $balance_amount = $total_amount - $paid_amount;

	  if($balance_amount>0){
  		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'fit_payment_pending_remainder' and date='$due_date' and status='Done'"));
		if($sq_count==0)
		{	
			$subject = 'Package Tour Payment Reminder';
			global $model;
	  		$model->generic_payment_remainder_mail('81',$customer_name['first_name'],$balance_amount, $tour_name, $booking_id, $customer_id, $email_id,$subject,$total_amount,$due_date );
		}
	   }
	}
}
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','fit_payment_pending_remainder','$due_date','Done')");

 

?>