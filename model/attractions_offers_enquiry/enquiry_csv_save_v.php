<?php 
class enquiry_master{

///////////////////////***Enquiry Master Save start*********//////////////
function enquiry_master_save()
{

 $enq_csv_dir = $_POST['enq_csv_dir'];
    $flag = true;

    $enq_csv_dir = explode('uploads', $enq_csv_dir);
    $enq_csv_dir = BASE_URL.'uploads'.$enq_csv_dir[1];

    begin_t();

    $count = 1;

    $handle = fopen($enq_csv_dir, "r");
    if(empty($handle) === false) {

        while(($data1 = fgetcsv($handle, ",")) !== FALSE){
            if($count>0){
              
                $mobile_no1 = $data1[1];
                $email_id1 = $data1[3];

              $enquiry_count1 = mysql_num_rows(mysql_query("select * from enquiry_master where mobile_no='$mobile_no1' or email_id = '$email_id1'")); 
              
              if($enquiry_count1>0){
                echo "Sorry, mobile or email is already exists.";
              }
              else
              {
                echo "This enquiry is not exists.";
              }

}

    }
  }
}
}
?>