<?php 

class vendor_login_master{



public function vendor_login_save($username, $password, $vendor_type, $user_id, $active_flag, $email_id)

{

	$sq_vendor = mysql_num_rows(mysql_query("SELECT * from vendor_login where username='$username' and password='$password'"));

	if($sq_vendor>0){

		$GLOBALS['flag'] = false;

		echo "error--Sorry, Vendor login details exists!";

	}



	$sq_max = mysql_fetch_assoc(mysql_query("SELECT max(login_id) as max from vendor_login"));

	$login_id = $sq_max['max'] + 1;



	$sq_login = mysql_query("insert into vendor_login (login_id, username, password, vendor_type, user_id, active_flag, email) values ('$login_id', '$username', '$password', '$vendor_type', '$user_id', '$active_flag', '$email_id')");

	if(!$sq_login){

		$GLOBALS['flag'] = false;

		echo "error--Login details not saved!";

	}else

	{

		$this->vendor_sign_up_mail($username, $password, $vendor_type, $email_id);

    $this->vendor_sign_up_sms($username, $password);

	}



}



public function vendor_login_update($login_id, $username, $password, $user_id, $active_flag, $email_id)

{

	$sq_vendor = mysql_num_rows(mysql_query("SELECT * from vendor_login where username='$username' and password='$password' and vendor_type='$vendor_type' and login_id!='$login_id'"));

	if($sq_vendor>0){

		$GLOBALS['flag'] = false;

		echo "error--Sorry, Vendor login details exists!";

	}



	$sq_login = mysql_query("UPDATE vendor_login set username='$username', password='$password', user_id='$user_id', active_flag='$active_flag', email='$email_id' where login_id='$login_id'");

	if(!$sq_login){

		$GLOBALS['flag'] = false;

		echo "error--Login details not updated!";

		}else

		{

			$this->vendor_sign_up_mail($username, $password, $vendor_type, $email_id);

      $this->vendor_sign_up_sms($username, $password);

		}

}



public function vendor_sign_up_mail($username,$password,$vendor_type, $email_id)

{

global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

  global $mail_em_style, $mail_font_family, $mail_strong_style, $mail_color;

  $content = '

  <table style="padding:0 30px">

    <tr>

      <td colspan="2">

        <p>Hi</p>

        <p>We are very happy to welcome you to join '.$app_name.', iTours - tour operator software portal.</p>

        <p>Congratulations for being a part of '.$app_name.', iTours software portal to educate the processes & customer satisfaction ! Our whole team welcomes you. We are looking forward for the company’s success with you. Welcome aboard!</p>

      </td>

    </tr>

    <tr>

      <td>

        <table style="border-collapse: collapse;">

          <tr>

            <td style="padding:7px 0;">

                <a href="'.BASE_URL.'/view/vendor_login/" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">Login</a>

            </td>

          </tr>

          <tr>

            <td style="padding:7px; border:1px solid #c5c5c5">Username  :&nbsp;&nbsp;<span style="color:'.$mail_color.'">'.$username.'</span></td>

          </tr>

          <tr>

            <td style="padding:7px; border:1px solid #c5c5c5">Password  :&nbsp;&nbsp;<span style="color:'.$mail_color.'">'.$password.'</span></td>

          </tr>

          <tr>

            <td style="padding:7px; border:1px solid #c5c5c5">Click here to enter your hotel pricing</td>

          </tr>

          <tr>

            <td style="padding:7px; border:1px solid #c5c5c5"><a href="'.BASE_URL.'/view/vendor_login/view/hotel_pricing/index.php" style="color: #fff; background: #2fa6df; padding: 10px 23px; display: inline-block; margin: 10px 0px; text-decoration:none">Hotel Pricing</a></td>

          </tr>

          <tr>

            <td style="padding-top:20px;"><p>Note : We are tracking the misuse of the system.</p></td>

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

  $subject = "Welcome Aboard";

  $model->app_email_master($email_id, $content, $subject,'1');

}



public function vendor_sign_up_sms($username, $password)

{

   global $app_name;

   $message = "Welcome to  ".$app_name.". L : ".BASE_URL."/view/vendor_login/"." "." U : ".$username." P : ".$password;

   global $model;

   $model->send_message($password, $message);

}





}

?>