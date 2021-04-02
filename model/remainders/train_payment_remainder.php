<?php
include_once('../model.php');
 	$due_date=date('Y-m-d');
	 global $secret_key,$encrypt_decrypt;

 	$sq_train = mysql_num_rows(mysql_query("select * from train_ticket_master where payment_due_date='$due_date'"));

 	if($sq_train>0){

	 	$sq_train_details =  mysql_query("select * from train_ticket_master where payment_due_date='$due_date'");

	 	while ($row_train = mysql_fetch_assoc($sq_train_details)) {
	 		 
	 	$train_id = $row_train['train_ticket_id'];
	 	$train_total_cost = $row_train['net_total'];
	 	$tour_name = '';
	 	$customer_id = $row_train['customer_id'];

	   	$sq_cust = mysql_query("select * from customer_master where customer_id='$customer_id'");

	    while($row_cust = mysql_fetch_assoc($sq_cust)){
	   
		   $email_id = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
	   	$sq_total_paid = mysql_query("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$train_id' and (clearance_status='Cleared' or clearance_status='')");

		   while($row_paid = mysql_fetch_assoc($sq_total_paid)){

		   $paid_amount = $row_paid['sum'];

		   $balance_amount = $train_total_cost - $paid_amount;


		  if($balance_amount>0){
	  		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'train_payment_pending_remainder' and date='$due_date' and status='Done'"));
			if($sq_count==0)
			{	
				$subject = 'Train Ticket payment Reminder !';
			    global $model;	
			   $model->generic_payment_remainder_mail('84', $row_cust['first_name'],$balance_amount, $tour_name, $train_id, $customer_id, $email_id, $subject,$train_total_cost,$due_date);
			}
		 }
	   	}
	}
}
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','train_payment_pending_remainder','$due_date','Done')");
?>