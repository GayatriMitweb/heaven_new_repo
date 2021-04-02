<?php 
class enquiry_master{

///////////////////////***Enquiry Master Save start*********//////////////
function enquiry_master_save()
{

  $login_id = $_POST["login_id"]; 
  $enquiry_type = $_POST['enquiry_type'];
  $enquiry = $_POST['enquiry'];
  $name = $_POST["name"]; 
  $mobile_no = $_POST["mobile_no"]; 
  $landline_no = $_POST["landline_no"];
  $email_id = $_POST["email_id"]; 
  $assigned_emp_id = $_POST['assigned_emp_id'];
  $enquiry_specification = $_POST["enquiry_specification"]; 
  $enquiry_date = $_POST["enquiry_date"]; 
  $followup_date = $_POST["followup_date"];
  $reference_id = $_POST['reference_id'];
  $enquiry_content = $_POST['enquiry_content'];
  $enquiry_content = json_encode($enquiry_content);

    $sq_max_id = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));
    $enquiry_id = $sq_max_id['max']+1;

    $enquiry_date = date("Y-m-d", strtotime($enquiry_date));
    $followup_date = date("Y-m-d", strtotime($followup_date));

    $sq_enquiry = mysql_query("insert into enquiry_master (enquiry_id, login_id, enquiry_type,enquiry, name, mobile_no, landline_no, email_id, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id', '$login_id', '$enquiry_type','$enquiry', '$name', '$mobile_no', '$landline_no', '$email_id', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date', '$followup_date', '$reference_id', '$enquiry_content')");

    $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
    $entry_id = $sq_max['max'] + 1;

    $sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '', '')");

    if(!$sq_enquiry)
    {
      echo "error--Enquiry Information Not Saved.";
      exit;
    }  
    else
    {
      $this->send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification);
      $this->send_sms_enquiry_master($enquiry_id, $mobile_no);
      echo "Enquiry Information saved successfully.";
    }  

  }

///////////////////////***Enquiry Master Save end*********//////////////


function send_sms_enquiry_master($enquiry_id, $mobile_no)
{
   global $app_contact_no;
   $message = "We have received your enquiry. Pls, contact below for more details. Inq No.".$enquiry_id." . Contact :".$app_contact_no;
   global $model;
   $model->send_message($mobile_no, $message);

}


///////////////////////***Enquiry Email send start*********//////////////
function send_enquiry_mail($enquiry_id, $email_id, $name, $tour_name, $enquiry_specification)
{
  global $app_name;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

  $content = '
  <table style="padding:0 30px">
    <tr>
      <td colspan="2">
        <p>Hello '.$name.'</p>       
        <p>We Would like to Thank you for your inquiry and showing interest with  '.$app_name.'.</p>
        <p>We’re very happy to answer your question, you may have and aim to respond within 24 hours to make your holiday evergreen.</p>
        <p>
        In the meantime, should you require any further information please don’t hesitate to contact us.
        </p>        
      </td>
    </tr>
    <tr>
      <td>
        <table style="width:100%">
          <tr><td><strong>Please Find below inquiry details:-</strong></td></tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Enquiry No</span> : <span>'.$enquiry_id.'</span>
              </span>    
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Specification</span> : <span>'.$enquiry_specification.'</span> 
              </span>    
            </td>
          </tr>
          <tr>
            <td>
              <p>We hope that this email helps you to progress your inquiry.<br>
                Thanks again for getting in touch.
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

  $subject = "Inquiry Acknowledgment";

  global $model,$backoffice_email_id;

  $model->app_email_master($email_id, $content, $subject);
  $model->app_email_master($backoffice_email_id, $content, $subject);

}
///////////////////////***Enquiry Email send end*********//////////////


///////////////////////***Enquiry Master Update start*********//////////////
function enquiry_master_update()
{
  $enquiry_id = $_POST["enquiry_id"]; 
  $enquiry= $_POST["enquiry"]; 
  $mobile_no = $_POST["mobile_no"]; 
  $email_id = $_POST["email_id"]; 
  $landline_no = $_POST["landline_no"];
  $enquiry_date = $_POST['enquiry_date'];
  $followup_date = $_POST['followup_date'];

  $enquiry_date = date('Y-m-d', strtotime($enquiry_date));
  $followup_date = date('Y-m-d', strtotime($followup_date));

  $sq_enquiry = mysql_query("update enquiry_master set mobile_no='$mobile_no',landline_no = '$landline_no', email_id='$email_id', enquiry = '$enquiry', enquiry_date='$enquiry_date', followup_date='$followup_date' where enquiry_id='$enquiry_id'");
  if(!$sq_enquiry)
  {
    echo "error--Enquiry Information Not Updated.";
    exit;
  }  
  else
  {
    echo "Enquiry Information updated successfully.";
  }  

}
///////////////////////***Enquiry Master Update end*********//////////////


