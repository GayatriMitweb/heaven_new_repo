<?php 

class quotation_email_send_backoffice{





public function quotation_email_backoffice()
{

	$quotation_id = $_POST['quotation_id'];
	$quotation_no = base64_encode($quotation_id);

	$email_id = $_POST['email_id'];

	$sq_quotation = mysql_fetch_assoc(mysql_query("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));

	$quotation_date = $sq_quotation['quotation_date'];
	$yr = explode("-", $quotation_date);
	$year =$yr[0];

	$sq_inclusion = mysql_fetch_assoc(mysql_query("select * from inclusions_exclusions_master where type='Inclusion'"));
	$sq_exclusion = mysql_fetch_assoc(mysql_query("select * from inclusions_exclusions_master where type='Exclusion'"));	

	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
	$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));



	if($sq_emp_info['first_name']==''){

		$emp_name = 'Admin';

	}

	else{

		$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];

	}



	global $app_name, $app_cancel_pdf,$currency_logo,$theme_color;



	$url = explode('uploads', $app_cancel_pdf);

	$url = BASE_URL.'uploads'.$url[1];	



	$content = '				
	<tr>
		<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_quotation['tour_name'].'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Tour Type</td>   <td style="text-align:left;border: 1px solid #888888;" >Group Tour</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' To '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Selling Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($sq_quotation['quotation_cost'],2).'</td></tr>
			<tr><td style="text-align:left;border: 1px solid #888888;">Converted By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
		</table>
	</tr>
	<tr>
		<table style="width:100%">
				<tr>
					<td>
						

						<a style="font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width: 90px;text-align: center;margin:0px auto;margin-top:10px;" href="'.BASE_URL.'model/package_tour/quotation/group_tour/quotation_email_template.php?quotation='.$quotation_no.'&to=user" >Booking Details</a>
					</td> 
				</tr>
			</table>
	</tr>	  
';
	

	$subject = "Confirmed Quotation"."(".get_quotation_id($quotation_id,$year).", Name : ".$sq_quotation['customer_name'].")";

	global $model;

	// $model->app_email_master($email_id, $content, $subject);
	$model->app_email_send('7','Team',$email_id, $content,$subject,'1');
	echo "Quotation sent successfully!";

	exit;

	

}



}

?>