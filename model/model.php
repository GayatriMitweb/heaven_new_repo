<?php
/*$seperator = strstr(strtoupper(substr(PHP_OS, 0, 3)), "WIN") ? "\\" : "/";
session_save_path('..'.$seperator.'xml'.$seperator.'session_dir');
ini_set('session.gc_maxlifetime', 6); // 3 hours
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_secure', FALSE);
ini_set('session.use_only_cookies', TRUE);*/
ini_set("session.gc_maxlifetime", 3*60*60);
ini_set('session.gc_maxlifetime', 3*60*60);
session_start();

date_default_timezone_set('Asia/Kolkata');

set_error_handler("myErrorHandler");
function myErrorHandler($errno, $errstr, $errfile, $errline){
   // echo  "<br><br>".$errno."<br>".$errstr."<br>".$errfile."<br>".$errline;
}
$localIP = getHostByName(getHostName());

$connection=mysql_connect("localhost","root","");
if(!$connection){ echo "Unable To make Connection."; }

$db_connect=mysql_select_db("heaven_new");
if(!$db_connect) { echo "Database Not Connected."; }

define('BASE_URL', 'http://localhost/tours/heaven-new/');

mysql_query("SET SESSION sql_mode = ''");
$b2b_index_url = BASE_URL.'Tours_B2B/view/index.php';

global $secret_key;
$secret_key = "secret_key_for_iTours";

$admin_logo_url = BASE_URL.'images/Admin-Area-Logo.png';
$circle_logo_url = BASE_URL.'images/logo-circle.png';
$report_logo_small_url = BASE_URL.'images/Receips-Logo-Small.jpg';
$terms_conditions_url = BASE_URL.'images/terms-condition.jpg';
$hotel_service_voucher = BASE_URL.'images/hotel_service_voucher.jpg';
$transport_service_voucher = BASE_URL.'images/transport_service_voucher.jpg';
$transport_service_voucher2 = BASE_URL.'images/transport_service_voucher2.jpg';
$booking_form = BASE_URL.'images/Booking-Form-new.jpg';
$b2b_pdf_image = BASE_URL.'images/b2b_pdf_image.jpg';
$sidebar_strip = BASE_URL.'images/sidebar-strip.jpg';
$voucher_id_proof = BASE_URL.'images/voucher_id_proof.jpg';
$quotation_icon = BASE_URL.'images/quotation-icon.png';

//Sale and Purchase transaction feild detail's Note 
$txn_feild_note="Please make sure Date, Amount, Mode, Creditor bank entered properly.";

//Cancel feild note
$cancel_feild_note = "Note : Kindly take new booking who will travel from partially cancellation.";

//simliar hotel and transports
$similar_text = ' / Similar';

//Quot_note
$quot_note = 'Note : This is only a quotation. No booking is made yet. The costing may differ as per availability.';

//**********App Settings Global Variables start**************//

$sq_app_tax = mysql_fetch_assoc(mysql_query("select * from generic_count_master where id='1'"));
$setup_country_id = $sq_app_tax['setup_country_id'];
$app_invoice_format = $sq_app_tax['invoice_format'];
$setup_package = $sq_app_tax['setup_type'];
$session_emp_id = $_SESSION['emp_id'];

