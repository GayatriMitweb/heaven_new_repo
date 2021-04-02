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

    $arrResult  = array();
    $handle = fopen($cust_csv_dir, "r");
    if(empty($handle) === false) {

        while(($data = fgetcsv($handle, ",")) !== FALSE){
            if($count == 1) { $count++; continue; }
            if($count>0){                
            $arr = array(
                'm_first_name' => $data[0],
                'm_middle_name' => $data[1],
                'm_last_name' => $data[2],
                'm_birth_date1' => $data[3],
                'm_adolescence' => $data[4],
                'ticket_no' => $data[5],
                'gds_pnr' => $data[6],
                'baggage_info' => $data[7], 
                'main_ticket' => $data[8]
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