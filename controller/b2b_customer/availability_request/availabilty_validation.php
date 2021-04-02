<?php
include "../../../model/model.php";
$register_id = $_POST['register_id'];
$sq_reg = mysql_fetch_assoc(mysql_query("select request_id,cart_data from b2b_registration where register_id='$register_id'"));
$request_id = $sq_reg['request_id'];
$agent_cart_data = json_decode($sq_reg['cart_data']);

$sq_response = mysql_fetch_assoc(mysql_query("select cart_data, response from hotel_availability_request where request_id='$request_id'"));
$cart_data = json_decode($sq_response['cart_data']);
$response = json_decode($sq_response['response']);
$count = 0;

for($j=0;$j<sizeof($agent_cart_data);$j++){
  if($agent_cart_data[$j]->service->name == 'Hotel'){
    $count++;
    break;
  }
}

if($count>0){
    $sq_req_count = mysql_num_rows(mysql_query("select request_id from hotel_availability_request where request_id='$request_id'"));
    if($sq_req_count >=1 && $request_id != 0){

        if(sizeof($response) == sizeof($cart_data)){
            $flag = 1;
            for($i=0;$i<sizeof($response);$i++){
                if($response[$i]->status == 'Not Available'){
                    $flag = 0;
                    break;
                }
            }
            if($flag == 0){
                echo 'error--The requested hotel is not available on Check In Date. Please search for another hotel';
            }
        }
        else{

            echo 'error--Your hotels are under availability review. Please proceed once received availability confirmation.';
        }
    }
    else{
        echo 'error--Please click to Check Availabity of hotel before Checkout.';
    }
}else{
    echo '';
}
?>