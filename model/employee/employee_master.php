<?php 

class employee_master{



///////////// Employee Save/////////////////////////////////////////////////////////////////////////////////////////

 public function emp_master_save()

 { 	

   $first_name=$_POST['first_name'];

   $last_name=$_POST['last_name'];

   $gender=$_POST['gender'];
   $username=$_POST['username'];
   $password=$_POST['password'];

   $address=$_POST['address']; 

   $mobile_no=$_POST['mobile_no'];

   $country_code = $_POST['country_code'];

   $landline_no = $_POST['landline_no'];
   
   $email_id=$_POST['email_id']; 

   $location_id=$_POST['location_id'];

   $branch_id=$_POST['branch_id'];

   $salary=$_POST['salary'];

   $role_id=$_POST['role_id'];

   $target=$_POST['target'];
   $incentive_per=$_POST['incentive_per'];

   $active_flag=$_POST['active_flag'];

   $employee_birth_date = $_POST['employee_birth_date'];

   $age=$_POST['age'];

   $txt_mobile_no1 = $_POST['txt_mobile_no1'];

   $date_of_join = $_POST['date_of_join'];

   $id_upload_url = $_POST['id_upload_url'];

   $photo_upload_url = $_POST['photo_upload_url'];

   $visa_country_name = $_POST['visa_country_name'];
   $visa_type = $_POST['visa_type'];
   $issue_date = $_POST['issue_date'];
   $expiry_date = $_POST['expiry_date'];
   $visa_amt = $_POST['visa_amt'];
   $renewal_amount = $_POST['renewal_amount'];
   $bank_name = $_POST['bank_name'];
   $branch_name = $_POST['branch_name'];
   $ifsc = $_POST['ifsc'];
   $acc_no = $_POST['acc_no'];
   $basic_pay = $_POST['basic_pay'];
   $dear_allow = $_POST['dear_allow'];
   $hra = $_POST['hra'];
   $travel_allow = $_POST['travel_allow'];
   $medi_allow = $_POST['medi_allow'];
   $special_allow = $_POST['special_allow'];
   $uniform_allowance = $_POST['uniform_allowance'];
   $incentive = $_POST['incentive'];
   $meal_allowance = $_POST['meal_allowance'];
   $gross_salary = $_POST['gross_salary'];
   $employee_pf = $_POST['employee_pf'];
   $esic =$_POST['esic'];
   $pt = $_POST['pt'];
   $tds = $_POST['tds'];
   $labour_all = $_POST['labour_all'];
   $employer_pf = $_POST['employer_pf'];
   $deduction = $_POST['deduction'];
   $net_salary = $_POST['net_salary'];
   $uan_code = $_POST['uan_code'];
   //Mailing details
   $app_smtp_status = $_POST['app_smtp_status'];
	 $app_smtp_host = $_POST['app_smtp_host'];
	 $app_smtp_port = $_POST['app_smtp_port'];
	 $app_smtp_password = $_POST['app_smtp_password'];
	 $app_smtp_method = $_POST['app_smtp_method'];

   $issue_date = date('Y-m-d',strtotime($issue_date));
   $expiry_date = date('Y-m-d',strtotime($expiry_date));

   $date_of_join = date('Y-m-d',strtotime($date_of_join));

   $employee_birth_date = date('Y-m-d',strtotime($employee_birth_date));
   global $encrypt_decrypt, $secret_key;
   $username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
   $password = $encrypt_decrypt->fnEncrypt($password, $secret_key);

  //Transaction start

  begin_t();


$mobile_no = $country_code.$mobile_no;


  $username_count = mysql_num_rows(mysql_query(" select * from roles where user_name= '$username'"));

  if($username_count>0)

  {

    echo "error--The username has already been taken..";

    exit;

  } 



  $emp_name_count = mysql_num_rows(mysql_query("select * from emp_master where first_name='$first_name' and last_name='$last_name' and mobile_no='$mobile_no' and email_id = '$email_id'")); 

  if($emp_name_count>0){

    echo "error--Sorry, The username has already been taken.";

    exit;

  }





 	$row=mysql_query("select max(emp_id) as max from emp_master");

 	$value=mysql_fetch_assoc($row);

 	$max=$value['max']+1;


  $address = addslashes($address);
  $first_name = addslashes($first_name);
  $last_name = addslashes($last_name);
 	$sq=mysql_query("insert into emp_master (emp_id, first_name, last_name, gender, username, password, address, country_code,mobile_no, email_id, location_id, branch_id, salary, role_id,target, active_flag, dob,age, date_of_join, mobile_no2, id_proof_url, photo_upload_url,incentive_per, visa_country_name, visa_type, issue_date, expiry_date, visa_amt, renewal_amount,  dear_allow, basic_pay, acc_no,ifsc, branch_name,bank_name,hra,travel_allow,medi_allow,special_allow,uniform_allowance,incentive,meal_allowance,gross_salary,employee_pf,esic,pt,tds,labour_all,employer_pf,deduction,net_salary,uan_code,app_smtp_status, app_smtp_host, app_smtp_port, app_smtp_password, app_smtp_method) values ('$max', '$first_name', '$last_name', '$gender', '$username', '$password', '$address', '$country_code','$mobile_no', '$email_id', '$location_id', '$branch_id', '$salary', '$role_id','$target', '$active_flag','$employee_birth_date','$age', '$date_of_join','$landline_no','$id_upload_url', '$photo_upload_url','$incentive_per','$visa_country_name','$visa_type','$issue_date','$expiry_date','$visa_amt','$renewal_amount','$dear_allow','$basic_pay','$acc_no','$ifsc','$branch_name','$bank_name','$hra','$travel_allow','$medi_allow','$special_allow','$uniform_allowance','$incentive','$meal_allowance','$gross_salary','$employee_pf','$esic','$pt','$tds','$labour_all','$employer_pf','$deduction','$net_salary','$uan_code', '$app_smtp_status', '$app_smtp_host', '$app_smtp_port', '$app_smtp_password', '$app_smtp_method')");



 	if($sq){



      $row1=mysql_query("select max(id) as max from roles");
      $value1=mysql_fetch_assoc($row1);
      $max1=$value1['max']+1;

      $sq1 = mysql_query("insert into roles (id, role_id,branch_admin_id, emp_id, user_name, password, active_flag) values ('$max1', '$role_id', '$branch_id', '$max', '$username', '$password', '$active_flag')");

      if(!$sq1){
        rollback_t();
        echo "<br> Role not saved!";
      }  

      else{

        //Email employee sign up notification
          $sq_cms_count = mysql_num_rows(mysql_query("select * from cms_master_entries where id='1' and active_flag='Active'"));
          if($sq_cms_count != '0'){
            $this->employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id);
          }  
          $this->employee_sign_up_sms($first_name, $last_name,$username, $password, $mobile_no);

          commit_t();
          echo "New User has been successfully saved.";
      }



 	}	

