<?php
class fourth_coming_attraction_master{

///////////////////////***Fourth Coming attraction master save start*********//////////////
function fourth_coming_attraction_master_save($title, $description, $valid_date)
{
  $title = mysql_real_escape_string($title);
  $description = mysql_real_escape_string($description);
  $valid_date = mysql_real_escape_string($valid_date);

  $valid_date = date('Y-m-d', strtotime($valid_date));
  $created_at = date("Y-m-d");

  $max_id =  mysql_fetch_assoc(mysql_query("select max(id) as max from fourth_coming_attraction_master"));
  $max_id = $max_id['max']+1;

  $sq = mysql_query("insert into fourth_coming_attraction_master (id, title, description, valid_date, created_at) values ('$max_id', '$title', '$description', '$valid_date', '$created_at')");
  if(!$sq)
  {
    echo "error--Error while saving.";
    exit;
  }  
  else
  {
    echo "Information has been successfully saved.";
  } 

  $sq_customer =mysql_query("select * from customer_master");
  while($sq_row = mysql_fetch_assoc($sq_customer))
  {

    $name = $sq_row['first_name']."". $sq_row['last_name']; 
    $contact = $sq_row['contact_no'];
    $email= $sq_row['email_id'];
    $this->fourth_coming_attraction_email($name,$title,$description,$valid_date,$email);
    $this->fourth_coming_offers_sms($contact);
  }  

}

///////////////////////***Fourth Coming attraction master save end*********//////////////

///////////////////////***Fourth Coming attraction master update start*********//////////////

function fourth_coming_attraction_master_update($id, $title, $valid_date, $description)
{
  $title = mysql_real_escape_string($title);
  $description = mysql_real_escape_string($description);

  $valid_date = date('Y-m-d', strtotime($valid_date));


  $sq = mysql_query("update fourth_coming_attraction_master set title='$title', valid_date='$valid_date', description='$description' where id='$id'");
  if(!$sq)
  {
    echo "error--Error while saving.";
    exit;
  }  
  else
  {
    echo "Information has been successfully updated.";
  }  

  while($sq_row=mysql_fetch_assoc($sq_customer))
  {

    $name = $sq_row['first_name']."". $sq_row['last_name']; 
    $contact = $sq_row['contact_no'];
    $email= $sq_row['email_id'];
    $this->fourth_coming_attraction_email($name,$title,$description,$valid_date,$email);
    $this->fourth_coming_offers_sms($contact);
  }  

}

///////////////////////***Fourth Coming attraction master update end*********//////////////


///////////////////////***Fourth Coming attraction disable start*********//////////////

function fourth_coming_attraction_disable($id)
{
  $sq = mysql_query("update fourth_coming_attraction_master set status='Disabled' where id='$id'");
  if(!$sq)
  {
    echo "Error while saving.";
    exit;
  }  
  else
  {
    echo "Tour Offer has bee successfully disabled.";
  }  
}

///////////////////////***Fourth Coming attraction disable end*********//////////////
function fourth_coming_attraction_email($name,$title,$description,$valid_date,$email)
{
  global $app_name;
  $valid_date1 = date('d-m-Y', strtotime($valid_date));
   $content='
   <table>
    <tr>
      <td colspan="2">
      <p style="line-height: 24px;">Hi '.$name.',</p>
      <p style="line-height: 24px;">We would like to inform you that <span>'.$app_name.'</span>coming up with an Exciting Offer for a Limited Period, details are as mentioned below.</p>
      <p style="line-height: 24px;"><strong style="float: left; width: 95px;">Title :</strong> <span>'.$title.'</span></p>
      <p style="line-height: 24px;"><strong style="float: left; width: 95px;">Valid Date :</strong><span> '.$valid_date1.'</span></p>
      <p style="line-height: 24px; float: left; width: 100%; margin-top: 0;line-height: 24px;"><strong style="float: left;    width: 95px;">Description : </strong><span style="float: left; width: 80%;">'.$description.'</span></p>
      <p style="line-height: 24px;">We hope that you will take full advantage of the respective offer to the fullest.</p>
      <p style="line-height: 24px;">Thank you for your kind patronage.</p></td>
    </tr>
  </table>';

  $subject = "Announcement of Fourth Coming Attraction";
  global $model;
  $model->app_email_master($email, $content, $subject,'1');
 }

public function fourth_coming_offers_sms($contact)
{
  global $app_contact_no,$valid_date,$description,$title;

  $message = "We would like to inform you that our company will be having new forth coming attraction and it will end on ".$valid_date.". Contact :".$app_contact_no."Title : ".$title."
         Valid Date : ".$valid_date."
         Description : ".$description."";
  global $model;

  $model->send_message($contact, $message);
}
	
}
?>