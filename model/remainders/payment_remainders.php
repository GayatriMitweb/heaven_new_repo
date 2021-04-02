<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
 	$sq_tour = mysql_num_rows(mysql_query("select * from tourwise_traveler_details where balance_due_date='$due_date' and tour_group_status!='cancel'"));
 	if($sq_tour>0){
	 	$sq_tour_details = mysql_query("select * from tourwise_traveler_details where balance_due_date='$due_date' and tour_group_status!='cancel'");
	 	while($row_tour = mysql_fetch_assoc($sq_tour_details)){

			$booking_id = $row_tour['id'];
			$total_tour_fee = $row_tour['total_tour_fee'];
			$total_travel_fee = $row_tour['total_travel_expense'];
			$tour_id = $row_tour['tour_id'];
			$customer_id = $row_tour['customer_id'];

			$sq_tour_name = mysql_fetch_assoc(mysql_query("select * from tour_master where tour_id='$tour_id'"));
			$tour_name = $sq_tour_name['tour_name'];

		   $total_amount = $total_travel_fee + $total_tour_fee;

		   $sq_total_paid = mysql_query("select sum(amount) as sum from payment_master where tourwise_traveler_id='$booking_id' and (clearance_status='Cleared' or clearance_status='')");

		   while($row_total_paid = mysql_fetch_assoc($sq_total_paid)){
		   $paid_amount = $row_total_paid['sum'];

		   $payment_remain = $total_amount - $paid_amount;
		  

		    $sq_cust = mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$booking_id'");

		    while($row_cust = mysql_fetch_assoc($sq_cust)){
				$email_id = $row_cust['email_id'];
				$t_id = $row_cust['tourwise_traveler_id'];
				$c_id = mysql_fetch_assoc(mysql_query("select customer_id from tourwise_traveler_details"));
				$name = mysql_fetch_assoc(mysql_query("select first_name from customer_master where customer_id='$c_id'"));  
				$payment_id = get_group_booking_payment_id($payment_id);

				if($payment_remain>0){
					$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'git_payment_pending_remainder' and date='$due_date' and status='Done'"));
					if($sq_count==0){
						$subject = 'Group Tour Payment Reminder ! (Booking ID : '.$booking_id.' ).';
						global $model;
						$model->generic_payment_remainder_mail('80',$name['first_name'],$payment_remain, $tour_name, $booking_id, $customer_id, $email_id ,$subject,$total_amount,$due_date);
					}				
				}
			}
	   }
	}
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','git_payment_pending_remainder','$due_date','Done')");
?>