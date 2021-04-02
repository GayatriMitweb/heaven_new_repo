<?php 
class visa_master{

///////////// Employee Save///////////////////////
 public function visa_master_save()
 { 	
   $visa_country_name=$_POST['visa_country_name'];
   $visa_type=$_POST['visa_type'];
   $fees=$_POST['fees'];
   $markup=$_POST['markup'];
   $time_taken=mysql_real_escape_string($_POST['time_taken']);
   $photo_upload_url = $_POST['photo_upload_url'];
   $photo_upload_url2 = $_POST['photo_upload_url2'];
   $doc_list=mysql_real_escape_string($_POST['doc_list']);

  //Transaction start
  begin_t();
  $sq_count = mysql_fetch_assoc(mysql_query("select entry_id from visa_crm_master where country_id='$visa_country_name' and visa_type='$visa_type'"));
  if($sq_count > 0){
    rollback_t();
    echo "error--Visa Information already added for this type!";
    exit;
  }

 	$row=mysql_query("select max(entry_id) as max from visa_crm_master");
 	$value=mysql_fetch_assoc($row);
 	$max=$value['max']+1;
  
 	$sq = mysql_query("insert into visa_crm_master (entry_id, country_id, visa_type, fees, markup, time_taken, upload_url,upload_url2, list_of_documents) values ('$max', '$visa_country_name', '$visa_type', '$fees', '$markup', '$time_taken', '$photo_upload_url', '$photo_upload_url2','$doc_list')");

 	if($sq){
    echo "Visa has been successfully saved.";
    commit_t();
 	}
 	else{
    rollback_t();
 		echo "error--Visa Information not saved !";
    exit;
   }
}



 ///////////// Employee Update////////////////////////////////////////////////////////////////////////////////////////

 public function visa_master_update()

 {  

   $entry_id=$_POST['entry_id'];

   $visa_country_name=$_POST['visa_country_name'];

   $visa_type=$_POST['visa_type'];

   $fees=$_POST['fees'];

   $markup=$_POST['markup'];

   $time_taken=mysql_real_escape_string($_POST['time_taken']);

   $photo_upload_url = $_POST['photo_upload_url'];
   $photo_upload_url2 = $_POST['photo_upload_url2'];

   $doc_list=mysql_real_escape_string($_POST['doc_list']);



  //Transaction start

  begin_t();
  $sq_count = mysql_fetch_assoc(mysql_query("select entry_id from visa_crm_master where country_id='$visa_country_name' and visa_type='$visa_type' and entry_id!='$entry_id'"));
  if($sq_count > 0){
    rollback_t();
    echo "error--Visa Information already added for this type!";
    exit;
  }

  $sq = mysql_query("update visa_crm_master set country_id='$visa_country_name',visa_type='$visa_type',fees='$fees',markup='$markup',time_taken='$time_taken',upload_url='$photo_upload_url',upload_url2='$photo_upload_url2',list_of_documents='$doc_list' where entry_id='$entry_id'");

  if($sq){

    echo "Visa has been successfully updated.";

    commit_t();

  } 

  else

  {

    rollback_t();

    echo "Visa Information not updated !";

    exit;

  }     



 }



public function visa_master_send()
{
  global $app_email_id, $app_name, $app_contact_no, $admin_logo_url, $app_website,$model;
  $entry_id=$_POST['entry_id'];
  $email_id=$_POST['email_id'];
  $sq_visa = mysql_fetch_assoc(mysql_query("select * from visa_crm_master where entry_id='$entry_id'"));

  $email_id_arr = explode(',',$email_id);
    for($i=0;$i<sizeof($email_id_arr);$i++){
    //////////////////////////////////////////Send Mail as attachment start//////////////////////////////////////////////////////////////////
    $arrayAttachment=array();
    $fileUploadForm=$sq_visa['upload_url'];
    $newDir= explode('..',$fileUploadForm);
    $newDir1= preg_replace('/(\/+)/','/',$newDir[2]);
    $newDir2=substr($newDir1, 1); 
    $UploadURL=$newDir2;

    $fileCover=$sq_visa['upload_url2'];
    $getMain= explode('..',$fileCover);
    $getSub= preg_replace('/(\/+)/','/',$getMain[2]);
    $CoverURL=substr($getSub, 1);
    array_push($arrayAttachment, $UploadURL,$CoverURL);
    ///////////////////////////////////////////Send Mail as attachment End////////////////////////////////////////////////////////////////

    $content = '
          <tr>
              <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Country Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_visa['country_id'].'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Visa Type</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$sq_visa['visa_type'].'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Total Amount</td>   <td style="text-align:left;border: 1px solid #888888;">'.number_format($sq_visa['fees']+$sq_visa['markup'],2).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Time Taken</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_visa['time_taken'].'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">List of documents</td>   <td style="text-align:left;border: 1px solid #888888;">'.$sq_visa['list_of_documents'].'</td></tr>
              </table>
          </tr>

    ';

    $subject = 'Visa Enquiry Details : ('.$sq_visa['country_id'].' , '.$sq_visa['visa_type'].' )';
    $model->new_app_email_send('12',$email_id_arr[$i],$subject,$arrayAttachment, $content,'1');
    }
  echo "Mail sent successfully!";
}

function visa_typemaster_save()
{
    $visa_type=$_POST['visa_type'];
    $visa_type = ltrim($visa_type);
    $sq_count = mysql_fetch_assoc(mysql_query("select visa_type_id from visa_type_master where visa_type='$visa_type'"));
    if($sq_count > 0){
      rollback_t();
      echo "error--Visa Type already exists!";
      exit;
    }
    $row=mysql_query("select max(visa_type_id) as max from visa_type_master");
    $value=mysql_fetch_assoc($row);
    $max=$value['max']+1;
    
    $sq = mysql_query("insert into visa_type_master (visa_type_id, visa_type) values ('$max', '$visa_type')");

    if($sq){
      echo "Visa Type added.";
      commit_t();
    } 

    else
    {
      rollback_t();
      echo "Visa Type not added !";
      exit;
    } 
}

}

?>