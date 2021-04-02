<?php

include_once('../../../model.php');
$quotation_id = $_GET['quotation_id'];
$quotation_id = base64_decode($quotation_id);
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));

$date = $sq_quotation['created_at'];
$yr = explode("-", $date);
$year =$yr[0];

$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));


if($sq_emp_info['first_name']==''){

	$email_id = $app_email_id;
	$name = 'Admin';
}
else{
	$email_id = $sq_emp_info['email_id'];
	$name = $sq_emp_info['first_name'];
}

global $app_name;
global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

$date = date('d-m-Y H:i:s');

$content = '	
			<tr>
			<table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
			<tr><td style="text-align:left;border: 1px solid #888888;">Quotation ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$quotation_id.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Customer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['customer_name'].'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_quotation['email_id'].'</td></tr>
			  <tr><td style="text-align:left;border: 1px solid #888888;">Date/Time of review</td>   <td style="text-align:left;border: 1px solid #888888;">'.$date.'</td></tr>
            </table>
          </tr>		

';

$subject = 'New Customer is Interested for Tour! ('.get_quotation_id($quotation_id,$year).' , '.$sq_quotation['customer_name'].' )';

$model->app_email_send('11',$name,$email_id, $content,$subject);
echo "Thanks for showing interest go back to see your quotation again...";
?>
<script>
setTimeout(function () {
	window.history.back();
},10000);
</script>