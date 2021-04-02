<?php 

class leave_master{



///////////// Employee request Save/////////////////////////////////////////////////////////////////////////////////////////

 public function leave_request_save()

 { 	

   $emp_id=$_POST['emp_id'];

   $from_date=$_POST['from_date'];

   $to_date=$_POST['to_date'];

   $no_of_days=$_POST['no_of_days'];

   $type_of_leave=$_POST['type_of_leave'];

   $reason_for_leave=$_POST['reason_for_leave']; 

   $from_date = date('Y-m-d',strtotime($from_date));
   $to_date = date('Y-m-d',strtotime($to_date));

   $created_date = date('Y-m-d');

  //Transaction start

  begin_t();
  
 	$row=mysql_query("select max(request_id) as max from leave_request");

 	$value=mysql_fetch_assoc($row);

 	$max=$value['max']+1;


  $reason_for_leave = addslashes($reason_for_leave);
 	$sq=mysql_query("insert into leave_request (request_id, emp_id, from_date, to_date, no_of_days, type_of_leave, reason_for_leave, created_date ) values ('$max', '$emp_id', '$from_date', '$to_date', '$no_of_days', '$type_of_leave', '$reason_for_leave','$created_date')");


 	if($sq)
 	{
      commit_t();
      echo "Request has been successfully saved.";
  }

 else
  {
    rollback_t();
    echo "error-- Request Not Send!!!";
  }  

 }

/////////////////////////////////////////////////
///////////// reply/////////////////////////////////////////////////////////////////////////////////////////

 public function leave_reply_save()

