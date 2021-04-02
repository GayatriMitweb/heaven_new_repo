<?php 
class cancel_booking{

public function cancel_booking_save()
{
	$entry_id_arr = $_POST['entry_id_arr'];

	for($i=0; $i<sizeof($entry_id_arr); $i++){
		$sq_cancel = mysql_query("update bus_booking_entries set status='Cancel' where entry_id='$entry_id_arr[$i]'");
		if(!$sq_cancel){
			echo "error--Sorry, Cancellation has been successfully done!";
			exit;
		}
	}
	
	//Cancelation notification mail send
	$this->cancel_mail_send($entry_id_arr);
	echo "Cancellation has been successfully done!";
	exit;

}

public function cancel_mail_send($entry_id_arr)
{
	global $encrypt_decrypt,$secret_key;
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where entry_id='$entry_id_arr[0]'"));
	$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$sq_entry[booking_id]'"));
	$date = $sq_bus_info['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_bus_info[customer_id]'"));

    $email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
	$content1 = '';

	for($i=0; $i<sizeof($entry_id_arr); $i++)
	{
	$sq_entry = mysql_fetch_assoc(mysql_query("select * from bus_booking_entries where entry_id='$entry_id_arr[$i]'"));

	$content1 .= '
				  <tr>
      				<td style="text-align:left;border: 1px solid #888888;">'.($i+1).'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_entry['company_name'].'</td>   
   				 </tr> 
	';

	}

	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
	$content = '	                    
		<tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Bus Operator
      </th>
    </tr>
    
      '.$content1.'
    
  </table>
</tr>
	';
	$subject = 'Bus Cancellation Confirmation('.get_bus_booking_id($sq_entry['booking_id'],$year).' )';
	global $model;
	$model->app_email_send('36',$sq_customer['first_name'],$email_id , $content, $subject);
}


}
?>