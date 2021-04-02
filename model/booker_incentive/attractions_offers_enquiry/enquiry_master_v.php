<?php 
class enquiry_master{

///////////////////////***Enquiry Master Save start*********//////////////
function enquiry_master_save()
{

  $mobile_no = $_POST["mobile_no"]; 
  $email_id = $_POST["email_id"]; 

  $enquiry_count = mysql_num_rows(mysql_query("select * from enquiry_master where mobile_no='$mobile_no' or email_id = '$email_id'")); 
  if($enquiry_count>0){
    echo "Sorry, mobile or email is already exists.";
  }
  else
  {
    echo "This enquiry is not exists.";
  }

}


}

?>