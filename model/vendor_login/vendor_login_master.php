<?php
$GLOBALS['flag'] = true;
class vendor_login_master{

public function vendor_login_save($username, $password,$vendor_type, $user_id, $active_flag, $email_id,$opening_balance,$side,$as_on_date){

  global $encrypt_decrypt, $secret_key;
  $password = $encrypt_decrypt->fnDecrypt($password, $secret_key);
  $email_id = $encrypt_decrypt->fnDecrypt($email_id, $secret_key);

  $sq_vendor = mysql_num_rows(mysql_query("SELECT * from vendor_login where username='$username' and password='$password'"));
  if($sq_vendor>0){
    $GLOBALS['flag'] = false;
    echo "error--Sorry, Vendor login details exists!";
  }
  $sq_max = mysql_fetch_assoc(mysql_query("SELECT max(login_id) as max from vendor_login"));
  $login_id = $sq_max['max'] + 1;

  $password1 = $encrypt_decrypt->fnEncrypt($password, $secret_key);
  $email_id1 = $encrypt_decrypt->fnEncrypt($email_id, $secret_key);
  $sq_login = mysql_query("insert into vendor_login (login_id, username, password,email, vendor_type, user_id, active_flag) values ('$login_id', '$username', '$password1', '$email_id1', '$vendor_type', '$user_id', '$active_flag')");

  $sq_max = mysql_fetch_assoc(mysql_query("select max(ledger_id) as max from ledger_master"));
  $ledger_id = $sq_max['max'] + 1;
  $username = addslashes($username);
  $ledger_name = $user_id.'_'.$username;
  $side = ($side == 'Credit') ? 'Cr' : 'Dr'; 
  $sq_ledger = mysql_query("insert into ledger_master (ledger_id, ledger_name, alias, group_sub_id, balance, dr_cr,customer_id,user_type) values ('$ledger_id', '$ledger_name', '', '105', '0','$side','$user_id','$vendor_type')");
  
  //Finance save
  //$this->finance_save($user_id,$ledger_id,$vendor_type,$side,$as_on_date,$opening_balance,$username);
  if(!$sq_login){
    $GLOBALS['flag'] = false;
    echo "error--Login details not saved!";
  }

  if($GLOBALS['flag']){
    $this->vendor_sign_up_mail($username, $password, $vendor_type, $email_id);
    $this->vendor_sign_up_sms($username, $password);
  }
}

public function finance_save($user_id, $ledger_id,$vendor_type,$side,$as_of_date,$opening_balance,$username){

	$row_spec = 'opening balance';
	$as_of_date = date('Y-m-d', strtotime($as_of_date));

	global $transaction_master;
	//////Opening balance to supplier ledger///////
	$module_name = $vendor_type;
	$module_entry_id = $user_id;
	$transaction_id = '';
	$payment_amount = $opening_balance;
	$payment_date = $as_of_date;
	$payment_particular = get_sup_opening_balance_particular($vendor_type,$opening_balance,$as_of_date,$username);
	$ledger_particular = 'By Cash/Bank';
	$gl_id = $ledger_id;
	$payment_side = ($side == 'Cr') ? 'Credit' : 'Debit';
	$clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);

  ////////Opening balance to Profit ledger//////
  $module_name = $vendor_type;
	$module_entry_id = $user_id;
	$transaction_id = '';
	$payment_amount = $opening_balance;
	$payment_date = $as_of_date;
	$payment_particular = get_sup_opening_balance_particular($vendor_type,$opening_balance,$as_of_date,$username);
	$ledger_particular = 'By Cash/Bank';
	$gl_id = 173;
	$payment_side = ($side == 'Cr') ? 'Debit' : 'Credit';
	$clearance_status = "";
	$transaction_master->transaction_save($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular, $gl_id, '',$payment_side, $clearance_status, $row_spec,$branch_admin_id,$ledger_particular);
}


