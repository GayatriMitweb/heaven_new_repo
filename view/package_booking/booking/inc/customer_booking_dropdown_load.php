<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from package_tour_booking_master where 1";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
 
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){
	$date = $row_booking['booking_date'];
	$yr = explode("-", $date);
	$year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	?>
	<option value="<?= $row_booking['booking_id'] ?>"><?= get_package_booking_id($row_booking['booking_id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	<?php
}