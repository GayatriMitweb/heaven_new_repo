<?php

include_once('../model.php');

 	$due_date=date('Y-m-d');
 	$sq_visa = mysql_num_rows(mysql_query("select * from visa_master where due_date='$due_date'"));
	 global $secret_key,$encrypt_decrypt;


 	if($sq_visa>0){



	 	$sq_visa_details = mysql_query("select * from visa_master where due_date='$due_date'");



		 while ($row_visa = mysql_fetch_assoc($sq_visa_details)) {

		 	 

		 	$visa_id = $row_visa['visa_id'];

		 	$visa_total_cost = $row_visa['visa_total_cost'];

		 	$tour_name = '';

		 	$customer_id = $row_visa['customer_id'];



		 	$sq_cust = mysql_query("select * from customer_master where customer_id='$customer_id'");



		   while($row_cust = mysql_fetch_assoc($sq_cust)){


		   $email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);

		   $sq_total_paid = mysql_query("select sum(payment_amount) as sum from visa_payment_master where visa_id='$visa_id' and (clearance_status='Cleared' or clearance_status='')");



		   while ($row_total = mysql_fetch_assoc($sq_total_paid)) {

			 

		   $paid_amount = $row_total['sum'];



		   $balance_amount = $visa_total_cost - $paid_amount;



			if($balance_amount>0){

			  	$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'visa_payment_pending_remainder' and date='$due_date' and status='Done'"));

				if($sq_count==0)

				{

				    global $model;
				    $subject = 'Visa payment Reminder !';
				   $model->generic_payment_remainder_mail('82',,$row_cust['first_name'],$balance_amount, $tour_name, $visa_id, $customer_id, $email_id,$subject,$$visa_total_cost,$due_date );

				}

			}

	   }

	}

	}

}

$row=mysql_query("SELECT max(id) as max from remainder_status");

$value=mysql_fetch_assoc($row);

$max=$value['max']+1;

$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','visa_payment_pending_remainder','$due_date','Done')");



?>