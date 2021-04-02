<?php
include_once('../model.php');
// date('d-m-Y', strtotime('+4 months'));
global $app_email_id, $secret_key,$encrypt_decrypt;

$cur_date = date('Y-m-d');
$month = date('m');
$day = date('d');

if($day == 19 && ($month == "January" || $month == "April"  || $month == "July"  || $month == "October" )){

    $sq_count = mysql_num_rows(mysql_query("SELECT * from  remainder_status where remainder_name = 'hotel_tarrif_remainder' and date='$cur_date' and status='Done'"));
            if($sq_count==0)
            {

                $query = "select * from hotel_master where active_flag!='Inactive'";
                $sq_query = mysql_query($query);
                    while($row = mysql_fetch_assoc($sq_query))
                    {
                        $username = $row['hotel_name'];
                        $passord = $row['mobile_no'];
                        $passord = $encrypt_decrypt->fnDecrypt($row['mobile_no'], $secret_key);
                        $email_id = $encrypt_decrypt->fnDecrypt($row['email_id'], $secret_key); 

                        send_request($username,$passord,$email_id);
                    }
            }

}

$row=mysql_query("SELECT max(id) as max from remainder_status");
$value=mysql_fetch_assoc($row);
$max=$value['max']+1;
$sq_check_status=mysql_query("INSERT INTO `remainder_status`(`id`, `remainder_name`, `date`, `status`) VALUES ('$max','hotel_tarrif_remainder','$cur_date','Done')");

function send_request($username,$passord,$email_id)
{
$email_content = '
        <table style="padding:0 30px">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                Dear '. $username.',<br>
                                <p style="line-height: 24px;">You are the valuable B2B supplier of our services.</p> 
                            </td>   
                        </tr>  
                        <tr>
                            <td>     
                
                               <p style="line-height: 24px;">Herewith, request you to add your pricing details for further bookings.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <p style="line-height: 24px;">Link  :  <span><a href="'.BASE_URL.'/view/vendor_login/" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">Login</a></span> <p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <p style="line-height: 24px;">Username  : <span>'.$username.'</span> </p>
                            </td>
                        </tr>    
                        <tr>
                            <td>
                              <p style="line-height: 24px;">Password  : <span>'.$passord.'</span> </p>
                            </td>
                        </tr>
                                  
                    </table>
                </td>
            </tr>
        </table>    
        ';

        global $model;
        $model->app_email_master($email_id, $email_content, 'Pricing Request','1');
}




?>
