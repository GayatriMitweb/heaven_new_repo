<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	 global $secret_key,$encrypt_decrypt;
 	$sq_car_rental= mysql_num_rows(mysql_query("select * from car_rental_booking where due_date='$due_date'"));

 	if($sq_car_rental>0){

	 	$sq_car_rental_details = mysql_query("select * from car_rental_booking where due_date='$due_date'");

	 	while ($row_car=mysql_fetch_assoc($sq_car_rental_details)) {
	 		 
	 	$booking_id = $row_car['booking_id'];
	 	$total_cost = $row_car['actual_cost'];
	 	$tour_name = '';
	 	$customer_id = $row_car['customer_id'];

	 	$sq_cust = mysql_query("select * from customer_master where customer_id='$customer_id'");

	 	while($row_cust=mysql_fetch_assoc($sq_cust)){

	   
		   $contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
		   $email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
	   	$sq_total_paid = mysql_query("select sum(payment_amount) as sum from car_rental_payment where booking_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");

	   while ($row_paid=mysql_fetch_assoc($sq_total_paid)) {
	    
	   $paid_amount = $row_paid['sum'];

	   $balance_amount = $total_cost - $paid_amount;

	  if($balance_amount>0){
	  	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'car_payment_pending_remainder' and date='$due_date' and status='Done'"));
			if($sq_count==0)
			{
				$subject = 'Car Rental payment Reminder !';
		    	global $model;	
		   		$model->generic_payment_remainder_mail('87' ,$row_cust['first_name'],$balance_amount, $tour_name, $booking_id, $customer_id, $email_id, $subject,$total_cost,$due_date);
		  	}
		}
	}
	}
  }
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','car_payment_pending_remainder','$due_date','Done')");
?>