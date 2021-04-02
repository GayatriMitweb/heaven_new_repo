<?php 
include_once('../../../model.php');
$quotation_id = $_GET['quotation_id'];

$quotation_id = base64_decode($quotation_id);

$sq_quotation = mysql_fetch_assoc(mysql_query("select * from package_tour_quotation_master where quotation_id='$quotation_id'"));
$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where id='$sq_quotation[login_id]'"));
$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

if($sq_emp_info['first_name']==''){
	$email_id = $app_email_id;
}
else{
	$email_id = $sq_emp_info['email_id'];
}
$date = date('d-m-Y H:i:s');
global $app_name;
global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

$content = '
			<table style="width:100%">	
				<tr>
					<td>
						<p>Customer viewed quotation but not further interested for tour.</p>
						<p>Customer Name :<strong>'.$sq_quotation['customer_name'].'</strong> </p>
						<p>Quotation ID : <strong>PTQ-'.$quotation_id.'</strong></p>
						<p>Date/Time of review :- <strong>'.$date.'</strong></p>
					</td>
				</tr>				
			</table>
			
';

$subject = "Customer Not Interested!";
$model->app_email_master($email_id, $content, $subject);
?>
<script>
setTimeout(function () {
	window.history.back();
},10000);
</script>