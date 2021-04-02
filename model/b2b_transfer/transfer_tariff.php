<?php
class transfer_tariff{

    function vehicle_save(){
        $vehicle_type = $_POST['vehicle_type'];
        $vehicle_name = addslashes($_POST['vehicle_name']);
        $vehicle_data = json_decode($_POST['vehicle_array']);
        $canc_policy = $_POST['canc_policy'];

        $sq_count = mysql_num_rows(mysql_query("select entry_id from b2b_transfer_master where vehicle_name='$vehicle_name' and vehicle_type='$vehicle_type'"));
        if($sq_count > 0){
            echo 'error--Vehicle name already added';
            exit;
        }

        $seating_capacity = $vehicle_data[0]->seating_capacity;
        $image = $vehicle_data[0]->image;
        $sq_max = mysql_fetch_assoc(mysql_query("select max(entry_id) as max from b2b_transfer_master"));
        $entry_id = $sq_max['max'] + 1;
        $sq_query = mysql_query("INSERT INTO `b2b_transfer_master`(`entry_id`,`vehicle_type`,`vehicle_name`, `seating_capacity`,`image_url`, `cancellation_policy`, `status`) VALUES ('$entry_id','$vehicle_type','$vehicle_name','$seating_capacity','$image','$canc_policy','Active')");
        if($sq_query){
            echo 'Vehicle Details added succesfully';
            exit;
        }else{
            echo 'error--Vehicle Details not added succesfully';
            exit;
        }

    }
    function vehicle_update(){
        $vehicle_type = $_POST['vehicle_type'];
        $entry_id = $_POST['entry_id'];
        $vehicle_name = addslashes($_POST['vehicle_name']);
        $vehicle_data = json_decode($_POST['vehicle_array']);
        $canc_policy = $_POST['canc_policy'];
        $active_flag = $_POST['active_flag'];

        $sq_count = mysql_num_rows(mysql_query("select entry_id from b2b_transfer_master where vehicle_name='$vehicle_name' and vehicle_type='$vehicle_type' and entry_id!='$entry_id'"));
        if($sq_count > 0){
            echo 'error--Vehicle name already added';
            exit;
        }
        $seating_capacity = $vehicle_data[0]->seating_capacity;
        $image = $vehicle_data[0]->image;
        $sq_query = mysql_query("update b2b_transfer_master set `vehicle_type`='$vehicle_type',`vehicle_name`='$vehicle_name',`seating_capacity`='$seating_capacity',`image_url`='$image',`cancellation_policy`='$canc_policy', `status`='$active_flag' where entry_id='$entry_id' ");
        if($sq_query){
            echo 'Vehicle Details updated succesfully';
            exit;
        }else{
            echo 'error--Vehicle Details not updated succesfully';
            exit;
        }

    }
    function tariff_save(){
        $vehicle_id = $_POST['vehicle_id'];
        $currency_id = $_POST['currency_id'];
        $taxation = $_POST['taxation'];

        $pickup_type_array = $_POST['pickup_type_array'];
        $pickup_from_array = $_POST['pickup_from_array'];
        $drop_type_array = $_POST['drop_type_array'];
        $drop_to_array = $_POST['drop_to_array'];
        $duration_array = $_POST['duration_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];

        $capacity_array = $_POST['capacity_array'];
        $total_cost_array = $_POST['total_cost_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_amount_array = $_POST['markup_amount_array'];
        $created_at = date('Y-m-d');

        $sq_max = mysql_fetch_assoc(mysql_query("select max(tariff_id) as max from b2b_transfer_tariff"));
        $tariff_id = $sq_max['max'] + 1;
        $sq_query = mysql_query("INSERT INTO `b2b_transfer_tariff`(`tariff_id`,`vehicle_id`, `currency_id`, `taxation`,`created_at`) VALUES ('$tariff_id','$vehicle_id','$currency_id','$taxation','$created_at')");
        if($sq_query){

            for($i=0;$i<sizeof($pickup_type_array);$i++){
                $from_date_array[$i] = get_date_db($from_date_array[$i]);
                $to_date_array[$i] = get_date_db($to_date_array[$i]);
                $duration_array[$i] = addslashes($duration_array[$i]);
                $tariff_data_array = array(
                    array('seating_capacity' => $capacity_array[$i],
                    'total_cost' => $total_cost_array[$i],
                    'markup_in' => $markup_in_array[$i],
                    'markup_amount' => $markup_amount_array[$i])
                );
                $tariff_data_array = json_encode($tariff_data_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                $sq_max1 = mysql_fetch_assoc(mysql_query("select max(tariff_entries_id) as max from b2b_transfer_tariff_entries"));
                $tariff_entries_id = $sq_max1['max'] + 1;
        
                $sq_query1 = mysql_query("INSERT INTO `b2b_transfer_tariff_entries`(`tariff_entries_id`, `tariff_id`, `pickup_type`, `pickup_location`, `drop_type`, `drop_location`, `service_duration`, `from_date`, `to_date`, `tariff_data`) VALUES ('$tariff_entries_id','$tariff_id','$pickup_type_array[$i]','$pickup_from_array[$i]','$drop_type_array[$i]','$drop_to_array[$i]','$duration_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$tariff_data_array')");
            }
            echo 'Tariff Details added succesfully';
            exit;
        }
        else{
            echo 'error--Tariff Details not added succesfully';
            exit;
        }

    }
    
    function tariff_update(){
        $tariff_id = $_POST['tariff_id']; 
        $vehicle_id = $_POST['vehicle_id'];
        $currency_id = $_POST['currency_id'];
        $taxation = $_POST['taxation'];

        $pickup_type_array = $_POST['pickup_type_array'];
        $pickup_from_array = $_POST['pickup_from_array'];
        $drop_type_array = $_POST['drop_type_array'];
        $drop_to_array = $_POST['drop_to_array'];
        $duration_array = $_POST['duration_array'];
        $from_date_array = $_POST['from_date_array'];
        $to_date_array = $_POST['to_date_array'];
        $entry_id_array = $_POST['entry_id_array'];
        $checked_id_array = $_POST['checked_id_array'];

        $capacity_array = $_POST['capacity_array'];
        $total_cost_array = $_POST['total_cost_array'];
        $markup_in_array = $_POST['markup_in_array'];
        $markup_amount_array = $_POST['markup_amount_array'];
        $created_at = date('Y-m-d');

        $sq_query = mysql_query("Update `b2b_transfer_tariff` set `vehicle_id`='$vehicle_id', `currency_id`='$currency_id', `taxation`='$taxation' where tariff_id='$tariff_id'");
        if($sq_query){

            for($i=0;$i<sizeof($pickup_type_array);$i++){
                $from_date_array[$i] = get_date_db($from_date_array[$i]);
                $to_date_array[$i] = get_date_db($to_date_array[$i]);
                $duration_array[$i] = addslashes($duration_array[$i]);
                $tariff_data_array = array(
                    array('seating_capacity' => $capacity_array[$i],
                    'total_cost' => $total_cost_array[$i],
                    'markup_in' => $markup_in_array[$i],
                    'markup_amount' => $markup_amount_array[$i])
                );
                $tariff_data_array = json_encode($tariff_data_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
                if($checked_id_array[$i] == 'true'){
                    if($entry_id_array[$i] == ''){
                        $sq_max1 = mysql_fetch_assoc(mysql_query("select max(tariff_entries_id) as max from b2b_transfer_tariff_entries"));
                        $tariff_entries_id = $sq_max1['max'] + 1;
                
                        $sq_query1 = mysql_query("INSERT INTO `b2b_transfer_tariff_entries`(`tariff_entries_id`, `tariff_id`, `pickup_type`, `pickup_location`, `drop_type`, `drop_location`, `service_duration`, `from_date`, `to_date`, `tariff_data`) VALUES ('$tariff_entries_id','$tariff_id','$pickup_type_array[$i]','$pickup_from_array[$i]','$drop_type_array[$i]','$drop_to_array[$i]','$duration_array[$i]','$from_date_array[$i]','$to_date_array[$i]','$tariff_data_array')");
                    }else{
                        $sq_query1 = mysql_query("UPDATE `b2b_transfer_tariff_entries` SET `pickup_type`='$pickup_type_array[$i]',`pickup_location`='$pickup_from_array[$i]',`drop_type`='$drop_type_array[$i]',`drop_location`='$drop_to_array[$i]',`service_duration`='$duration_array[$i]',`from_date`='$from_date_array[$i]',`to_date`='$to_date_array[$i]',`tariff_data`='$tariff_data_array' WHERE tariff_entries_id='$entry_id_array[$i]'");
                    }
                }else{
                    $sq_query1 = mysql_query("DELETE FROM `b2b_transfer_tariff_entries` WHERE `tariff_entries_id`='$entry_id_array[$i]'");
                }
            }
            echo 'Tariff Details updated succesfully';
            exit;
        }
        else{
            echo 'error--Tariff Details not updated succesfully';
            exit;
        }

    }
    function tariff_csv_save(){
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

                    // Pickup
                    if($data[0] == 'city'){
                        $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$data[1]'"));
                        $pickup_id = $row['city_id'];
                        $pickup = $row['city_name'];
                    }
                    else if($data[0] == 'hotel'){
                        $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$data[1]'"));
                        $pickup_id = $row['hotel_id'];
                        $pickup = $row['hotel_name'];
                    }
                    else{
                        $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$data[1]'"));
                        $airport_nam = clean($row['airport_name']);
                        $airport_code = clean($row['airport_code']);
                        $pickup_id = $row['airport_id'];
                        $pickup = $airport_nam." (".$airport_code.")";
                    }
                    //Drop-off
                    if($data[2] == 'city'){
                        $row = mysql_fetch_assoc(mysql_query("select city_id,city_name from city_master where city_id='$data[3]'"));
                        $drop_id = $row['city_id'];
                        $drop = $row['city_name'];
                    }
                    else if($data[2] == 'hotel'){
                        $row = mysql_fetch_assoc(mysql_query("select hotel_id,hotel_name from hotel_master where hotel_id='$data[3]'"));
                        $drop_id = $row['hotel_id'];
                        $drop = $row['hotel_name'];
                    }
                    else{
                        $row = mysql_fetch_assoc(mysql_query("select airport_name, airport_code, airport_id from airport_master where airport_id='$data[3]'"));
                        $airport_nam = clean($row['airport_name']);
                        $airport_code = clean($row['airport_code']);
                        $drop_id = $row['airport_id'];
                        $drop = $airport_nam." (".$airport_code.")";
                    }

                    $arr = array(
                        'pickup_type' => $data[0],
                        'pickup_location' => $pickup,
                        'drop_type' => $data[2],
                        'drop_location' => $drop,
                        'duration' => $data[4],
                        'from_date' => $data[5],
                        'to_date' => $data[6],
                        'luggage' => $data[7],
                        'total_cost' => $data[8],
                        'markup_in'  => $data[9],
                        'markup_amount' => $data[10],
                        'pickup_id' => $pickup_id,
                        'drop_id' => $drop_id
                    );
                    array_push($pass_info_arr, $arr); 
                }
                $count++;    
            }
            fclose($handle);
        }
        echo json_encode($pass_info_arr);
    }
    function service_time_save(){
        $time_array = json_encode($_POST['time_array']);
        $sq_update = mysql_query("update app_settings set transfer_service_time='$time_array' where setting_id='1'");
        if($sq_update){
            echo 'Service Timing saved successfully!';
            exit;
        }
        else{
            echo 'error--Service Timing not saved succesfully';
            exit;
        }

    }
}
?>