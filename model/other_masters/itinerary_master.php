<?php
class itinerary_master{

    public function csv_save()
    {
        $itinerary_csv_dir = $_POST['itinerary_csv_dir'];
        $itinerary_arr = array();
        $flag = true;

        $itinerary_csv_dir = explode('uploads', $itinerary_csv_dir);
        $itinerary_csv_dir = BASE_URL.'uploads'.$itinerary_csv_dir[1];

        begin_t();
        $count = 1;
        $arrResult  = array();
        $handle = fopen($itinerary_csv_dir, "r");
        if(empty($handle) === false) {       

            while(($data = fgetcsv($handle, ",")) !== FALSE){
                if($count == 1) { $count++; continue; }
                if($count>0){
                    $spa = str_replace('"',"'",$data[1]);
                    $dwp = str_replace('"',"'",$data[2]);
                    $os = str_replace('"',"'",$data[3]);
                    $arr = array(
                        "spa" => addslashes($spa),
                        "dwp" => addslashes($dwp),
                        "os" => addslashes($os)
                    );
                    array_push($itinerary_arr, $arr);
                }
                $count++;
            }
            fclose($handle);
        }
        $itinerary_arr = json_encode($itinerary_arr,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $itinerary_arr = ($itinerary_arr != '') ? $itinerary_arr : json_encode(array());
        echo "<input type='hidden' value='$itinerary_arr' id='itinerary_arr' name='itinerary_arr'/>";
    }
    function itinerary_save(){

        $dest_id = $_POST['dest_id'];
        $sp_arr = $_POST['sp_arr'];
        $dwp_arr = $_POST['dwp_arr'];
        $os_arr = $_POST['os_arr'];
        
        $sq_repc = mysql_num_rows(mysql_query("select dest_id from itinerary_master where dest_id='$dest_id'"));
        if($sq_repc > 0 ){
            echo "error--Itinerary already added for this destination.Please update the same!";
        }
        else{
            for($i=0; $i<sizeof($dwp_arr); $i++){

                $sp_arr1 = addslashes($sp_arr[$i]);
                $dwp_arr1 = addslashes($dwp_arr[$i]);
                $os_arr1 = addslashes($os_arr[$i]);
                $sq = mysql_query("select max(entry_id) as max from itinerary_master");
                $value = mysql_fetch_assoc($sq);
                $entry_id = $value['max'] + 1;

                $sq1 = mysql_query("insert into itinerary_master(`entry_id`, `dest_id`, `special_attraction`, `daywise_program`, `overnight_stay`)values('$entry_id','$dest_id','$sp_arr1', '$dwp_arr1', '$os_arr1')");
                if(!$sq1){
                    $GLOBALS['flag'] = false;
                    echo "error--Error in Itinerary at row ".$i+1;
                }
            }
            echo "Itinerary saved successfully!";
        }
    }
    function itinerary_update(){

        $dest_id = $_POST['dest_id'];
        $sp_arr = $_POST['sp_arr'];
        $dwp_arr = $_POST['dwp_arr'];
        $os_arr = $_POST['os_arr'];
        $checked_arr = $_POST['checked_arr'];
        $entry_id_arr = $_POST['entry_id_arr'];

        for($i=0; $i<sizeof($dwp_arr); $i++){

            if($checked_arr[$i] != 'true'){
                $sq_exc = mysql_query("delete from itinerary_master where entry_id='$entry_id_arr[$i]'");
				if(!$sq_exc){
					echo "error--Itinerary information not deleted!";
					exit;
				}
            }
            else{
                $sp_arr1 = addslashes($sp_arr[$i]);
                $dwp_arr1 = addslashes($dwp_arr[$i]);
                $os_arr1 = addslashes($os_arr[$i]);
                if($entry_id_arr[$i]==""){

                    $sq = mysql_query("select max(entry_id) as max from itinerary_master");
                    $value = mysql_fetch_assoc($sq);
                    $entry_id = $value['max'] + 1;
                    $sq1 = mysql_query("insert into itinerary_master(`entry_id`, `dest_id`, `special_attraction`, `daywise_program`, `overnight_stay`)values('$entry_id','$dest_id','$sp_arr1', '$dwp_arr1', '$os_arr1')");
                }
                else{

					$sq1 = mysql_query("update itinerary_master set `special_attraction`='$sp_arr1', `daywise_program`='$dwp_arr1', `overnight_stay`='$os_arr1' where entry_id='$entry_id_arr[$i]'");
                }
                if(!$sq1){
                    $GLOBALS['flag'] = false;
                    echo "error--Error in Itinerary at row ".$i+1;
                }
            }
        }
        echo "Itinerary updated successfully!";
        
    }
}
?>