 	else

 	{

 		echo "Error";

    exit;

 	}	





 }


 ///////////// Employee Update////////////////////////////////////////////////////////////////////////////////////////

 public function emp_photo_save()

 {  

   $emp_id=$_POST['emp_id'];

   $photo_upload_url = $_POST['user_url'];
  
   $sq = mysql_query("update emp_master set photo_upload_url='$photo_upload_url' where emp_id='$emp_id' ");
  if($sq){
      echo "User Photo updated!";
  } 
  else{
     echo "User Photo Not Updated !";  

  }
 }



 ///////////// Employee Update////////////////////////////////////////////////////////////////////////////////////////

 public function emp_master_update()

 {  

   $emp_id=$_POST['emp_id'];

   $first_name=$_POST['first_name'];

   $last_name=$_POST['last_name'];

   $gender=$_POST['gender'];

   $username=$_POST['username'];

   $password=$_POST['password'];

   $address=$_POST['address']; 

   $country_code = $_POST['country_code'];

   $mobile_no=$_POST['mobile_no'];

   $email_id=$_POST['email_id']; 

   $location_id=$_POST['location_id'];

   $branch_id=$_POST['branch_id'];

   $salary=$_POST['salary'];

   $role_id=$_POST['role_id'];

   $target=$_POST['target'];
   $incentive_per=$_POST['incentive_per'];
   $active_flag=$_POST['active_flag'];

   $employee_birth_date1=$_POST['employee_birth_date'];

   $age=$_POST['age'];

   $landline_no=$_POST['landline_no'];

   $date_of_join1=$_POST['date_of_join'];

   $id_upload_url1=$_POST['id_upload_url'];

   $photo_upload_url = $_POST['photo_upload_url'];

   $visa_country_name = $_POST['visa_country_name'];
   $visa_type = $_POST['visa_type'];
   $issue_date = $_POST['issue_date'];
   $expiry_date = $_POST['expiry_date'];
   $visa_amt = $_POST['visa_amt'];
   $renewal_amount = $_POST['renewal_amount'];
   $visa_country_name = $_POST['visa_country_name'];
   $visa_type = $_POST['visa_type'];
   $issue_date = $_POST['issue_date'];
   $expiry_date = $_POST['expiry_date'];
   $visa_amt = $_POST['visa_amt'];
   $renewal_amount = $_POST['renewal_amount'];
   $bank_name = $_POST['bank_name'];
   $branch_name = $_POST['branch_name'];
   $ifsc = $_POST['ifsc'];
   $acc_no = $_POST['acc_no'];
   $basic_pay = $_POST['basic_pay'];
   $dear_allow = $_POST['dear_allow'];
   $hra = $_POST['hra'];
   $travel_allow = $_POST['travel_allow'];
   $medi_allow = $_POST['medi_allow'];
   $special_allow = $_POST['special_allow'];
   $uniform_allowance = $_POST['uniform_allowance'];
   $incentive = $_POST['incentive'];
   $meal_allowance = $_POST['meal_allowance'];
   $gross_salary = $_POST['gross_salary'];
   $employee_pf = $_POST['employee_pf'];
   $esic =$_POST['esic'];
   $pt = $_POST['pt'];
   $tds = $_POST['tds'];
   $labour_all = $_POST['labour_all'];
   $employer_pf = $_POST['employer_pf'];
   $deduction = $_POST['deduction'];
   $net_salary = $_POST['net_salary'];
   $uan_code = $_POST['uan_code'];

   //Mailing details
   $app_smtp_status = $_POST['app_smtp_status'];
	 $app_smtp_host = $_POST['app_smtp_host'];
	 $app_smtp_port = $_POST['app_smtp_port'];
	 $app_smtp_password = $_POST['app_smtp_password'];
	 $app_smtp_method = $_POST['app_smtp_method'];

   $issue_date1 = date('Y-m-d',strtotime($issue_date));
   $expiry_date1 = date('Y-m-d',strtotime($expiry_date));
   $date_of_join1 = date('Y-m-d',strtotime($date_of_join1));
 
   $mobile_no = $country_code.$mobile_no;
   $employee_birth_date1 = date('Y-m-d',strtotime($employee_birth_date1));
   global $encrypt_decrypt, $secret_key;
   $username = $encrypt_decrypt->fnEncrypt($username, $secret_key);
   $password = $encrypt_decrypt->fnEncrypt($password, $secret_key);
   $username1 = $username;
   $password1 = $password;

   $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
  //Begin Transaction

  begin_t();

  $cur_username_sq = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='$emp_id'"));
  $cur_username = $cur_username_sq['user_name'];

  $username_count = mysql_num_rows(mysql_query(" select * from roles where user_name= '$username'"));

  if($username_count>0 && $username!=$cur_username)
  {
    echo "The username has already been taken.";
    exit;

  }  



  $emp_name_count = mysql_num_rows(mysql_query("select * from emp_master where first_name='$first_name' and last_name='$last_name' and mobile_no='$mobile_no' and email_id = '$email_id' and emp_id!='$emp_id'")); 

  if($emp_name_count>0){

    echo "error--Sorry, The username has already been taken.";

    exit;

  }

  
  $address = addslashes($address);
  $first_name = addslashes($first_name);
  $last_name = addslashes($last_name);
  $sq = mysql_query("update emp_master set first_name='$first_name', last_name='$last_name', gender='$gender', username='$username', password='$password', address='$address',country_code = '$country_code', mobile_no='$mobile_no', email_id='$email_id', location_id='$location_id', branch_id='$branch_id', salary='$salary', role_id='$role_id',target = '$target', active_flag='$active_flag' ,dob='$employee_birth_date1',age='$age', date_of_join='$date_of_join1', mobile_no2='$landline_no', id_proof_url='$id_upload_url1', photo_upload_url='$photo_upload_url',incentive_per='$incentive_per', visa_country_name='$visa_country_name', visa_type='$visa_type', issue_date='$issue_date1', expiry_date='$expiry_date1', visa_amt='$visa_amt', renewal_amount='$renewal_amount', dear_allow='$dear_allow', basic_pay='$basic_pay', acc_no='$acc_no',ifsc='$ifsc', branch_name='$branch_name',bank_name='$bank_name',hra='$hra',travel_allow='$travel_allow',medi_allow='$medi_allow' , special_allow='$special_allow', uniform_allowance='$uniform_allowance', incentive='$incentive', meal_allowance='$meal_allowance', gross_salary ='$gross_salary', employee_pf='$employee_pf',esic='$esic',pt='$pt',tds='$tds',labour_all='$labour_all',employer_pf='$employer_pf',deduction='$deduction',net_salary='$net_salary',uan_code = '$uan_code', app_smtp_status='$app_smtp_status', app_smtp_host='$app_smtp_host', app_smtp_port='$app_smtp_port', app_smtp_password='$app_smtp_password', app_smtp_method='$app_smtp_method' where emp_id='$emp_id' ");

  if($sq)

  {

    $sq1 = mysql_query("update roles set role_id='$role_id', user_name='$username', password='$password', active_flag='$active_flag' where emp_id='$emp_id' ");

    if(!$sq1){
      rollback_t();
      echo "User Not updated.";
    } 
    else{
      if($sq_emp['username']!=$username1 || $sq_emp['password']!=$password1){
        $this->employee_update_sms($first_name, $last_name,$username, $password, $mobile_no);
      }
      commit_t();
      echo "User has been successfully updated";  
    }
  } 

  else

  {

    echo "Error";

    exit;

  }     



 }