///////////////////////***Enquiry status update start*********//////////////
function enquiry_status_update($enquiry_id)
{
  $sq = mysql_query("update enquiry_master set status='Done' where enquiry_id='$enquiry_id'");
  if(!$sq){
    echo "Sorry, Status not updated.";
    exit;
  }
  else{
    echo "Enquiry is updated successfully.";
    exit;
  }

}
///////////////////////***Enquiry status update end*********//////////////


///////////////////////***Enquiry status update start*********//////////////
function enquiry_status_disable($enquiry_id)
{
  $sq = mysql_query("update enquiry_master set status='Disabled' where enquiry_id='$enquiry_id'");
  if(!$sq){
    echo "Sorry, Status not updated.";
    exit;
  }
  else{
    echo "Enquiry is updated successfully.";
    exit;
  }
}
///////////////////////***Enquiry status update end*********//////////////

///////////////////////***Enquiry followup save start*********//////////////
public function followup_reply_save()
{
  $enquiry_id = $_POST['enquiry_id'];
  $followup_reply = $_POST['followup_reply'];
  $followup_date = $_POST['followup_date'];
  $followup_type = $_POST['followup_type'];
  $followup_status = $_POST['followup_status'];
 
  $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
  $entry_id = $sq_max['max'];

  $created_at = date('Y-m-d H:i:s');
  $followup_date = date('Y-m-d H:i:s', strtotime($followup_date));

  $sq_entery_count = mysql_fetch_assoc(mysql_query("select * from enquiry_master_entries where enquiry_id='$enquiry_id'"));

  if($sq_entery_count['followup_reply']==""){
 
    $sq_followup = mysql_query("update enquiry_master_entries set followup_reply='$followup_reply',followup_date='$followup_date',followup_type='$followup_type',followup_status='$followup_status' where enquiry_id='$enquiry_id' and entry_id='$enquiry_id'");
   }
   else
  {
    $entry_id1 = $sq_max['max'] + 1;
   
    $sq_followup_add = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply, followup_status, followup_type, followup_date, created_at) values('$entry_id1', '$enquiry_id', '$followup_reply', '$followup_status','$followup_type', '$followup_date', '$created_at')");
  }
  if($sq_followup_add or $sq_followup){

    if($followup_status=="Converted"){
       $this->send_enquiry_coverted_mail($enquiry_id);
      $this->enquiry_converted_sms_send($enquiry_id);
    }

    echo "Followup saved successfully!";
    exit;

  }
  else{
    echo "error--Followup not saved successfully!";
    exit;
  }

}
///////////////////////***Enquiry followup save end*********//////////////

///////////////////////***Enquiry converted sms send start*********//////////////
public function enquiry_converted_sms_send($enquiry_id)
{
  global $app_contact_no;
  $sq_enquiry = mysql_fetch_assoc(mysql_query("select mobile_no from enquiry_master where enquiry_id='$enquiry_id'"));
  $mobile_no = $sq_enquiry['mobile_no'];

  $message = "We're thank you for inquiry with us and interested in providing the best services to make your journey awesome. Contact :".$app_contact_no;
  global $model;

  $model->send_message($mobile_no, $message);
}
///////////////////////***Enquiry converted sms send end*********//////////////

