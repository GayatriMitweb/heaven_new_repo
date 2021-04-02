<?php
class test{

///////////////////////***Enquiry Master Save start*********//////////////
function send()
{

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
  $email_id = $_POST['email_id'];
  $mobile_no = $_POST['mobile_no'];
  
  $content = '
                  <tr>
                        <td>Hello ,Email is Working fine.</td>
                  </tr>

  ';

  global $model;
  $message = "SMS is working fine..";
 
  $model->send_message($mobile_no, $message);

  $subject = "Email sms Test";
  $model->app_email_master($email_id, $content, $subject,'1');
  
 

  echo "Sent succesfully!";
}
}
?>