$sq_app_setting_count = mysql_num_rows(mysql_query("select * from app_settings"));
if($sq_app_setting_count==1){
  $sq_app_setting = mysql_fetch_assoc(mysql_query("select * from app_settings"));
  $app_version = $sq_app_setting['app_version'];
  $currency = $sq_app_setting['currency'];
  $app_contact_no = $sq_app_setting['app_contact_no'];
  $app_landline_no = $sq_app_setting['app_landline_no'];
  $service_tax_no = strtoupper($sq_app_setting['service_tax_no']);
  $app_address = $sq_app_setting['app_address'];
  $app_website = $sq_app_setting['app_website'];
  $app_name = $sq_app_setting['app_name'];
  $bank_acc_no = $sq_app_setting['bank_acc_no'];
  $cin_no = $sq_app_setting['app_cin'];
  $bank_name_setting = $sq_app_setting['bank_name'];
  $acc_name = $sq_app_setting['acc_name'];
  $bank_branch_name = $sq_app_setting['bank_branch_name'];
  $bank_ifsc_code = $sq_app_setting['bank_ifsc_code'];
  $bank_swift_code = $sq_app_setting['bank_swift_code'];
  $sms_username = $sq_app_setting['sms_username'];
  $sms_password = $sq_app_setting['sms_password'];
  $accountant_email = $sq_app_setting['accountant_email'];
  $tax_type = $sq_app_setting['tax_type'];
  $tax_pay_date = $sq_app_setting['tax_pay_date'];
  $b2c_flag = $sq_app_setting['b2c_flag'];
  $tax_name = $sq_app_setting['tax_name'];

  $app_email_id = $sq_app_setting['app_email_id'];
  if($session_emp_id == 0){
    $app_email_id_send = $sq_app_setting['app_email_id'];
    $app_user_name_send = "Admin";
    $app_smtp_status = $sq_app_setting['app_smtp_status'];
    $app_smtp_host = $sq_app_setting['app_smtp_host'];
    $app_smtp_port = $sq_app_setting['app_smtp_port'];
    $app_smtp_password = $sq_app_setting['app_smtp_password'];
    $app_smtp_method = $sq_app_setting['app_smtp_method'];
    $app_send_contact_no = $sq_app_setting['app_contact_no'];
  }
  else{
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$session_emp_id'"));
    $app_email_id_send = $sq_emp['email_id'];
    $app_user_name_send = $sq_emp['first_name'];
    $app_smtp_status = $sq_emp['app_smtp_status'];
    $app_smtp_host = $sq_emp['app_smtp_host'];
    $app_smtp_port = $sq_emp['app_smtp_port'];
    $app_smtp_password = $sq_emp['app_smtp_password'];
    $app_smtp_method = $sq_emp['app_smtp_method'];
    $app_send_contact_no = $sq_app_setting['mobile_no'];
  }
  $app_cancel_pdf = $sq_app_setting['policy_url'];
  $app_credit_charge = $sq_app_setting['credit_card_charges'];
  $_SESSION['unique_receipt_id']= $app_version."/";
  $app_quot_format = $sq_app_setting['quot_format'];
  $app_quot_img = $sq_app_setting['quot_img_url'];
}
else{
  $app_version = $app_email_id = $app_email_id_send = $app_user_name_send = $currency = $app_contact_no = $service_tax_no = $app_address = $app_website = $app_name = $bank_acc_no = $bank_name_setting = $bank_branch_name = $bank_ifsc_code = $bank_swift_code = $app_smtp_status = $app_smtp_host = $app_smtp_port = $app_smtp_password = $app_smtp_method = $app_terms_condition = $cin_no = $app_landline_no = $acc_name = $accountant_email=$app_credit_charge=$app_quot_format=$app_send_contact_no=$app_quot_img=$b2c_flag=$tax_name="";
}


//**********Theme color scheme variables**************//
$sq_count = mysql_num_rows( mysql_query("select * from app_color_scheme") );
if($sq_count==1){
  $sq_scheme = mysql_fetch_assoc(mysql_query("select * from app_color_scheme"));
  $theme_color = $sq_scheme['theme_color'];
  $theme_color_dark = $sq_scheme['theme_color_dark'];
  $theme_color_2 = $sq_scheme['theme_color_2'];
  $topbar_color = $sq_scheme['topbar_color'];
  $sidebar_color = $sq_scheme['sidebar_color'];
}else{
  $theme_color = "#009898";
  $theme_color_dark = "#239ede";
  $theme_color_2 = "#1d4372";
  $topbar_color = "#ffffff";
  $sidebar_color = "#36aae7"; 
}
//***********Whatsapp Switch***************/
global $whatsapp_switch;
$whatsapp_switch = "off"; // 'off' for switch off and 'on' for switch on

//**Currency Symbol Display******
global $currency_logo,$currency_code;
$currency_logo_d = mysql_fetch_assoc(mysql_query("SELECT `default_currency`,`currency_code` FROM `currency_name_master` WHERE id=".$currency));
$currency_code = $currency_logo_d['currency_code'];
$currency_logo = html_entity_decode($currency_logo_d['default_currency']);
//**********Mailer gloabal Variables**************//
global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;
$mail_color = "#2fa6df";
$mail_em_style = "border-bottom: 1px dotted #1f1f1f; padding-bottom: 4px; margin-bottom: 4px; display: inline-block; font-style:normal; color:#2fa6df;";
$mail_em_style1 = "font-style:normal; color:#2fa6df";
$mail_font_family = "font-family: 'Raleway', sans-serif;";
$mail_strong_style = "font-weight: 500; color:#000";

include_once "app_settings/generic_email_hf.php";

