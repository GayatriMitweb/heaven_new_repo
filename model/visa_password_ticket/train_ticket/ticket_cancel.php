<?php 
class ticket_cancel{

public function ticket_cancel_save()
{
	$entry_id_arr = $_POST['entry_id_arr'];

	for($i=0; $i<sizeof($entry_id_arr); $i++){
		$sq_cancel = mysql_query("update train_ticket_master_entries set status='Cancel' where entry_id='$entry_id_arr[$i]'");
		if(!$sq_cancel){
			echo "error--Sorry, Cancelation not done!";
			exit;
		}
	}

	//Cancelation notification mail send
	$this->cancel_mail_send($entry_id_arr);

	//Cancelation notification sms send
	$this->cancelation_message_send($entry_id_arr);

	echo "Train ticket has been successfully cancelled.";
}


public function cancel_mail_send($entry_id_arr){

	global $model,$encrypt_decrypt,$secret_key;

	$sq_entry = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_entries where entry_id='$entry_id_arr[0]'"));
	$sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$sq_entry[train_ticket_id]'"));

	$date = $sq_train_ticket_info['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];

	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_train_ticket_info[customer_id]'"));
	$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$content1 = '';

	for($i=0; $i<sizeof($entry_id_arr); $i++){
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_entries where entry_id='$entry_id_arr[$i]'"));

	$content1 .= '
				  <tr>
				  <td style="text-align:left;border: 1px solid #888888;">'.($i+1).'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_entry['first_name'].' '.$sq_entry['last_name'].'</td>   
				</tr> 
				  ';
	}

	$content = '
	<tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Passenger Name
      </th>
    </tr>
    
      '.$content1.'
    
  </table>
</tr> ';
	$subject = 'Train Ticket Cancellation Confirmation('.get_train_ticket_booking_id($sq_train_ticket_info['train_ticket_id'],$year).' )';
	
	$model->app_email_send('34',$sq_customer['first_name'],$email_id, $content,$subject);
}


public function cancelation_message_send($entry_id_arr){
	global $secret_key,$encrypt_decrypt;

	$sq_entry = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_entries where entry_id='$entry_id_arr[0]'"));
	$sq_train_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$sq_entry[train_ticket_id]'"));
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_train_ticket_info[customer_id]'"));

	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	
	$message = 'We are accepting your cancellation request for Train Ticket booking.';
  	global $model;
  	$model->send_message($contact_no, $message);
}

}
?>