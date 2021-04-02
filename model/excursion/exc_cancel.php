<?php 

$flag = true;

class exc_cancel{



public function exc_cancel_save()

{

	$entry_id_arr = $_POST['entry_id_arr'];
	for($i=0; $i<sizeof($entry_id_arr); $i++){

		$sq_cancel = mysql_query("update excursion_master_entries set status='Cancel' where entry_id='$entry_id_arr[$i]'");

		if(!$sq_cancel){

			echo "error--Sorry, Cancellation not done!";

			exit;

		}

	}

	//Cancelation notification mail send

	$this->cancel_mail_send($entry_id_arr);



	//Cancelation notification sms send

	$this->cancelation_message_send($entry_id_arr);



	echo "Activity has been successfully cancelled.";

	

}

public function cancel_mail_send($entry_id_arr)

{
	global $secret_key,$encrypt_decrypt;

	$sq_entry = mysql_fetch_assoc(mysql_query("select * from excursion_master_entries where entry_id='$entry_id_arr[0]'"));

	$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$sq_entry[exc_id]'"));
	$date = $sq_exc_info['created_at'];
    $yr = explode("-", $date);
 	$year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_info[customer_id]'"));

	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key); 


	$content1 = '';



	for($i=0; $i<sizeof($entry_id_arr); $i++)

	{
	  $sq_entry = mysql_fetch_assoc(mysql_query("select * from excursion_master_entries where entry_id='$entry_id_arr[$i]'"));	
	  $sq_exc = mysql_fetch_assoc(mysql_query("select * from excursion_master_tariff where entry_id = '$sq_entry[exc_name]'"));

	$content1 .= '
	<tr>
      <td style="text-align:left;border: 1px solid #888888;">'.($i+1).'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_exc['excursion_name'].'</td>   
    </tr>

	';
	}

	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

	$content = '   
		<tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Activity Name
      </th>
    </tr>
    
      '.$content1.'
    
  </table>
</tr> 
	';

	$subject = 'Activity Cancellation Confirmation(Booking ID : '.get_exc_booking_id($sq_entry['exc_id'],$year).'  )';

	global $model;



	$model->app_email_send('42',$sq_customer['first_name'],$email_id, $content,$subject);

}



public function cancelation_message_send($entry_id_arr)

{
	global $secret_key,$encrypt_decrypt;
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from excursion_master_entries where entry_id='$entry_id_arr[0]'"));

	$sq_exc_info = mysql_fetch_assoc(mysql_query("select * from excursion_master where exc_id='$sq_entry[exc_id]'"));

	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_exc_info[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);


	$message = 'We are accepting your cancellation request for Activity Booking.';

  	global $model;

  	$model->send_message($contact_no, $message);

}



}

?>