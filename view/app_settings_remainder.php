<?php
include_once('../model.php');

function app_settings_remainder()
{
    global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;
   
    $financial_year = mysql_fetch_assoc(mysql_query("select * from financial_year"));
    $year_name_long = $financial_year['year_name_long'];
    
    $sq_app= mysql_fetch_assoc(mysql_query("select * from app_settings"));
    $app_version = $sq_app['app_version'];
    $app_contact_no = $sq_app['app_contact_no'];
    $app_name = $sq_app['app_name'];
    $bank_acc_no = $sq_app['bank_acc_no'];
    $bank_name = $sq_app['bank_name'];
    $app_smtp_host = $sq_app['app_smtp_host'];
    $app_smtp_status = $sq_app['app_smtp_status'];
    $app_smtp_port = $sq_app['app_smtp_port'];
    $app_smtp_password = $sq_app['app_smtp_password'];
    $app_smtp_method = $sq_app['app_smtp_method'];

    if($year_name_long==""||$app_version==""||$app_contact_no==""||$app_name==""||$bank_acc_no==""||$bank_name==""||$app_smtp_host==""||$app_smtp_status==""||$app_smtp_port==""||$app_smtp_password==""||$app_smtp_method==""){

        $email_content = '
        <table style="padding:0 30px">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <p>Hello '.$app_name.',</p>
                                <p>This mail is inform you that please fill up the all information in app_settings. And Finincial year in accounting master->FINANCIAL YEAR MASTER.</p>      
                                <p>
                                    Thank You.
                                </p>
                                <p>
                                    Kind Regards,<br>
                                    <span style="color:'.$mail_color.'">'.$app_name.'</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <img src="'.BASE_URL.'/images/email/vacation.png" style="width:175px; height:auto; margin-bottom: -10px;" alt="">
                </td>
            </tr>
        </table>    
        ';

        global $model;
        $model->app_email_master($app_email_id, $email_content, 'App Settings Reminder');
    }
}

?>