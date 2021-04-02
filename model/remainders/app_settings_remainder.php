<?php
include_once('../model.php');
 
    global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
   
    $financial_year = mysql_fetch_assoc(mysql_query("select * from financial_year"));
    $from_date = $financial_year['from_date'];
    
    $sq_app= mysql_fetch_assoc(mysql_query("select * from app_settings"));
    $app_version = $sq_app['app_version'];
    $app_contact_no = $sq_app['app_contact_no'];
    $app_name = $sq_app['app_name'];
    $bank_acc_no = $sq_app['bank_acc_no'];
    $bank_name = $sq_app['bank_name'];
    
    if($app_version == "" || $from_date == "" || $app_contact_no == "" || $app_name == "" || $bank_acc_no == "" || $bank_name == "") {
        email_send($app_name);
       
    }

function email_send($app_name)
    {
        $email_content = '';
        $subject = 'App Settings Reminder';
        global $model;
        $model->app_email_send('67',"Admin",$app_email_id, $email_content,$subject,'1');
  
 }

?>