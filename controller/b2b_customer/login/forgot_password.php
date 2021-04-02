<?php include "../../../model/model.php";
$username=mysql_real_escape_string($_POST['user_name']);
$agent_code=mysql_real_escape_string($_POST['agent_code']);

global $app_website,$encrypt_decrypt,$secret_key,$theme_color;
$username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
$row_count=mysql_num_rows(mysql_query("select * from b2b_registration where username='$username' and active_flag!='Inactive' and approval_status='Approved' and agent_code='$agent_code'"));
if($row_count>0){
    $sq_query=mysql_fetch_assoc(mysql_query("select * from b2b_registration where username='$username' and active_flag!='Inactive' and approval_status='Approved' and agent_code='$agent_code'"));
    $email = base64_encode($sq_query['email_id']);
    $username = base64_encode($username);
    $agent_code = base64_encode($agent_code);
    $content = '             
    <tr>
    <td>
    <table style="width:100%">
        <tr>
            <td colspan="2">
                <p style="color:#888888;font-family:Calibri,sans-serif">As requested, here is a link to allow you to set new password</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;font-family:Calibri,sans-serif">
                <a style="margin:10px auto;font-weight:500;font-size:12px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width: 95px;text-align: center;" href="'.BASE_URL.'view/b2b_customer/registration/reset_password.php?username='.$username.'&agent_code='.$agent_code.'&email='.$email.'">Reset Password</a> 
            </td> 
        </tr>
        <tr>
            <td colspan="2">
                <p style="color:#888888;font-family:Calibri,sans-serif">If you need further assistance, please <a style="color:'.$theme_color.'"href="'.$app_website.'">contact us</a> </p>
            </td>
        </tr>
    </table>
    </td>
</tr>               
                        
   ';

if($sq_query['mobile_no'] != ''){
    $message = 'Dear Travel Partners,'. 
'Request you to fill the attached registration form. And will get back to you with your credentials soon. Use this link :- '.BASE_URL.'model/attractions_offers_enquiry/tour_enquiry.php';
    $model->send_message($sq_query['mobile_no'], $message);
}

    $subject = "B2B Portal Password Reset!";
    $model->app_email_master($sq_query['email_id'], $content, $subject, '1');

    echo "You will receive instructions for resetting your password at your registered email-id";
}
else{
	echo "Invalid Login Credentials!";
}
?>