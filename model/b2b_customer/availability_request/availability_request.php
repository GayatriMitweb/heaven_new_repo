<?php
class b2b_request{
    function availability_request(){
        $hotel_list_arr = json_encode($_POST['hotel_list_arr'],JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        $register_id = $_POST['register_id'];
        $unique_timestamp = $_POST['unique_timestamp'];
        $date = date('Y-m-d H:i');

        $sq_timestamp = mysql_num_rows(mysql_query("select request_id from hotel_availability_request where unique_timestamp='$unique_timestamp'"));
        if($sq_timestamp == 0){

            $sq_reg = mysql_fetch_assoc(mysql_query("select company_name,cp_first_name,cp_last_name,mobile_no,email_id from b2b_registration where register_id='$register_id'"));
            $guest_name = $sq_reg['cp_first_name'].' '.$sq_reg['cp_last_name'];

            $sq_max = mysql_fetch_assoc(mysql_query("select max(request_id) as max from hotel_availability_request"));
            $request_id = $sq_max['max'] + 1;
            $sq_request = mysql_query("insert into hotel_availability_request (request_id,register_id,cust_name,concern_person,mobile_no,email_id,cart_data,status,created_at,unique_timestamp) values ('$request_id','$register_id','$sq_reg[company_name]','$guest_name','$sq_reg[mobile_no]','$sq_reg[email_id]','$hotel_list_arr','false','$date','$unique_timestamp')");

            if($sq_request){
                $this->request_mail_toAdmin($request_id,$sq_reg['company_name'],$hotel_list_arr);
                $sq_regupdate = mysql_query("update b2b_registration set request_id='$request_id' where register_id='$register_id'");
                echo 'Your Hotel availability request successfully received and our team will revert you shortly!';
            }else{
                echo 'error--Not done with checking availability!';
            }
        }
        else{
            echo 'error--Your Hotel availability request sent!';
        }
    }

    function response_save(){

        $request_id = $_POST['request_id'];
        $response_arr = json_encode($_POST['response_arr']);

        $sq_res = mysql_query("update hotel_availability_request set response='$response_arr' where request_id='$request_id'");
        if($sq_res){
            echo 'Response saved successfully!';
        }else{
            echo 'error--Response not saved successfully!';
        }
    }

    function request_delete(){
        $request_id = $_POST['request_id'];

        $sq_delete = mysql_query("update hotel_availability_request set active_status='disabled' where request_id='$request_id'");
        if($sq_delete){
            echo 'Request has been deleted successfully';
            exit;
        }else{
            echo 'error--Request has not been deleted!';
            exit;
        }
    }

    function request_mail_toAdmin($request_id,$company_name,$cart_data){
        global $model,$app_email_id,$theme_color;
        $content = '';
        $cart_data = json_decode($cart_data);
        for($i=0;$i<sizeof($cart_data);$i++){
            //Total Guest
            $adults_count = 0;
            $child_count = 0;
            $final_rooms_arr = $cart_data[$i]->final_arr;
            for ($n = 0; $n < sizeof($final_rooms_arr); $n++) {
              $adults_count = ($adults_count) + ($final_rooms_arr[$n]->rooms->adults);
              $child_count = ($child_count) + ($final_rooms_arr[$n]->rooms->child);
            }
            //Hotel and City
            $city_id = $cart_data[$i]->city_id;
            $hotel_id = $cart_data[$i]->id;
            $sq_hotel = mysql_fetch_assoc(mysql_query("select city_id,mobile_no,email_id from hotel_master where hotel_id='$hotel_id'"));
            if($city_id != ''){
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$city_id'"));
            }else{
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
            }
            $content .= '
            <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.urldecode($cart_data[$i]->hotel_name).'('.$sq_city['city_name'].')'.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckIn Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.date('d-m-Y', strtotime($cart_data[$i]->check_in)).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckOut Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($cart_data[$i]->check_out)).'</td></tr>';
                
                for($j=0;$j<sizeof($cart_data[$i]->item_arr);$j++){
                    $room_types = explode('-',$cart_data[$i]->item_arr[$j]);
                    $content .= '
                    <tr><td style="text-align:left;border: 1px solid #888888;"> '.$room_types[0].'</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$room_types[1].'</td></tr>
                    ';
                }
                    $content .= '
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;" >'.'Adult: '.$adults_count.'    Children: '.$child_count.'</td></tr>
                    </table>
            </tr>';
        }

        $content .= '
            <tr>
                <td>
                <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                    <tr>
                        <td colspan="2">
                        <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:120px;text-align:center" href="'.BASE_URL.'index.php" target="_blank">Login</a>
                        </td>
                    </tr> 
                </table>
                </td>
            </tr>
        ';

        $subject = "New Hotel Availability Request: ".$company_name."(Request ID: ".$request_id.")";
        $model->app_email_send('116','Admin',$app_email_id, $content,$subject,'1');

    }
    