class model extends email_hf{ // extending email file
  public function generic_payment_mail($cms_id,$payment_amount, $payment_mode, $total_amount, $paid_amount, $payment_date, $due_date,$to,$subject, $fname)
  {
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$currency_logo;
    if($payment_amount != '0' && $payment_amount != ''){
    $balance_amount = $total_amount - $paid_amount;
    $total_amount= number_format($total_amount,2);
    $balance_amount= number_format($balance_amount,2);
    $paid_amount = number_format($paid_amount,2);

    $due_date_html = '';
    if((double)$balance_amount > 0.0 && $due_date != ''){
      $due_date_html = '<tr><td style="text-align:left;border: 1px solid #888888;"> Due Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.get_date_user($due_date).'</td></tr>';
    }
    $content = '
          <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '.$total_amount.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Paid Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.$paid_amount.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '. $balance_amount.'</td></tr>
              '.$due_date_html.'
            </table>
          </tr>
    ';
    $this->app_email_send($cms_id,$fname,$to, $content,$subject);
  }
 }

 public function generic_payment_remainder_mail($cms_id,$fname,$balance_amount, $tour_name, $booking_id, $customer_id, $to, $acc_status='',$total_amount,$due_date  ){
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
    echo "Total_amount".$total_amount.' due date'.$due_date;
    $content = '
    <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Tour Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$tour_name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Booking ID</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$booking_id.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '. $total_amount.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Due Date</td>   <td style="text-align:left;border: 1px solid #888888;">'. $due_date.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Balance Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.$currency_logo.' '. $balance_amount.'</td></tr>
            </table>
          </tr>';
    $content;
    if($acc_status!=''){
      $this->app_email_send($cms_id,$fname,$to, $content,$subject);
    }
    else{
      $this->app_email_send($cms_id,$fname,$to, $content,$subject,'1');
    }
  }

  public function topup_remainder_mail($balance_amount, $supplier_name )
  {
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$app_contact_no;
   
    $content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Airline Name </td>   <td style="text-align:left;border: 1px solid #888888;">'.$supplier_name.'</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;"> Current low balance</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.$balance_amount.'</td></tr>
            </table>
          </tr>';
    
    $message = "Hello Admin, Your airline balance became low. Please transfer the payment and upgrade the balance.Airline Name : ".$supplier_name." Current low balance : ".$balance_amount;
  
    $this->app_email_send('75',$app_user_name_send,$app_email_id_send, $content);
    $this->send_message($app_contact_no, $message);      
  }

  public function visa_topup_remainder_mail($balance_amount, $supplier_name )
  {
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$app_contact_no,$app_email_id_send,$app_user_name_send;

    $content = '   <tr>
    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
        <tr><td style="text-align:left;border: 1px solid #888888;">Visa Supplier Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$supplier_name.'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;">Current low balance</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.$balance_amount.'</td></tr>
    </table>
    </tr>';
    $content;
    $message = "Hello Admin, Your visa balance became low. Please transfer the payment and upgrade the balance.Visa Supplier Name : ".$supplier_name." Current low balance : ".$balance_amount;
  
    $this->app_email_send('76',$app_user_name_send,$app_email_id_send, $content);
    $this->send_message($app_contact_no, $message);      
  }
  public function while_topup_mail_send($amount, $supplier_name,$for)
  {
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$app_contact_no,$app_email_id_send,$app_user_name_send;
    if($for=='visa'){
      
     
      $content = '   <tr>
      <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
          <tr><td style="text-align:left;border: 1px solid #888888;">Supplier Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$supplier_name.'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' ' .$amount.'</td></tr>
      </table>
      </tr>';
    $content;
    $this->app_email_send('66',$app_user_name_send,$app_email_id_send, $content);  
    }
    else{
   
      $content = '   <tr>
      <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
          <tr><td style="text-align:left;border: 1px solid #888888;">Supplier Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$supplier_name.'</td></tr>
          <tr><td style="text-align:left;border: 1px solid #888888;">Amount</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$currency_logo.' '.$amount.'</td></tr>
      </table>
      </tr>';
         



    $content;
    $this->app_email_send('65',$app_user_name_send,$app_email_id_send, $content);    
  }
}

