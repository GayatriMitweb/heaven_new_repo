<?php 
include_once('../../../model.php');

$quotation_id = $_POST['quotation_id'];
$suggestion = $_POST['suggestion'];
$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));

$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$email_id = $app_email_id;
}
else{
	$email_id = $sq_emp_info['email_id'];
}
global $app_name;
global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;


$content = '
			<table style="padding:0 30px; width:100%">	
				<tr>
					<td>
						<p>Customer Name : <strong>'.$sq_quotation['customer_name'].'</strong></p>
						<p>Quotation ID : <strong>PTQ-'.$quotation_id.'</strong></p>
						<p>Email ID : <strong>'.$sq_quotation['email_id'].'</strong></p>
						<p>Suggestion: <strong>'.$suggestion.'</strong></p>
					</td>
				</tr>				
			</table>
			
';

$subject = "Suggestion from customer ".$sq_quotation['customer_name'];
$model->app_email_master($email_id, $content, $subject);
echo "Thank you for your suggestion";
?>