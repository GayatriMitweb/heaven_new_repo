<?php 
class cancel_booking{

public function cancel_booking_save($traveler_id_arr, $booking_id)
{
	for($i=0; $i<sizeof($traveler_id_arr); $i++){

		$sq = mysql_query("update package_travelers_details set status='Cancel' where traveler_id='$traveler_id_arr[$i]'");
		if(!$sq){
			echo "error--Sorry, Some error in cancellation.";
			exit;
		}

	}

	echo "Package booking has been successfully Cancelled.";
	//Cancelation mail send
    $this->traveler_cancelation_mail_send($traveler_id_arr, $booking_id);
}

public function traveler_cancelation_mail_send($traveler_id_arr, $booking_id)
{
  global $encrypt_decrypt,$secret_key;
  $sq_tour = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$booking_id'"));
  $tour_date = date('d-m-Y', strtotime($sq_tour['tour_from_date'])). ' To '.date('d-m-Y', strtotime($sq_tour['tour_to_date']));
  $customer_id = $sq_tour['customer_id'];

  $date = $sq_tour['booking_date'];
  $yr = explode("-", $date);
  $year =$yr[0];
  $sq_personal_info1 = mysql_query("select * from package_travelers_details where booking_id='$booking_id'");
  $content1 = '';

    $count = 0;
    while($sq_personal_info = mysql_fetch_assoc($sq_personal_info1)){
    $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
    
    $email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
    $count++;
    $content1 .= '
            <tr>
             <td style="text-align:left;border: 1px solid #888888;">'.$count.'</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_personal_info['first_name'].' '.$sq_personal_info['last_name'].'</td>   
           </tr>
    ';
  }

  global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
  $content = '
  <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
    <td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tour[tour_name].'</td>   
    <tr>
      <td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_date .'</td>   
    </tr>   
  </tr>   
    </table>
  </tr>
  <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
    <tr>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Sr.No</th>
      <th style="border: 1px solid #888888;text-align: left;background: #ddd;color: #888888;">Guest Name
      </th>
    </tr>
  
    '.$content1.'
  
</table>
</tr>  
  ';
  $subject = 'Tour Cancellation Confirmation. ( '.get_package_booking_id($booking_id,$year).' ,'.$sq_tour['tour_name'].' )';
  global $model;

  $model->app_email_send('28',$sq_customer['first_name'],$email_id, $content,$subject);
}
///////////////////////////////////////Traveler Cancelation mail send end/////////////////////////////////////////////////////////////////////////////////////////
}
?>