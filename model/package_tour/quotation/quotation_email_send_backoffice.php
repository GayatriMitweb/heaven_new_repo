<?php 
class quotation_email_send_backoffice{


public function quotation_email_backoffice()
{
	$quotation_id = $_POST['quotation_id'];
	$quotation_no = base64_encode($quotation_id);
	$email_id = $_POST['email_id'];

	$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
	$date = $sq_quotation['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
	$sq_cost =  mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_costing_entries where quotation_id = '$quotation_id'"));


	$basic_cost = $sq_cost['basic_amount'];
	$service_charge = $sq_cost['service_charge'];
	$tour_cost= $basic_cost +$service_charge;
		$service_tax_amount = 0;
		$tax_show = '';
		$bsmValues = json_decode($sq_cost['bsmValues']);
		// var_dump($bsmValues);
	if($sq_cost['service_tax_subtotal'] !== 0.00 && ($sq_cost['service_tax_subtotal']) !== ''){
	  $service_tax_subtotal1 = explode(',',$sq_cost['service_tax_subtotal']);
	  for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		$name .= $service_tax[0] . ' ';
		$percent = $service_tax[1];
	  }
	}
	if($bsmValues[0]->service != ''){   //inclusive service charge
	  $newBasic = $tour_cost + $service_tax_amount;
	  $tax_show = '';
	}
	else{
	  // $tax_show = $service_tax_amount;
	  $tax_show =  $name . $percent. ($service_tax_amount);
	  $newBasic = $tour_cost;
	}

	////////////Basic Amount Rules
	if($bsmValues[0]->basic != ''){ //inclusive markup
	  $newBasic = $tour_cost + $service_tax_amount;
	  $tax_show = '';
	}
	$quotation_cost = $basic_cost +$service_charge+ $service_tax_amount+ + $sq_quotation['train_cost'] + $sq_quotation['flight_cost'] + $sq_quotation['cruise_cost'] + $sq_quotation['visa_cost'] + $sq_quotation['guide_cost'] + $sq_quotation['misc_cost'];

	$sq_package_name = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id = '$sq_quotation[package_id]'"));

	$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
	$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

	if($sq_emp_info['first_name']==''){
		$emp_name = 'Admin';
	}
	else{
		$emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
	}

	global $app_name, $app_cancel_pdf,$theme_color,$currency_logo;
	global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

	$sq_package_program = mysql_fetch_assoc(mysql_query("select * from custom_package_master where package_id ='$sq_quotation[package_id]'"));

    if($app_cancel_pdf == ''){	$url =  BASE_URL.'view/package_booking/quotation/cancellaion_policy_msg.php'; }
	else{
		$url = explode('uploads', $app_cancel_pdf);
		$url = BASE_URL.'uploads'.$url[1];
	}	

	$content = '				
		<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
				<tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_package_program['package_name'].'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Tour Type</td>   <td style="text-align:left;border: 1px solid #888888;" >Package Tour</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Tour Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($sq_quotation['from_date'])).' to '.date('d-m-Y', strtotime($sq_quotation['to_date'])).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Selling Cost</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.number_format($quotation_cost,2).'</td></tr>
				<tr><td style="text-align:left;border: 1px solid #888888;">Converted By</td>   <td style="text-align:left;border: 1px solid #888888;">'.$emp_name.'</td></tr>
			</table>
		</tr>
		<tr>
			<td>
				<a style="font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width: 90px;text-align: center;margin:0px auto;margin-top:10px;" href="'.BASE_URL.'model/package_tour/quotation/quotation_email_template.php?quotation_id='.$quotation_no.'" >Booking Details</a>
			</td> 
			
		</tr>	  
	';
	$subject = 'Confirmed Quotation Details : ( Quotation ID : '.get_quotation_id($quotation_id,$year).', Name : '.$sq_quotation['customer_name'].' )';
    //$emp_id = $row['email_id'];
	global $model;
	$model->app_email_send('7','Team',$email_id, $content,$subject,'1');
	echo "Quotation sent successfully!";
	exit;
}
}
?>