public function employee_sign_up_mail($first_name, $last_name, $username, $password, $email_id)

{

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$encrypt_decrypt,$secret_key;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

  $username = $encrypt_decrypt->fnDecrypt($username, $secret_key);
  $password = $encrypt_decrypt->fnDecrypt($password, $secret_key);
  $content = mail_login_box($username, $password, BASE_URL);


  $subject = "";

  global $model;
  $model->app_email_send('1',$first_name,$email_id, $content,$subject,'1');

}

public function employee_sign_up_sms($first_name, $last_name,$username, $password, $mobile_no1)
{
   global $app_name,$encrypt_decrypt,$secret_key;
   $username = $encrypt_decrypt->fnDecrypt($username, $secret_key);
   $password = $encrypt_decrypt->fnDecrypt($password, $secret_key);

   $message = "Dear ".$first_name." ".$last_name.", Welcome to ".$app_name."
      Login Link : "
      .BASE_URL."  
      U : ".$username." 
      P : ".$password." 
      ";

   global $model;
   $model->send_message($mobile_no1, $message);

}

public function employee_update_sms($first_name, $last_name,$username, $password, $mobile_no1)
{
  global $app_name,$encrypt_decrypt,$secret_key;
  $username = $encrypt_decrypt->fnDecrypt($username, $secret_key);
  $password = $encrypt_decrypt->fnDecrypt($password, $secret_key);

   $message = "Dear ".$first_name." ".$last_name.".  Your updated login details are 
      L : ".BASE_URL."  
      U : ".$username." 
      P : ".$password.". 
      All the best for future journey with ".$app_name."";

   global $model;
   $model->send_message($mobile_no1, $message);
}

}

?>
 