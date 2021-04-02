<?php
include "../../model/model.php";
$customer_id = $_POST['customer_id'];
if($customer_id == ''){
    $query = "select * from b2b_booking_master where 1";
}
else{
    $query = "select * from b2b_booking_master where customer_id='$customer_id'";
}
$sq_rc1 = mysql_query($query); ?>
<option value="">Select Booking</option>
<?php
while($row_rc1= mysql_fetch_assoc($sq_rc1)){
$yr = explode("-", get_datetime_db($row_rc1['created_at']));
?>
<option value="<?= $row_rc1['booking_id'] ?>"><?=  get_b2b_booking_id($row_rc1['booking_id'],$yr[0]) ?></option>
<?php } ?>   