 {  
   $request_id =$_POST['request_id'];
   $emp_id=$_POST['emp_id'];
   $from_date=$_POST['from_date'];
   $to_date=$_POST['to_date'];
   $no_of_days=$_POST['no_of_days'];
   $comments = $_POST['comments'];
   $type_of_leave = $_POST['type_of_leave'];
   
   $from_date = date('Y-m-d',strtotime($from_date));
   $to_date = date('Y-m-d',strtotime($to_date));
   $reply_date = date('Y-m-d');

  //Transaction start

  begin_t();
    
  $comments = addslashes($comments);
  $sq_u=mysql_query("update leave_request set from_date='$from_date', to_date='$to_date', no_of_days='$no_of_days', comments='$comments', reply_date='$reply_date', status='Approved', type_of_leave='$type_of_leave' where request_id='$request_id'");

  $query =mysql_fetch_assoc(mysql_query("select * from leave_credits where emp_id='$emp_id'"));

    if($type_of_leave=='Casual')
    {
      $leaves = $query['casual'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set casual='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Paid'){
      $leaves = $query['paid'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set paid='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Medical'){
      $leaves = $query['medical'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set medical='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Maternity'){
      $leaves = $query['maternity'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set maternity='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Paternity'){
      $leaves = $query['paternity'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set paternity='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Leave without pay'){
      $leaves = $query['leave_without_pay'] - $no_of_days;
     
      $sq=mysql_query("update leave_credits set leave_without_pay='$leaves' where emp_id='$emp_id'");
    }
  if($sq_u)
  {
      commit_t();

      $this->reply_mail($emp_id, $request_id, $from_date, $to_date);
      echo "Remark has been successfully saved.";
  }

 else
  {
    rollback_t();
    echo "error-- Reply Not Send!!!";
  }  

 }

public function reply_mail($emp_id, $request_id, $from_date, $to_date)

{

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

   $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
   $email_id = $sq_emp['email_id'];

   $content = '
   <tr>
           <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
             
           </table>
         </tr>';



  global $model;

   $subject = "Leave reply";

   $model->app_email_send('95',$sq_emp['first_name'],$email_id, $content, $subject,'1');
  //$model->app_email_send('95',,$email_id, $content);
}


///////////// reject/////////////////////////////////////////////////////////////////////////////////////////

 public function leave_request_reject()

 {  
   $request_id =$_POST['request_id'];
   $emp_id=$_POST['emp_id'];
   $comments = $_POST['comments'];
   $from_date=$_POST['from_date'];
   $no_of_days=$_POST['no_of_days'];
   $status=$_POST['status'];
   $to_date=$_POST['to_date'];
   $from_date = date('Y-m-d',strtotime($from_date));
   $to_date = date('Y-m-d',strtotime($to_date));
   $reply_date = date('Y-m-d');
   $type_of_leave=$_POST['type_of_leave'];

  //Transaction start

  begin_t();
    
  $comments = addslashes($comments);
  $sq_u=mysql_query("update leave_request set comments='$comments', reply_date='$reply_date', status='Reject' where request_id='$request_id'");
  if($status == 'Approved')
  {
     $query =mysql_fetch_assoc(mysql_query("select * from leave_credits where emp_id='$emp_id'"));

    if($type_of_leave=='Casual')
    {
      $leaves = $query['casual'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set casual='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Paid'){
      $leaves = $query['paid'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set paid='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Medical'){
      $leaves = $query['medical'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set medical='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Maternity'){
      $leaves = $query['maternity'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set maternity='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Paternity'){
      $leaves = $query['paternity'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set paternity='$leaves' where emp_id='$emp_id'");
    }
    if($type_of_leave=='Leave without pay'){
      $leaves = $query['leave_without_pay'] + $no_of_days;
     
      $sq=mysql_query("update leave_credits set leave_without_pay='$leaves' where emp_id='$emp_id'");
    }
  }


  if($sq_u)
  {
      commit_t();
      $this->reject_mail($emp_id, $request_id, $from_date, $to_date, $comments);
      echo "Reject Send Successfully!!!";
  }

 else
  {
    rollback_t();
    echo "error-- Reject Not Send!!!";
  }  

 }
 
 public function reject_mail($emp_id, $request_id, $from_date, $to_date ,$comments)

{

  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website;

  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

   $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
   $email_id = $sq_emp['email_id'];

   $content = '
   <tr>
           <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
             
           </table>
         </tr>';



  global $model;

  // $subject = "Leave reply";

   $model->app_email_send('96',$sq_emp['first_name'],$email_id, $content, $subject,'1');
  //$model->app_email_send('96',$email_id, $content);
}

///////////// Credit/////////////////////////////////////////////////////////////////////////////////////////

 public function leave_credit_save()

 {  
   $emp_id=$_POST['emp_id'];
   $paid =$_POST['paid'];
   $casual = $_POST['casual'];
   $medical=$_POST['medical'];
   $maternity=$_POST['maternity'];
   $paternity = $_POST['paternity'];
   $leave_without_pay = $_POST['leave_without_pay'];
   $created_date = date('Y-m-d');
  //Transaction start

  begin_t();
   $sq_count = mysql_num_rows(mysql_query("select * from leave_credits where emp_id='$emp_id'"));
   if($sq_count>0){
    echo "error--Leave Credit Already added!!!";
   } 
   else{
    $row=mysql_query("select max(id) as max from leave_credits");

    $value=mysql_fetch_assoc($row);

    $max=$value['max']+1;

    $reason_for_leave = addslashes($reason_for_leave);
    $sq=mysql_query("insert into leave_credits (id, emp_id, paid, casual, medical, maternity, paternity, leave_without_pay, created_date ) values ('$max', '$emp_id', '$paid', '$casual', '$medical', '$maternity', '$paternity', '$leave_without_pay', '$created_date')");

    if($sq)
    {
        commit_t();
        echo "Leave Credit has been successfully saved.";
    }

   else
    {
      rollback_t();
      echo "error-- Credit Not Saved!!!";
    }  
  }  
 }

public function leave_credit_update()

 {  
   $emp_id=$_POST['emp_id'];
   $paid =$_POST['paid'];
   $casual = $_POST['casual'];
   $medical=$_POST['medical'];
   $maternity=$_POST['maternity'];
   $paternity = $_POST['paternity'];
   $leave_without_pay = $_POST['leave_without_pay'];

  //Transaction start

  begin_t();

    $reason_for_leave = addslashes($reason_for_leave);
    $sq=mysql_query("update leave_credits set paid='$paid', casual='$casual', medical='$medical', maternity='$maternity', paternity='$paternity', leave_without_pay='$leave_without_pay' where emp_id='$emp_id'");

    if($sq)
    {
        commit_t();
        echo "Leave Credit has been successfully updated.";
    }

   else
    {
      rollback_t();
      echo "error-- Credit Not Updated!!!";
    }  
 
 }


}

?>