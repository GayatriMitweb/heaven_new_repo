<?php 

class passenger_csv_save{

public function passenger_csv_save1()
{
    $cust_csv_dir = $_POST['cust_csv_dir'];
    $pass_info_arr = array();

    $flag = true;

    $cust_csv_dir = explode('uploads', $cust_csv_dir);
    $cust_csv_dir = BASE_URL.'uploads'.$cust_csv_dir[1];

    begin_t();

    $count = 1;
    $unprocessedArray=array();
    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {       

      $sq = mysql_query("select max(traveler_group_id) as max from travelers_details");
      $value = mysql_fetch_assoc($sq);
      $max_traveler_group_id = $value['max']+1;

        while(($data = fgetcsv($handle, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }

            if($count>0){
                
            $sq = mysql_query("select max(traveler_id) as max from travelers_details");
            $value = mysql_fetch_assoc($sq);
            $max_traveler_id = $value['max'] + 1;

                $arr = array(
                'm_honorific' => $data[0],
                'm_first_name' => $data[1],
                'm_middle_name' => $data[2],
                'm_last_name' => $data[3],
                'm_gender' => $data[4],
                'm_birth_date1' => $data[5],
                'm_age' => $data[6],
                'm_adolescence' => $data[7],
                'm_passport_no' => $data[8],
                'm_passport_issue_date1' => $data[9],
                'm_passport_expiry_date1'  => $data[10]
                );
                 
                array_push($pass_info_arr, $arr);       
			        
            }  
            $count++;
        }
       
        fclose($handle);
    }
echo json_encode($pass_info_arr);

}

}
?>