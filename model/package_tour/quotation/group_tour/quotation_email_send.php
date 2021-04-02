<?php
class quotation_email_send{
public function quotation_email()
{
	$quotation_id = $_POST['quotation_id'];
	$quotation_no = base64_encode($quotation_id);
	$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
	$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

	$quotation_date = $sq_quotation['quotation_date'];
	$yr = explode("-", $quotation_date);
	$year =$yr[0];
	
	if($sq_emp_info['first_name']==''){
		$emp_name = 'Admin';
	}
	else{
		$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
	}

	global $app_name, $app_cancel_pdf,$currency_logo,$theme_color;
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

	if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }
	else{
		$url = explode('uploads', $app_cancel_pdf);
		$url = BASE_URL.'uploads'.$url[1];
	}	

	$content = '


	<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_quotation['tour_name'].'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' To '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Quotation Cost</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.number_format($sq_quotation['quotation_cost'],2).'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Created By</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$emp_name.'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">View Quotation</td>   <td style="text-align:left;border: 1px solid #888888;" ><a style="color: '.$theme_color.';text-decoration: none;" href="'.BASE_URL.'model/package_tour/quotation/group_tour/quotation_email_template.php?quotation='.$quotation_no.'">View</a></td></tr>
            </table>
		  </tr>				
	';
    //$emp_id = $row['email_id'];
	$subject = "New Quotation"."(".get_quotation_id($quotation_id,$year).")";
	global $model;
	// $model->app_email_master($sq_quotation['email_id'], $content, $subject);
	$model->app_email_send('8',$sq_quotation['customer_name'],$sq_quotation['email_id'], $content,$subject,'1');
	echo "Quotation email successfully sent.";
	exit;
	
}
	public function quotation_whatsapp(){
		$quotation_id = $_POST['quotation_id'];
		$quotation_no = base64_encode($quotation_id);
		$currency_q = "Rs.";
		global $app_name, $app_cancel_pdf,$model,$quot_note,$app_contact_no;
		
		$all_message = "";
		$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
		
		$mobile_no = mysql_fetch_assoc(mysql_query("SELECT landline_no FROM `enquiry_master` WHERE enquiry_id = ".$sq_quotation['enquiry_id']));
		$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
		$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

		if($sq_login['emp_id'] == 0){
			$contact = $app_contact_no;
		}
		else{
			$contact = $sq_emp_info['mobile_no'];
		}

		$sq_tours_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));		


		$whatsapp_msg = rawurlencode('Hello Dear '.$sq_quotation['customer_name'].',
Hope you are doing great. This is group tour quotation details as per your request. We look forward to having you onboard with us.
*Interested Tour* : '.$sq_quotation[tour_name].'
*Duration* : '.date('d-m-Y', strtotime($sq_quotation['from_date'])).' to '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'
*Cost* : '.$currency_q.number_format($sq_quotation['quotation_cost'],2).'
*Link* : '.BASE_URL.'model/package_tour/quotation/group_tour/quotation_email_template.php?quotation='.$quotation_no.'
Please contact for more details : '.$contact.'
Thank you.');
		$all_message .=$whatsapp_msg;
		$link = 'https://web.whatsapp.com/send?phone='.$mobile_no['landline_no'].'&text='.$all_message;
		echo $link;
	}
}
?>