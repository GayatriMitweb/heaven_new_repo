<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	
 	$sq_hotel = mysql_num_rows(mysql_query("select * from hotel_booking_master where due_date='$due_date'"));

 	if($sq_hotel>0){

	 	$sq_hotel_details = mysql_query("select * from hotel_booking_master where due_date='$due_date'");

	 	while($row_hotel = mysql_fetch_assoc($sq_hotel_details)){

	 	$hotel_id = $row_hotel['booking_id'];
	 	$hotel_total_cost = $row_hotel['total_fee'];
	 	$tour_name = '';
	 	$customer_id = $row_hotel['customer_id'];

	 	$sq_cust = mysql_query("select * from customer_master where customer_id='$customer_id'");

	 	while ($row_cust = mysql_fetch_assoc($sq_cust)) {
	 		 
			global $secret_key,$encrypt_decrypt;
		$email_id  = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
		
	    $sq_total_paid = mysql_query("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$hotel_id' and (clearance_status='Cleared' or clearance_status='')");

	    while ($row_paid = mysql_fetch_assoc($sq_total_paid)) {
	    
	    $paid_amount = $row_paid['sum'];

	    $balance_amount = $hotel_total_cost - $paid_amount;

		  if($balance_amount>0){
		  	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'hotel_payment_pending_remainder' and date='$due_date' and status='Done'"));
			if($sq_count==0)
			{
			$subject = 'Hotel Booking payment Reminder !';
		    global $model;	
		   $model->generic_payment_remainder_mail('85',$sq_cust['first_name'],$balance_amount, $tour_name, $hotel_id, $customer_id, $email_id,$subject,$hotel_total_cost,$due_date);
		  }
	   }
	}
  }
 }
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','hotel_payment_pending_remainder','$due_date','Done')");
?>