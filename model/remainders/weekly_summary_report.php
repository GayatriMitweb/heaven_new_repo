<?php
include_once('../model.php');
 
    global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;
    global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$theme_color;

    $cur_date = date('Y-m-d');
    $day = date("D", strtotime($cur_date));

    if($day=='Sat'){        

            $email_content = '
                <tr>
                    <td>
                        <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                            <tr>
                            <td colspan="2">
                                
                                <a style="background: '.$theme_color.';color: #fff; border:aliceblue;width:auto;text-decoration: none;  display: block;text-transform: uppercase;padding: 0 10px;font-weight: 600;" href="'.BASE_URL.'model/remainders/weekly_summary_html.php">Click here to view Weekly summary report</a> 
                            </td>
                            </tr>
                        </table>
                     </td>
                </tr>
                    
        ';

            global $model;
            $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'week_sum_remainder' and date='$cur_date' and status='Done'"));
            if($sq_count==0)
            {
            $subject = 'Weekly Summary report (Date : '.$cur_date.' ).';
            $model->app_email_send('93',"Admin",$app_email_id, $email_content,$subject);

            $row=mysql_query("SELECT max(id) as max from remainder_status");
            $value=mysql_fetch_assoc($row);
            $max=$value['max']+1;
            $sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','week_sum_remainder','$cur_date','Done')");
           }   
                 
  }
?>