///////////////////////***Enquiry converted mail send start*********//////////////
function send_enquiry_coverted_mail($enquiry_id)
{
  global $app_name,$app_email_id;
  global $mail_em_style, $mail_em_style1, $mail_font_family, $mail_strong_style, $mail_color;

   $sq_enquiry_details = mysql_fetch_assoc(mysql_query("select * from enquiry_master where enquiry_id='$enquiry_id'"));
   $Cust_name = $sq_enquiry_details['name'];
   $enquiry_type = $sq_enquiry_details['enquiry_type'];
   $assigned_emp_id = $sq_enquiry_details['assigned_emp_id'];

   $sq_ass_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$assigned_emp_id'"));
   $emp_name = $sq_ass_emp['first_name'].' '.$sq_ass_emp['last_name'];

  $content = '
  <table style="padding:0 30px">
    <tr>
      <td colspan="2">
        <p>Hello '.$app_name.',</p>       
        <p>The new lead converted successfully!</p>
      </td>
    </tr>
    <tr>
      <td>
        <table style="width:100%">
          <tr><td><strong>Please Find below Enquiry details:-</strong></td></tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Enquiry No</span> : <span>'.$enquiry_id.'</span>
              </span>    
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Customer Name</span> : <span>'.$Cust_name.'</span>
              </span>    
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Enquiry Type</span> : <span>'.$enquiry_type.'</span>
              </span>    
            </td>
          </tr>
          <tr>
            <td>
              <span style="padding:5px 0; border-bottom:1px dotted #ccc; float: left">
                  <span style="color:'.$mail_color.'">Converted By</span> : <span>'.$emp_name.'</span> 
              </span>    
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

  $subject = "The new lead converted successfully!";

  global $model;

  $model->app_email_master($app_email_id, $content, $subject);
  
}
///////////////////////***Enquiry coverted mail send end*********//////////////

public function enquiry_csv_save()
{
    $enq_csv_dir = $_POST['enq_csv_dir'];
    $flag = true;

    $enq_csv_dir = explode('uploads', $enq_csv_dir);
    $enq_csv_dir = BASE_URL.'uploads'.$enq_csv_dir[1];


    begin_t();

    $count = 1;

    $handle = fopen($enq_csv_dir, "r");
    if(empty($handle) === false) {

        while(($data = fgetcsv($handle, ",")) !== FALSE){
            if($count>0){
                
                $sq_max_id = mysql_fetch_assoc(mysql_query("select max(enquiry_id) as max from enquiry_master"));

                $enquiry_id = $sq_max_id['max']+1;

                $login_id = $_SESSION['login_id'];            
                $enquiry_type = "Package Booking";
                $name = $data[0];
                $mobile_no = $data[1];
                $email_id = $data[2];
                $enquiry_specification = $data[16];
                $enquiry_date = $data[13];
                $followup_date = $data[14];
                $reference_id = $data[15];
                $assigned_emp_id =  $data[17];
               
                $enquiry_content = array(
                  array('name'=>'tour_name', 'value'=>$data[3]),
                  array('name'=>'travel_from_date', 'value'=>$data[4]),
                  array('name'=>'travel_to_date', 'value'=>$data[5]),
                  array('name'=>'budget', 'value'=>$data[6]),
                  array('name'=>'total_members', 'value'=>$data[7]),
                  array('name'=>'total_adult', 'value'=>$data[8]),
                  array('name'=>'total_children', 'value'=>$data[9]),
                  array('name'=>'total_infant', 'value'=>$data[10]),
                  array('name'=>'children_without_bed', 'value'=>$data[11]),
                  array('name'=>'children_with_bed', 'value'=>$data[12])
                );        
                $enquiry_content = json_encode($enquiry_content);               

                $enquiry_date = date("Y-m-d", strtotime($enquiry_date));
                $followup_date = date("Y-m-d", strtotime($followup_date));

                $query = "insert into enquiry_master (enquiry_id, login_id, enquiry_type, name, mobile_no, email_id, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content) values ('$enquiry_id', '$login_id', '$enquiry_type', '$name', '$mobile_no', '$email_id', '$assigned_emp_id', '$enquiry_specification', '$enquiry_date', '$followup_date', '$reference_id', '$enquiry_content')";
                $sq_enquiry = mysql_query($query);

                $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from enquiry_master_entries"));
                $entry_id = $sq_max['max'] + 1;

                $sq_followup = mysql_query("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '', '')");

                if(!$sq_enquiry)
                {
                  $flag = false;
                  echo "error--Enquiry Information Not Saved.";
                  //exit;
                }    
            }  
            

            $count++;

        }
       
        fclose($handle);
    }

    if($flag){
      commit_t();
      echo "Enquiries imported";
      exit;
    }
    else{
      rollback_t();
      exit;
    }

}


}

?>