    function request_mail_toSupplier(){
        global $theme_color,$model,$app_name,$app_email_id,$encrypt_decrypt,$secret_key;
        $request_id = $_POST['request_id'];
        $register_id = $_POST['register_id'];
        $hotel_id_arr = array();
        
        $request_no = base64_encode($request_id);
    
        $sq_req = mysql_fetch_assoc(mysql_query("select cart_data from hotel_availability_request where request_id='$request_id'"));
        $cart_data = json_decode($sq_req['cart_data']);
        // print_r($cart_data);
        for($i=0;$i<sizeof($cart_data);$i++){
            array_push($hotel_id_arr,$cart_data[$i]->id);
        }
        for($i=0;$i<sizeof($cart_data);$i++){
            $content = '';
            //Total Guest
            $adults_count = 0;
            $child_count = 0;
            $final_rooms_arr = $cart_data[$i]->final_arr;
            for ($n = 0; $n < sizeof($final_rooms_arr); $n++) {
                $adults_count = ($adults_count) + ($final_rooms_arr[$n]->rooms->adults);
                $child_count = ($child_count) + ($final_rooms_arr[$n]->rooms->child);
            }
            //Hotel and City
            $city_id = $cart_data[$i]->city_id;
            $hotel_id = $cart_data[$i]->id;
            
            $hotel_no = base64_encode($hotel_id);

            $sq_hotel = mysql_fetch_assoc(mysql_query("select city_id,mobile_no,email_id,alternative_email_1,alternative_email_2 from hotel_master where hotel_id='$hotel_id'"));
            $email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);
            $email_id1 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_1'], $secret_key);
            $email_id2 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_2'], $secret_key);

            

            if($city_id != ''){
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$city_id'"));
            }else{
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
            }
            if($hotel_id_arr[$i] == $hotel_id){
            $content .= '
            <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.urldecode($cart_data[$i]->hotel_name).'('.$sq_city['city_name'].')'.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckIn Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.date('d-m-Y', strtotime($cart_data[$i]->check_in)).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckOut Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($cart_data[$i]->check_out)).'</td></tr>';
                
                for($j=0;$j<sizeof($cart_data[$i]->item_arr);$j++){
                    $room_types = explode('-',$cart_data[$i]->item_arr[$j]);
                    $content .= '
                    <tr><td style="text-align:left;border: 1px solid #888888;"> '.$room_types[0].'</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$room_types[1].'</td></tr>
                    ';
                }
                    $content .= '
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;" >'.'Adult: '.$adults_count.'    Children: '.$child_count.'</td></tr>
                    </table>
            </tr>';
            }
            $content .= '
            <tr>
                <td>
                <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                    <tr>
                        <td colspan="2">
                        <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:120px;text-align:center" href="'.BASE_URL.'view/b2b_customer/availability_request/supplier_response.php?request_id='.$request_no.'&hotel_id='.$hotel_no.'" target="_blank">Check Availability</a>
                        </td>
                    </tr> 
                </table>
                </td>
            </tr>
            ';
            $subject = "Hotel Availability Check Request: ".$app_name."(Request ID: ".$request_id.")";
            $model->app_email_send('117',urldecode($cart_data[$i]->hotel_name),$email_id, $content,$subject,'1');
            $model->app_email_send('117',urldecode($cart_data[$i]->hotel_name),$email_id1, $content,$subject,'1');
            $model->app_email_send('117',urldecode($cart_data[$i]->hotel_name),$email_id2, $content,$subject,'1');
        }
        echo 'Request mail to suppliers sent successfully!';
        $sq_reqq = mysql_fetch_assoc(mysql_query("update hotel_availability_request set supplier_mail='1' where request_id='$request_id'"));
    }

    function response_mail_toAgent(){
        global $theme_color,$model,$app_name,$app_email_id,$encrypt_decrypt,$secret_key;
        $request_id = $_POST['request_id'];
        $register_id = $_POST['register_id'];
        
        $sq_avail = mysql_fetch_assoc(mysql_query("select cart_data,response from hotel_availability_request where request_id='$request_id'"));
        $cart_data = json_decode($sq_avail['cart_data']);
        $response = json_decode($sq_avail['response']);
        if(sizeof($cart_data) == sizeof($response)){

            $sq_reg = mysql_fetch_assoc(mysql_query("select company_name,cp_first_name,cp_last_name,mobile_no,email_id from b2b_registration where register_id='$register_id'"));

            $content = '';
            for($i=0;$i<sizeof($cart_data);$i++){
                //Total Guest
                $adults_count = 0;
                $child_count = 0;
                $final_rooms_arr = $cart_data[$i]->final_arr;
                for ($n = 0; $n < sizeof($final_rooms_arr); $n++) {
                $adults_count = ($adults_count) + ($final_rooms_arr[$n]->rooms->adults);
                $child_count = ($child_count) + ($final_rooms_arr[$n]->rooms->child);
                }
                //Hotel and City
                $city_id = $cart_data[$i]->city_id;
                $hotel_id = $cart_data[$i]->id;
                $sq_hotel = mysql_fetch_assoc(mysql_query("select city_id,mobile_no,email_id from hotel_master where hotel_id='$hotel_id'"));
                if($city_id != ''){
                    $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$city_id'"));
                }else{
                    $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
                }
                
                    $item = null;
                    foreach($response as $struct) {
                        if ($hotel_id == $struct->id) {
                            $item = $struct;
                            break;
                        }
                    }
                    $content .= '
                    <tr>
                        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.urldecode($cart_data[$i]->hotel_name).'('.$sq_city['city_name'].')'.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Status</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$item->status.'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> CheckIn Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.date('d-m-Y', strtotime($cart_data[$i]->check_in)).'</td></tr>
                        <tr><td style="text-align:left;border: 1px solid #888888;"> CheckOut Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($cart_data[$i]->check_out)).'</td></tr>';

                        for($j=0;$j<sizeof($cart_data[$i]->item_arr);$j++){
                            $room_types = explode('-',$cart_data[$i]->item_arr[$j]);
                            $content .= '
                            <tr><td style="text-align:left;border: 1px solid #888888;"> '.$room_types[0].'</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$room_types[1].'</td></tr>
                            ';
                        }
                        $content .= '
                            <tr><td style="text-align:left;border: 1px solid #888888;"> Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;" >'.'Adult: '.$adults_count.'    Children: '.$child_count.'</td></tr>';

                        if($item->status=='Not Available' && sizeof($item->options)!=0){
    
                            $content .= '<tr><td colspan="2" style="text-align:left;border: 1px solid #888888;"> Similar Hotel Options Available...</td></tr>';
                            for($hi=0;$hi<sizeof($item->options);$hi++){
                                $option_hotel_id = $item->options[$hi];
                                $sq_ophotel = mysql_fetch_assoc(mysql_query("select hotel_name,hotel_id,city_id from hotel_master where hotel_id='$option_hotel_id'"));
                                $sq_opcity = mysql_fetch_assoc(mysql_query("select city_name,city_id from city_master where city_id='$sq_ophotel[city_id]'"));
                                $content .= '
                                    <tr><td style="text-align:left;border: 1px solid #888888;"> Hotel '.($hi+1).'</td> <td style="text-align:left;border: 1px solid #888888;" >'.$sq_ophotel['hotel_name'].' ('.$sq_opcity['city_name'].')'.'</td></tr>';
                            }
                        }

                        $content .= ' </table>
                </tr>';
            }

            $content .= '
                <tr>
                    <td>
                    <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                        <tr>
                            <td colspan="2">
                            <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:120px;text-align:center" href="'.BASE_URL.'Tours_B2B/login.php" target="_blank">Login</a>
                            </td>
                        </tr> 
                    </table>
                    </td>
                </tr>
            ';

            $subject = "Status : Hotel Availability: ".$app_name."(Request ID: ".$request_id.")";
            $model->app_email_send('118',$sq_reg['cp_first_name'].' '.$sq_reg['cp_last_name'],$sq_reg['email_id'], $content,$subject,'1');
            echo 'Response Mail to '.$sq_reg['company_name'].' sent successfully!';
        }else{
            echo 'error--Please proceed once received availability confirmation of all hotels.';
        }

    }
    function supplier_response_save(){
        $request_id = $_POST['request_id'];
        $response_arr = json_encode($_POST['response_arr']);
        $response = json_encode($_POST['aresponse']);
        $response_received = json_encode($_POST['response_received']);

        $sq_res = mysql_query("update hotel_availability_request set response='$response_arr',response_received='$response_received' where request_id='$request_id'");
        if($sq_res){
            $this->supplier_response_toAdmin($request_id,$response);
            echo 'Response saved successfully.Thank you!';
        }else{
            echo 'error--Response not saved successfully!';
        }
    }

    function supplier_response_toAdmin($request_id,$response_arr){
        global $model,$app_email_id,$theme_color;
        $hotel_id = $_POST['hotel_id'];
        $response = json_decode($response_arr);
        $hotel_id_arr = array();

        $sq_avail = mysql_fetch_assoc(mysql_query("select cart_data,response,register_id from hotel_availability_request where request_id='$request_id'"));
        $cart_data = json_decode($sq_avail['cart_data']);
        for($i=0;$i<sizeof($cart_data);$i++){
            array_push($hotel_id_arr,$cart_data[$i]->id);
        }

        $sq_reg = mysql_fetch_assoc(mysql_query("select company_name from b2b_registration where register_id='$sq_avail[register_id]'"));
        $sq_hotel = mysql_fetch_assoc(mysql_query("select hotel_name from hotel_master where hotel_id='$hotel_id'"));

        for($i=0;$i<sizeof($cart_data);$i++){
            $content = '';
            //Total Guest
            $adults_count = 0;
            $child_count = 0;
            $final_rooms_arr = $cart_data[$i]->final_arr;
            for ($n = 0; $n < sizeof($final_rooms_arr); $n++) {
              $adults_count = ($adults_count) + ($final_rooms_arr[$n]->rooms->adults);
              $child_count = ($child_count) + ($final_rooms_arr[$n]->rooms->child);
            }
            //Hotel and City
            $city_id = $cart_data[$i]->city_id;
            $hotel_id = $cart_data[$i]->id;
            $sq_hotel = mysql_fetch_assoc(mysql_query("select city_id,mobile_no,email_id from hotel_master where hotel_id='$hotel_id'"));
            if($city_id != ''){
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$city_id'"));
            }else{
                $sq_city = mysql_fetch_assoc(mysql_query("select city_name from city_master where city_id='$sq_hotel[city_id]'"));
            }
            $note = ($response[0]->note!='') ? '('.$response[0]->note.')' : 'NA';
            $content .= '
            <tr>
                <td>
                <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                    <tr>
                        <td colspan="2">
                            '.$response[0]->status.''.$note.'</tr> 
                    </table>
                    </td>
                </tr>
            ';
            if($hotel_id_arr[$i] == $hotel_id){
            $content .= '
            <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.urldecode($cart_data[$i]->hotel_name).'('.$sq_city['city_name'].')'.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckIn Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.date('d-m-Y', strtotime($cart_data[$i]->check_in)).'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> CheckOut Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.date('d-m-Y', strtotime($cart_data[$i]->check_out)).'</td></tr>';
                
                for($j=0;$j<sizeof($cart_data[$i]->item_arr);$j++){
                    $room_types = explode('-',$cart_data[$i]->item_arr[$j]);
                    $content .= '
                    <tr><td style="text-align:left;border: 1px solid #888888;"> '.$room_types[0].'</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$room_types[1].'</td></tr>
                    ';
                }
                    $content .= '
                        <tr><td style="text-align:left;border: 1px solid #888888;"> Total Guest</td>   <td style="text-align:left;border: 1px solid #888888;" >'.'Adult: '.$adults_count.'    Children: '.$child_count.'</td></tr>
                    </table>
            </tr>';
            }
        }

        $content .= '
            <tr>
                <td>
                <table style="padding:0 30px; margin:0px auto; margin-top:10px">
                    <tr>
                        <td colspan="2">
                        <a style="font-weight:500;font-size:14px;display:block;color:#ffffff;background:'.$theme_color.';text-decoration:none;padding:5px 10px;border-radius:25px;width:120px;text-align:center" href="'.BASE_URL.'index.php" target="_blank">Login</a>
                        </td>
                    </tr> 
                </table>
                </td>
            </tr>
        ';
        $subject = "Status : Hotel Availability: ".$sq_hotel['hotel_name']."(Request ID: ".$request_id." & Agent: ".$sq_reg['company_name'].")";
        $model->app_email_send('119','Admin',$app_email_id, $content,$subject,'1');
    }
}
?>