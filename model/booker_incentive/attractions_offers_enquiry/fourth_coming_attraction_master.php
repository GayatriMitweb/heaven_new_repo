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
    echo "Information saved successfully.";
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
    echo "Information updated successfully.";
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
    echo "Information disabled.";
  }  
}

///////////////////////***Fourth Coming attraction disable end*********//////////////
function fourth_coming_attraction_email($name,$title,$description,$valid_date,$email)
{

   $content='
   <table>
    <tr>
      <td colspan="2">
      <p>Hi '.$name.'</p>
      <p>We would like to inform you that our  company will be having new forth coming  attraction and it will end on '.$valid_date.'.</p>
      <p><strong>Title : '.$title.'</strong></p>
      <p><strong>Valid Date : '.$valid_date.'</strong></p>
      <p><strong>Description : '.$description.'</strong></p>
      <p>We are hoping that you will take advantage of the new special coming  attraction. Thank you for your patronage.</p></td>
      <td>
        <img src="'.BASE_URL.'/images/email/vacation.png" style="width:175px; height:auto; margin-bottom: -10px;" alt="">
      </td>
    </tr>
  </table>';

  $subject = "Announcement of Fourth Coming Attraction";
  global $model;
  $model->app_email_master($email, $content, $subject);
 }

public function fourth_coming_offers_sms($contact)
{
  global $app_contact_no;

  $message = "We would like to inform you that our  company will be having new forth coming  attraction and it will end on ".$valid_date.". Contact :".$app_contact_no."<br><p><strong>Title : ".$title."</strong>ewqewqeqweqweqwe</p><br>
      <p><strong>Valid Date : ".$description."</strong></p><br>
      <p><strong>Description : ".$valid_date."</strong></p><br>";
  global $model;

  $model->send_message($contact, $message);
}
	
}
?>