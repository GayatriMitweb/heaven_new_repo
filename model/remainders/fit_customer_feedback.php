<?php
include_once('../model.php');
	$today = date('Y-m-d');
	$end_date = date('Y-m-d', strtotime('-3 days', strtotime($today)));
	global $secret_key,$encrypt_decrypt;
	$sq_booking_info = mysql_num_rows(mysql_query("select * from package_tour_booking_master where tour_to_date='$end_date'"));

	if($sq_booking_info>0){

		$sq_booking = mysql_query("select * from package_tour_booking_master where tour_to_date='$end_date' and booking_id not in (select booking_id from customer_feedback_master where booking_type='Package Booking')");

		while($row_booking= mysql_fetch_assoc($sq_booking)){
		$customer_id = $row_booking['customer_id'];
		$email_id = $row_booking['email_id'];
		$mobile_no = $row_booking['mobile_no'];
		$tour_name = $row_booking['tour_name'];
		$booking_id = $row_booking['booking_id'];
 
		$booking_id1 = get_package_booking_id($booking_id);

		$journey_date = date('d-m-Y',strtotime($row_booking['tour_from_date'])).' To '.date('d-m-Y',strtotime($row_booking['tour_to_date']));

		$sq_customer = mysql_query("select * from customer_master where customer_id ='$customer_id'");

		while ($row_cust = mysql_fetch_assoc($sq_customer)) {
			 
		// $username = $row_cust['contact_no'];
		// $password = $row_cust['email_id'];
		$username = $encrypt_decrypt->fnDecrypt($row_cust['contact_no'], $secret_key);
		$password = $encrypt_decrypt->fnDecrypt($row_cust['email_id'], $secret_key);
		$cust_name = $row_cust['first_name'].' '.$row_cust['last_name'];

		$sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'fit_customer_feedback' and date='$today' and status='Done'"));
		if($sq_count==0)
		{

		 feedback_email_send($email_id,$booking_id,$tour_name,$journey_date,$username,$password,$row_cust['first_name'],$customer_id);
		 feedback_sms_send($mobile_no);
			 
		}

		} 
	}
 }
 $row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','fit_customer_feedback','$today','Done')");

function feedback_email_send($email_id,$booking_id,$tour_name,$journey_date,$username,$password,$cust_name,$customer_id)
{
	global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$theme_color;
	$link = BASE_URL.'view/customer';
	
	$content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Booking ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$booking_id.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$tour_name.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;"> Journey Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$journey_date.'</td></tr>
			 
			</table>
		  </tr>
		  <tr>
		  <td>
		  <table style="padding:0 30px; margin:0px auto; margin-top:10px">
		  <tr>
		  <td colspan="2">
		  <a style="font-weight:500;font-size:14px;display:inline-block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 15px;border-radius:25px;width:95px;text-align:center" href='.$link.' target="_blank">Login</a>&nbsp;&nbsp;
		  <a style="font-weight:500;font-size:14px;display:inline-block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 15px;border-radius:25px;width:auto;text-align:center" href="'.BASE_URL.'view/customer/other/customer_feedback/customer_feedback_form.php?customer_id='.$customer_id.'&booking_id='.$booking_id.'&tour_name=Package Booking" target="_blank">Tour Feedback</a>
		  </td>
		  </tr>
		 
		  </table>
		  </td>
		  </tr> 
		  ';
		  
	$subject = 'Invite you to leave us your FEEDBACK! (Tour Name : '.$tour_name.', Customer Name : '.$cust_name.' )';
	global $model;
	$model->app_email_send('78',$cust_name,$email_id, $content,$subject,'1');
}


 function feedback_sms_send($mobile_no)
{
	global $app_name;
	
	$message = "We take the opportunity of your valuable feedback of ".$app_name."  tours that will help to continue our high quality and to save precious customers.";
	
	global $model;
   	$model->send_message($mobile_no, $message);
}