public function vendor_login_update($login_id, $username, $password, $user_id, $active_flag, $email_id,$vendor_type, $opening_balance,$side1,$as_of_date)
{
  $sq_login = mysql_query("update vendor_login set username='$username', password='$password', user_id='$user_id', active_flag='$active_flag', email='$email_id' where login_id='$login_id'");

  $ledger_name = $user_id.'_'.$username;
  $side1 = ($side1 == 'Credit') ? 'Cr' : 'Dr'; 
  $q = "update ledger_master set ledger_name='$ledger_name', dr_cr='$side1' where user_type='$vendor_type' and customer_id='$user_id' ";
  $sq_login = mysql_query($q);
  
  //Finance save
  //$this->finance_update($user_id,$vendor_type,$side1,$as_of_date,$opening_balance,$ledger_name,$username);
  
  if(!$sq_login){
    $GLOBALS['flag'] = false;
    echo "error--Login details not updated!";
    }

}
public function finance_update($user_id,$vendor_type,$side,$as_of_date,$opening_balance,$ledger_name, $username)
{
	$row_spec = 'opening balance';
	$as_of_date = date('Y-m-d', strtotime($as_of_date));

	global $transaction_master;
	$sq_bank_b = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_name='$ledger_name' and user_type='$vendor_type' and customer_id='$user_id'"));

	//////Opening balance to supplier ledger///////
	$module_name = $vendor_type;
	$module_entry_id = $user_id;
	$transaction_id = '';
	$payment_amount = $opening_balance;
	$payment_date = $as_of_date;
	$payment_particular = get_sup_opening_balance_particular($vendor_type,$opening_balance,$as_of_date,$username);
	$ledger_particular = 'By Cash/Bank';
	$old_gl_id = $gl_id = $sq_bank_b['ledger_id'];
	$payment_side = ($side == 'Cr') ? 'Credit' : 'Debit';
	$clearance_status = "";
  $transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular);
  
  ////////Opening balance to Profit ledger//////
  $module_name = $vendor_type;
	$module_entry_id = $user_id;
	$transaction_id = '';
	$payment_amount = $opening_balance;
	$payment_date = $as_of_date;
	$payment_particular = get_sup_opening_balance_particular($vendor_type,$opening_balance,$as_of_date,$username);
	$ledger_particular = 'By Cash/Bank';
	$old_gl_id = $gl_id = 173;
	$payment_side = ($side == 'Dr') ? 'Credit' : 'Debit';
	$clearance_status = "";
	$transaction_master->transaction_update($module_name, $module_entry_id, $transaction_id, $payment_amount, $payment_date, $payment_particular,$old_gl_id, $gl_id, '',$payment_side, $clearance_status, $row_spec,$ledger_particular);
}

public function vendor_sign_up_mail($username,$password,$vendor_type, $email_id)



{
  

global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;



  global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color,$first_name,$last_name;




$link = BASE_URL.'/view/vendor_login/';
   $content = mail_login_box($username, $password, $link);

  //      <tr>

  //         <td>

  //             <table style="width: 338px;margin: 40px auto;background: #fff;border: 1px solid #ccc;">
  //               <tr >
  //                   <td style="border-bottom: 1px solid #e6e6e6;padding: 0;margin: 0;"><h3 style="color: #009898;text-align: center;margin: 0;background: #f5f7f7;text-transform: uppercase;font-weight: 300;padding: 10px 0;font-size: 24px;">Your Login Details!</h3></td>
  //               </tr>
  //               <tr>
  //                   <td>
  //                       <table style="width: 100%;padding: 20px;">
  //                         <tr>
  //                           <td>
  //                             <span style="float: left;"><img src="'.BASE_URL.'/images/email/name-icon.jpg"></span>
  //                             <span style="color: #559ee8;background: #f5f7f7;width: 217px;font-size: 18px;padding: 4px 0 4px 20px;float: left;">'.$username.'</span>
  //                           </td>
  //                         </tr>
  //                         <tr>
  //                           <td>
  //                             <span style="float: left;"><img src="'.BASE_URL.'/images/email/password-icon.jpg"></span>
  //                             <span style="color: #559ee8;background: #f5f7f7;width: 217px;font-size: 18px;padding: 4px 0 4px 20px;float: left;">'.$password.'</span>
  //                           </td>  
  //                         </tr>
  //                         <tr>
  //                           <td colspan="2" style="text-align: center;background: #4bbba4;padding: 3px;">
  //                               <a href="'.BASE_URL.'/view/vendor_login/" style="text-decoration: none;text-transform: uppercase;color: #fff;font-size: 19px;font-weight: 500;display: block;">LOGIN</a>
  //                           </td>
  //                         </tr>
  //                       </table>
  //                   </td>
  //               </tr>
  //             </table>
              
  //         </td>

  //     </tr>



  // ';

  


$subject = 'Welcome aboard!';
  global $model;

$model->app_email_send('3',$username,$email_id, $content,$subject,'1');

}







public function vendor_sign_up_sms($username, $password)
{
   global $app_name,$app_website,$model;
   $message = "Dear ".$username.",  Welcome to ".$app_name.". Login Link : ".BASE_URL."/view/vendor_login/"." "."  U : ".$username."  P : ".$password;

   $model->send_message($password, $message);
}

}



?>