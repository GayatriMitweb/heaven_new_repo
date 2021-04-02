<?php
include_once('../model.php');
	$today = date('Y-m-d');
	$end_date = date('Y-m-d', strtotime('-5 days', strtotime($today)));

	$sq_tour_group = mysql_num_rows(mysql_query("select * from tour_groups where to_date='$end_date'"));
	if($sq_tour_group>0){

	$sq_tour_group1 = mysql_query("select * from tour_groups where to_date='$end_date'");

	while($row_tour = mysql_fetch_assoc($sq_tour_group1)){
	$tour_to_date = $row_tour['to_date'];
	 
	$tour_id = $row_tour['tour_id'];
	$tour_group_id = $row_tour['group_id'];

	$sq_tour =  mysql_query("select * from tour_master where tour_id='$tour_id'");
	while ($row_tour1 = mysql_fetch_assoc($sq_tour)) {
		 
	$tour_name = $row_tour1['tour_name'];
	$journey_date = date('d-m-Y',strtotime($row_tour['from_date'])).' To '.date('d-m-Y',strtotime($row_tour['to_date']));

	$query = "select * from tourwise_traveler_details where tour_id='$tour_id' and 
	tour_group_id='$tour_group_id' and id not in (select booking_id from customer_feedback_master where booking_type='Group Booking') ";
 
	$sq_bookings = mysql_query($query);
	while($row_bookings = mysql_fetch_assoc($sq_bookings)){

		$tourwise_traveler_id = $row_bookings['id'];
		$customer_id = $row_bookings['customer_id'];

		$booking_id = get_group_booking_id($tourwise_traveler_id);

		$sq_customer1 = mysql_query("select * from customer_master where customer_id ='$customer_id'");

		while ($row_cust=mysql_fetch_assoc($sq_customer1)) {
			 
		// $username = $row_cust['contact_no'];
		// $password = $row_cust['email_id'];
		$username = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
        $password = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key); 
		$cust_name = $row_cust['first_name'].' '.$row_cust['last_name'];

		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = customer_feedback' and date='$today' and status='Done'"));
			if($sq_count==0)
			{
 
			feedback_email_send($email_id,$tourwise_traveler_id,$tour_name,$journey_date,$username,$password,$row_cust['first_name'],$customer_id);
			}
		}
		if($mobile_no!=""){
			feedback_sms_send($mobile_no);
		}

		 
	}
    }	 
   }
}
$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','customer_feedback','$today','Done')");


function feedback_email_send($email_id,$tourwise_traveler_id,$tour_name,$journey_date,$username,$password,$cust_name,$customer_id)
{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
	$booking_id = get_group_booking_id($tourwise_traveler_id);
	 
	$content = '
	<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td>
							<p style="line-height: 24px;"><strong style="'.$mail_strong_style.'">Booking ID :</strong> '.$booking_id.'</p>
							<p style="line-height: 24px;"><strong style="'.$mail_strong_style.'">Tour Name :</strong> '.$tour_name.'</p>
							<p style="line-height: 24px;"><strong style="'.$mail_strong_style.'">Tour Date :</strong> '.$journey_date.'</p>
						</td>
					</tr>
					<tr>
						<td>
			       			<a style="font-weight:500;font-size:14px;display:inline-block;color:#ffffff;background:#009898;text-decoration:none;padding:5px 15px;border-radius:25px;width:95px;text-align:center" href='.$link.' target="_blank">Login</a>&nbsp;&nbsp;
			   			 	<a style="font-weight:500;font-size:14px;display:inline-block;color:#ffffff;background:#009898;text-decoration:none;padding:5px 15px;border-radius:25px;width:auto;text-align:center" href="'.BASE_URL.'view/customer/other/customer_feedback/customer_feedback_form.php?customer_id='.$customer_id.'&booking_id='.$tourwise_traveler_id.'&tour_name=Group Booking" target="_blank">Tour Feedback</a>
			      		</td>
					</tr>
				</table>	
			</td>
		</tr>	
	';
	
	global $model;
	$model->app_email_send('79',$cust_name,$email_id, $content,'1');

}


 function feedback_sms_send($mobile_no)
{
	global $app_name;
	$message = "We take the opportunity of your valuable feedback of ".$app_name." tours that will help to continue our high quality and to save precious customers.";
	
	global $model;
   	$model->send_message($mobile_no, $message);
}


?>