  public function app_email_master($to, $content, $subject, $acc_status='')
  {
    global $app_email_id_send, $app_user_name_send, $app_name, $app_contact_no, $admin_logo_url, $app_website, $app_smtp_status, $app_smtp_host, $app_smtp_port, $app_smtp_password, $app_smtp_method,$emp_email_id,$emp_id,$accountant_email;
    if(empty($to)) return; // exit the function if no email is provided
    /*
    if($from_mail == ""){
       $from_mail = $app_email_id_send;
    }    */
    $session_emp_id = $_SESSION['emp_id'];
    $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$session_emp_id'"));

    $body = parent :: mail_header();
    $body .= $content;
    $body .= parent :: mail_footer();

    include_once dirname(dirname(__FILE__)).'/classes/PHPMailer_5.2.4/class.phpmailer.php';
    $mail= new PHPMailer;
    $mail->IsSMTP();
    if($app_smtp_status=="Yes"){
      $mail->Host = $app_smtp_host;
      $mail->Port = $app_smtp_port;
      $mail->SMTPAuth = true;
      $mail->SMTPDebug = 0;
      $mail->Username = $app_email_id_send;
      $mail->Password = $app_smtp_password;
      $mail->SMTPSecure = $app_smtp_method;
    }
    
    $mail->AddReplyTo($app_email_id_send,$app_name);
    $mail->SetFrom($app_email_id_send, $app_name);
    $mail->AddReplyTo($app_email_id_send,$app_name);
    $mail->AddAddress($to);
    $mail->AddCC($app_email_id_send, $app_name);

    //keep accountant in accountant
    if($acc_status == ''){
      $mail->AddCC($accountant_email, $app_name);
    }
    $mail->Subject    = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      //echo "Mail sent!";
    }  
  }
  ///////////////////////////// New Mail(CMS) Draft///////////////////////////////////////////////
  public function app_email_send($email_for,$fname,$to, $temp_content, $subject, $acc_status='')
  {
    global $app_email_id_send, $app_user_name_send,$app_name, $app_contact_no, $admin_logo_url, $app_website, $app_smtp_status, $app_smtp_host, $app_smtp_port, $app_smtp_password, $app_smtp_method,$emp_email_id,$emp_id,$accountant_email;

    if(empty($to)) return; // exit the function if no email is provided
    $sq_cms = mysql_fetch_assoc(mysql_query("select * from cms_master_entries where entry_id='$email_for'"));
    //if(!(($email_for>=7 && $email_for<=9) || ($email_for>=23 && $email_for<=24))) //skipping quotation subjects
     
    if($sq_cms['active_flag'] != 'Inactive'){
      $content = $sq_cms['draft'];
      $content .= $temp_content;
      $content .= $sq_cms['signature'];
      $content = str_replace('{name}',ucfirst($fname),$content);

      $body = parent :: mail_header();
      $body .= $content;
      $body .= parent :: mail_footer();
      
      include_once dirname(dirname(__FILE__)).'/classes/PHPMailer_5.2.4/class.phpmailer.php';
      include_once dirname(dirname(__FILE__)).'/classes/PHPMailer_5.2.4/class.smtp.php';
      $mail= new PHPMailer;
      $mail->IsSMTP();
      if($app_smtp_status=="Yes"){
        $mail->Host = $app_smtp_host;
        $mail->Port = $app_smtp_port;
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Username = $app_email_id_send;
        $mail->Password = $app_smtp_password;
        $mail->SMTPSecure = $app_smtp_method;
      }
      $mail->addReplyTo($app_email_id_send,$app_name);
      $mail->setFrom($app_email_id_send,$app_name);
      $mail->addReplyTo($app_email_id_send,$app_name);
      $mail->addAddress($to);
      
      //keep accountant in cc
      if($acc_status == '' && !empty($accountant_email) ){
        $mail->AddCC($accountant_email, $app_name);
      }
      if($subject == ''){
        $subject = $sq_cms['subject'];
      }
      $mail->Subject  = $subject;
      $mail->AltBody  = "To view the message, please use an HTML compatible email viewer!";
      $mail->MsgHTML($body);
      
      if(!$mail->Send()){
        //echo "Mailer Error: ". $mail->ErrorInfo;
        echo 'Please enter valid email credentials!';
      } 
      else{
        //echo "Mail sent!";
      } 
    }
  }

  public function app_template_email_master($to, $content, $subject)
  {
    global $app_email_id_send, $app_name, $app_contact_no, $admin_logo_url, $app_website, $app_smtp_status, $app_smtp_host, $app_smtp_port, $app_smtp_password, $app_smtp_method,$emp_email_id;
    
    $body .= $content;

    include_once dirname(dirname(__FILE__)).'/classes/PHPMailer_5.2.4/class.phpmailer.php';
    $mail= new PHPMailer();
    $mail->IsSMTP();
    if($app_smtp_status=="Yes"){
      $mail->Host = $app_smtp_host;             
      $mail->Port = $app_smtp_port;                               
      $mail->SMTPAuth = true;
      $mail->SMTPDebug = 0;                               
      $mail->Username = $app_email_id_send;               
      $mail->Password = $app_smtp_password;                
      $mail->SMTPSecure = $app_smtp_method;                    
    }
    
    $mail->AddReplyTo($app_email_id_send,$app_name);
    $mail->SetFrom($app_email_id_send,$app_name);
    $mail->AddReplyTo($app_email_id_send,$app_name);
    $mail->AddAddress($to,"");
    $mail->AddCC($app_email_id_send, $app_name);
    //$mail->AddCC($sq_emp['email_id'], $app_name);
    
    $mail->Subject = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    if(!$mail->Send()) {
      //echo "Please enter valid email credentials!";
    } else {
      //echo "Mail sent!";
    }  
  }
