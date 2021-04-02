<?php 
class passport_cancel{

public function passport_cancel_save()
{
	$entry_id_arr = $_POST['entry_id_arr'];

	for($i=0; $i<sizeof($entry_id_arr); $i++){
		$sq_cancel = mysql_query("update passport_master_entries set status='Cancel' where entry_id='$entry_id_arr[$i]'");
		if(!$sq_cancel){
			echo "error--Sorry, Cancelation not done!";
			exit;
		}
	}

	//Cancelation notification mail send
	$this->cancel_mail_send($entry_id_arr);

	//Cancelation notification sms send
	$this->cancelation_message_send($entry_id_arr);

	echo "Passport has been successfully cancelled.";
}

public function cancel_mail_send($entry_id_arr)
{
	global $model,$app_name,$encrypt_decrypt,$secret_key;
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from passport_master_entries where entry_id='$entry_id_arr[0]'"));
	$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$sq_entry[passport_id]'"));

	$date = $sq_passport_info['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));
	$email = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$content1 = '';

	for($i=0; $i<sizeof($entry_id_arr); $i++)
	{
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from passport_master_entries where entry_id='$entry_id_arr[$i]'"));

	$content1 .= '<tr>
	                <td style="color: #22262e;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.($i+1).'</td>
	                <td style="color: #22262e;font-size: 14px;text-align: left;padding-left: 10px;font-weight: 500;">'.$sq_entry['first_name'].' '.$sq_entry['last_name'].'</td>
	              </tr>
	';
	}
	$content = '
	    <table style="padding:0 30px; width:100%">
	      <tr>
	        <td>
	          <table style="width:100%">  
	          <tr>
	            <td>
	              <table  style="width:100%">	                    
	                <tr>
	                  <td>
	                    <table style="background: #fff; color: #22262e; font-size: 13px;width:100%; margin-bottom:20px;">
	                        <tr>
	                          <th style="padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E;">Sr.No</th>
	                          <th style="padding-left: 10px;border: 1px solid #c1c1c1;text-align: left;font-weight: 500;background: #ddd;font-size: 14px;color: #22262E;">Passenger Name</th>
	                        </tr>
	                        '.$content1.'
	                    </table>
	                  </td>
	                </tr>
	              </table>
	            </td>
	          </tr>
	        </td>
	      </tr>	      
	    </table>
	';
	$subject = 'Passport Cancellation Confirmation( '.get_passport_booking_id($sq_passport_info['passport_id'],$year).' )';

	$model->app_email_send('109',$sq_customer['first_name'],$email_id, $content, $subject,'1');
}

public function cancelation_message_send($entry_id_arr)
{
	global $secret_key,$encrypt_decrypt;
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from passport_master_entries where entry_id='$entry_id_arr[0]'"));
	$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$sq_entry[passport_id]'"));
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_passport_info[customer_id]'"));
	$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
	$message = 'We are accepting your cancellation request for Passport booking.';
  	global $model;
  	$model->send_message($contact_no, $message);
}

}
?>