<?php 
class sms{
///////////////////////***Enquiry Master Save start*********//////////////
    function send_sms(){

        $enquiry_id = $_POST['enquiry_id'];
        $draft = $_POST['draft'];
        $mobile_no = $_POST['mobile_no'];

          global $app_contact_no,$app_website,$app_name,$app_email_id;
          $message = strip_tags($draft);
          global $model;
         
          $model->send_message($mobile_no, $message);
      }
    

    }

?>