//=======================Send Mail with attachment===========================//
public function new_app_email_send($email_for,$to,$subject,$arrayAttachment, $temp_content, $acc_status=''){
      global $app_email_id_send, $app_name , $app_smtp_status, $app_smtp_host, $app_smtp_port, $app_smtp_password, $app_smtp_method,$emp_id,$accountant_email;
  
      include_once dirname(dirname(__FILE__)).'/classes/PHPMailer_5.2.4/class.phpmailer.php';
      $session_emp_id = $_SESSION['emp_id'];
      $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$session_emp_id'"));
      $content .= $temp_content;
  
      $body = parent :: mail_header();
      $body .= $content;
      $body .= parent :: mail_footer();

      $mail= new PHPMailer;
      $mail->IsSMTP();
      if($app_smtp_status=="Yes"){
        $mail->Host = $app_smtp_host;
        $mail->Port = $app_smtp_port;
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Username = $app_email_id_send;
        $mail->Password = $app_smtp_password;
        $mail->SMTPSecure = $app_smtp_method;
      }
      $mail->AddReplyTo($app_email_id_send,$app_name);
      $mail->SetFrom($app_email_id_send, $app_name);
      $mail->AddReplyTo($app_email_id_send,$app_name);
      $mail->AddAddress($to, "");
      $mail->AddCC($app_email_id_send, $app_name);

      foreach($arrayAttachment as $attachment)
      {
        $dir = dirname(dirname(__FILE__));
        $att_url =  str_replace("'/'","'\'",$dir);
        $mail->AddAttachment($att_url.'/'.$attachment);
      } 
      //keep accountant in cc
      if($acc_status == '' && !empty($accountant_email)){
        $mail->AddCC($accountant_email, $app_name);
      }
      $mail->AddCC($sq_emp['email_id'], $app_name);
      if(!empty($subject)){
        $mail->Subject = $subject;
      }
      else{
        $mail->Subject = $sq_cms['subject'];
      }
      $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
      $mail->MsgHTML($body);
      $mail->IsHTML(true);
      if(!$mail->Send()) {
       // echo "Please enter valid email credentials!";
      }else{
        unlink($arrayAttachment[0]);
      }
}

  //=======================Send Mobile message Message start===========================//
  public function send_message($mobile_no, $message)
  {
    global $sms_username, $sms_password;
    $username = urlencode($sms_username);
    $sender_id = 'ITOURS';
    $sms_password = urlencode($sms_password); // optional (compulsory in transactional sms) 
    $message = urlencode($message); 
    $mobile = urlencode($mobile_no); 

    // $api = "http://smsjust.com/sms/user/urlsms.php?username=$username&pass=$sms_password&senderid=$sender_id&message=$message&dest_mobileno=$mobile&response=Y"; 
    // $response = file_get_contents($api,FALSE);

    
    $api ="http://tarangsms.reliableindya.info/sendsms.jsp?user=$username&password=4d47926921XX&senderid=ITOURS&mobiles=$mobile&sms=$message";
    // echo $api;
    $response = file_get_contents($api,FALSE);
  }

  //Send Whatsapp messages  
  public function send_whatspp_message($mobile_no, $message)
  {
    $data = array();
    $data = [
    'phone' => $mobile_no, // Receivers phone
    'body' => $message, // Message
    ];
    $json = json_encode($data); // Encode data to JSON
    // URL for request POST /message
    $url = 'https://eu26.chat-api.com/instance17553/message?token=nrrtgd9v1ktsqid9';
    // Make a POST request
    $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]
    ]);
    // Send a request
    $result = file_get_contents($url, false, $options);
  }
}
global $model;
$model=new model();
//=======================App generic functions===========================//  
include_once('app_settings/app_generic_functions.php');
include_once('app_settings/get_ids.php');
include_once('app_settings/dropdown_master.php');
include_once('app_settings/particular_functions.php');
include_once('encrypt_decrypt.php');
include_once("get_cache_data.php");
?>
