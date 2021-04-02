<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	global $secret_key,$encrypt_decrypt;
 	$sq_passport = mysql_num_rows(mysql_query("select * from passport_master where due_date='$due_date'"));

 	if($sq_passport>0){

	 	$sq_passport_details = mysql_query("select * from passport_master where due_date='$due_date'");

	 	while($row_passport = mysql_fetch_assoc($sq_passport_details)){

	 	$passport_id = $row_passport['passport_id'];
	 	$passport_total_cost = $row_passport['passport_total_cost'];
	 	$tour_name = '';
	 	$customer_id = $row_passport['customer_id'];

	 	$sq_cust =  mysql_query("select * from customer_master where customer_id='$customer_id'");

	 	while ($row_cust = mysql_fetch_assoc($sq_cust)) {
	 		 
		 
		   $email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
		   $sq_total_paid = mysql_query("select sum(payment_amount) as sum from passport_payment_master where passport_id='$passport_id' and (clearance_status='Cleared' or clearance_status='')");

		  while($row_paid = mysql_fetch_assoc($sq_total_paid)){
		  $paid_amount = $row_paid['sum'];
		  $balance_amount = $passport_total_cost - $paid_amount;		  
		  if($balance_amount>0){
		  	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'passport_payment_pending_remainder' and date='$due_date' and status='Done'"));
			if($sq_count==0){
				global $model;
				$subject = 'Passport Payment Reminder ( Booking ID :'.$booking_id.' ).';
				$model->generic_payment_remainder_mail('88', $row_cust['first_name'],$balance_amount, $tour_name, $booking_id, $customer_id, $email_id, $subject,$passport_total_cost,$due_date);
			}
		  }
	   }
	}
}
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','passport_payment_pending_remainder','$due_date','Done')");

?>