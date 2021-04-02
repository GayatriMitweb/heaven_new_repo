<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
global $secret_key,$encrypt_decrypt;
 	$sq_air = mysql_num_rows(mysql_query("select * from ticket_master where due_date='$due_date'"));

 	if($sq_air>0){

	 	$sq_air_details = mysql_query("select * from ticket_master where due_date='$due_date'");

	 	while ($row_air = mysql_fetch_assoc($sq_air_details)) {

	 	$air_id = $row_air['ticket_id'];
	 	$air_total_cost = $row_air['ticket_total_cost'];
	 	$tour_name = '';
	 	$customer_id = $row_air['customer_id'];

	 	$sq_cust = mysql_query("select * from customer_master where customer_id='$customer_id'");

	 	while ($row_cust = mysql_fetch_assoc($sq_cust)) {
			$email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
	   

	   $sq_total_paid = mysql_query("select sum(payment_amount) as sum from ticket_payment_master where ticket_id='$air_id' and (clearance_status='Cleared' or clearance_status='')");

	   while ($row_paid = mysql_fetch_assoc($sq_total_paid)) {

	   $paid_amount = $row_paid['sum'];

	   $balance_amount = $air_total_cost - $paid_amount;

	   
		  if($balance_amount>0){
		  	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'air_payment_pending_remainder' and date='$due_date' and status='Done'"));
				if($sq_count==0)
				{
					$subject = 'Flight payment Reminder !';
			    	global $model;
				    $model->generic_payment_remainder_mail('83', $row_cust['first_name'],$balance_amount, $tour_name, $air_id, $customer_id, $email_id, $subject,$air_total_cost,$due_date);
			  	}
			}
		   }
		}
	}
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','air_payment_pending_remainder','$due_date','Done')");
?>