<?php
include "../../../model/model.php";

$customer_id = $_POST['customer_id'];

$query = "select * from tourwise_traveler_details where tour_group_status != 'Cancel' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){
	$date = $row_booking['form_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	?>
	<option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	<?php
}