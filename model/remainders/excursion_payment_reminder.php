<?php
include_once('../model.php');
global $secret_key,$encrypt_decrypt;
$due_date=date('Y-m-d');
$sq_air = mysql_num_rows(mysql_query("select * from excursion_master where due_date='$due_date'"));
if($sq_air>0){

	$sq_air_details = mysql_query("select * from excursion_master where due_date='$due_date'");
	while($row_air = mysql_fetch_assoc($sq_air_details)){

		$air_id = $row_air['exc_id'];
		$exc_total_cost = $row_air['exc_total_cost'];
		$tour_name = '';
		$customer_id = $row_air['customer_id'];

		$sq_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
	
		$email_id = $encrypt_decrypt->fnDecrypt($sq_cust['email_id'], $secret_key);
		$sq_total_paid = mysql_query("select sum(payment_amount) as sum from exc_payment_master where exc_id='$air_id' and (clearance_status='Cleared' or clearance_status='')");
		while($row_paid = mysql_fetch_assoc($sq_total_paid)){

			$paid_amount = $row_paid['sum'];
    		$balance_amount = $exc_total_cost - $paid_amount;
			if($balance_amount>0){
				$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'excursion_payment_pending_remainder' and date='$due_date' and status='Done'"));
				if($sq_count==0){
					global $model;
					$subject = 'Excursion Payment Reminder !';
					$model->generic_payment_remainder_mail('89',$sq_cust['first_name'],$balance_amount, $tour_name, $air_id, $customer_id, $email_id,$subject,$exc_total_cost,$due_date);
				}
			}
		}
	}
}

$row = mysql_query("SELECT max(id) as max from remainder_status");
$value = mysql_fetch_assoc($row);
$max = $value['max']+1;
$sq_check_status = mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','excursion_payment_pending_remainder','$due_date','Done')");
?>