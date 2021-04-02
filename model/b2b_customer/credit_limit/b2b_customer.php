<?php
class b2b_customer{
    function customer_save(){

        $register_id = $_POST['register_id'];
        $payment_date = $_POST['payment_date'];
        $description = $_POST['description'];
        $credit_limit = $_POST['credit_limit'];
        $approve_status= $_POST['approve_status'];
        $payment_days = $_POST['payment_days'];

        $payment_date = get_date_db($payment_date);
        $sq_customer = mysql_fetch_assoc(mysql_query("select company_name ,email_id from b2b_registration where register_id='$register_id'"));

        
        $sq_max1 = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_creditlimit_master"));
        $entry_id = $sq_max1['max'] + 1;

        $sq_b2b = mysql_query("INSERT INTO `b2b_creditlimit_master`(`entry_id`, `register_id`, `credit_amount`,`payment_days`, `approval_status`, `description`, `created_at`, `mail_status`)values('$entry_id','$register_id','$credit_limit','$payment_days','$approve_status','$description','$payment_date','')");
        if($sq_b2b){
            if($approve_status == 'Approved'){
                //Send Acknowledgement Mails
                $this->approval_mail_Send($description,$sq_customer['email_id'],$sq_customer['company_name'],$credit_limit);
                //update mail status
                $sq_b2b1 = mysql_query("update b2b_creditlimit_master set mail_status='sent' where entry_id='$entry_id'");
                
            }
            if($approve_status == 'Rejected'){
                $this->rejection_mail_Send($description,$sq_customer['email_id'],$sq_customer['company_name']);
            }
            echo "Information has been successfully saved.";
            exit;
        }else{
            echo "error--Sorry Information not saved!";
            exit;
        }

    }
    function customer_update(){	
        $approval_id = $_POST['approval_id'];
        $register_id = $_POST['register_id'];
        $payment_date = $_POST['payment_date'];
        $entry_id = $_POST['entry_id'];
        $description = $_POST['description'];
        $credit_limit = $_POST['credit_limit'];
        $approve_status= $_POST['approve_status'];
        $payment_days = $_POST['payment_days'];
        $payment_date = get_date_db($payment_date);

        $sq_credit = mysql_fetch_assoc(mysql_query("select credit_amount from b2b_creditlimit_master where entry_id='$entry_id'"));

        $sq_b2b = mysql_query("UPDATE `b2b_creditlimit_master` SET `credit_amount`='$credit_limit',`approval_status`='$approve_status',`description`='$description',payment_days='$payment_days',created_at='$payment_date' WHERE entry_id='$entry_id'");
  
        if(!$sq_b2b){
            echo "error--Sorry Information not updated!";
            exit;
        } 
        else{    
            $sq_customer = mysql_fetch_assoc(mysql_query("select company_name ,email_id, cp_first_name from b2b_registration where register_id='$register_id'"));
            if($approve_status == 'Approved'  && $credit_limit!=$sq_credit['credit_amount']){
                //Send Acknowledgement Mails
                $this->approval_mail_Send($description,$sq_customer['email_id'],$sq_customer['company_name'],$credit_limit,$sq_customer['cp_first_name']);
                //update mail status
                $sq_b2b1 = mysql_query("update b2b_creditlimit_master set mail_status='sent' where entry_id='$entry_id'");
                
             }
             if($approve_status == 'Rejected'){
                 $this->rejection_mail_Send($description,$sq_customer['email_id'],$sq_customer['company_name'],$sq_customer['cp_first_name']);
             }
            echo "Information has been successfully updated.";
            exit;
        }
    }

    function rejection_mail_Send($description,$email_id,$company_name,$cp_name){
      global $mail_em_style, $mail_font_family, $mail_strong_style, $app_name;
      
      $content = '
		<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Description</td>   <td style="text-align:left;border: 1px solid #888888;">'.$description.'</td></tr>
            </table>
          </tr>';
      $subject = 'About Credit Limit Increase : '.$company_name;
      global $model;
      $model->app_email_send('106',$cp_name,$email_id, $content,$subject,'1');
   }

   function approval_mail_Send($description,$email_id,$company_name,$credit_limit,$cp_name){
     global $mail_em_style, $mail_font_family, $mail_strong_style, $app_name;
     
     
     $content = '
     <tr>
         <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
           <tr><td style="text-align:left;border: 1px solid #888888;">Credit Limit</td>   <td style="text-align:left;border: 1px solid #888888;">'.$credit_limit.'</td></tr>
           <tr><td style="text-align:left;border: 1px solid #888888;">Description</td>   <td style="text-align:left;border: 1px solid #888888;">'.$description.'</td></tr>
         </table>
       </tr>';
     $subject = 'Credit Limit Acknowledgment : '.$company_name;
     global $model;
     $model->app_email_send('107',$cp_name,$email_id, $content,$subject,'1');
  }
}