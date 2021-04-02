<?php 
class quotation_email_send
{
	public function quotation_email(){

		$quotation_id_arr = $_POST['quotation_id_arr'];
		// $msg_status = $_POST['msg_status'];
		$i = 0;
		// $whatsapp_msg = '';

		global $app_name, $app_cancel_pdf,$model,$quot_note,$currency_logo,$theme_color;
		global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;	

		$url1 = "'.BASE_URL.'model/package_tour/quotation/quotation_email_template.php?quotation_id='.$quotation_id.'";


		if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }

		else{

			$url = explode('uploads', $app_cancel_pdf);

			$url = BASE_URL.'uploads'.$url[1];

		}



		$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[0]'"));

		$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[0]'"));

		$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));

		$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

		if($sq_emp_info['first_name']==''){

			$emp_name = 'Admin';

		}

		else{

			$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];

		}
		for($i=0;$i<sizeof($quotation_id_arr);$i++)
		{

		$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[$i]'"));
		$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[$i]'"));
	
		
		
		$quotation_cost = $sq_cost['total_tour_cost'] + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];
		
		$sq_tours_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));
		
		$quotation_no = base64_encode($quotation_id_arr[$i]);

		$content .= '   
		
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tours_package['package_name'].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Total Days</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_tours_package['total_days'].'D/'.$sq_tours_package['total_nights'].'N'.'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Price</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($quotation_cost,2).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;width:30%">View Quotation</td>   <td style="text-align:left;border: 1px solid #888888;width:30%"><a style="color: '.$theme_color.';text-decoration: none;" href="'.BASE_URL.'model/package_tour/quotation/single_quotation.php?quotation='.$quotation_no.'">View</a></td></tr>
			</table>
		</tr>	';
		}
		$content .= '
		<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' To '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;width:30%">Created By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
		</table>
	</tr>
		';
		$content .= '
		<tr>
			
				<table style="width:100%;margin-top:20px">
					<tr>
						<td style="padding-left: 10px;border-bottom: 1px solid #eee;"><span style="font-weight: 600; color: '.$theme_color.'">'.$quot_note.'</span></td>
					</tr>
				</table>	
			
		<tr>';

		$subject = 'New Quotation : ('.$sq_tours_package['package_name'].' )';
		$model->app_email_send('8',$sq_quotation['customer_name'],$sq_quotation['email_id'], $content,$subject,'1');

		echo "Quotation successfully sent.";

		exit;
	}
	public function quotation_whatsapp(){
		$quotation_id_arr = $_POST['quotation_id_arr'];
		$currency = "Rs.";
		global $app_name, $app_cancel_pdf,$model,$quot_note,$app_contact_no;
		
		$all_message = "";
		for($i=0;$i<sizeof($quotation_id_arr);$i++){
			$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id_arr[$i]'"));
			$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id_arr[$i]'"));
			$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
			$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));
			if($sq_login['emp_id'] == 0){
				$contact = $app_contact_no;
			}
			else{
				$contact = $sq_emp_info['mobile_no'];
			}
			$quotation_cost = $sq_cost['total_tour_cost'] + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];	

			$sq_tours_package = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));		

			$quotation_no = base64_encode($quotation_id_arr[$i]);
			$whatsapp_msg = 'Hello%20Dear%20'.rawurlencode($sq_quotation['customer_name']).',%0aHope%20you%20are%20doing%20great.%20This%20is%20Package%20tour%20quotation%20details%20as%20per%20your%20request.%20We%20look%20forward%20to%20having%20you%20onboard%20with%20us.%0a*Interested%20Tour*%20:%20'.rawurlencode($sq_tours_package['package_name']).'%0a*Duration*%20:%20'.rawurlencode($sq_tours_package['total_days']).'D/'.rawurlencode($sq_tours_package['total_nights']).'N%0a*Cost*%20:%20'.$currency.rawurlencode($quotation_cost).'%0a*Link*%20:%20'.BASE_URL.'/model/package_tour/quotation/single_quotation.php?quotation='.$quotation_no.'%0aPlease%20contact%20for%20more%20details%20:%20'.$contact.'%0aThank%20you.%0a';
			$all_message .=$whatsapp_msg;
		}
		$link = 'https://web.whatsapp.com/send?phone='.$sq_quotation['mobile_no'].'&text='.$all_message;
		echo $link;
	}
}
?>