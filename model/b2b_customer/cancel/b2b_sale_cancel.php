<?php include "../../model.php";
class b2b_sale_cancel{
    function cancel(){
        $booking_id = $_POST['booking_id'];
        $sq_cancel = mysql_query("UPDATE `b2b_booking_master` SET `status` = 'Cancel' WHERE `booking_id` = $booking_id");
        if(!$sq_cancel){
			echo "error--Sorry, Cancellation not done!";
			exit;
        }
        else{
            echo "B2B booking has been successfully cancelled.";
        }
    }
}