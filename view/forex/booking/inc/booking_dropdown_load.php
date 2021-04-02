<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];

$query = "select * from forex_booking_master where 1 ";
if($customer_id!=""){
	$query .="  and customer_id='$customer_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
echo '<option value="">Select Booking</option>';
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){

	$booking_date = $row_booking['created_at'];
	$yr = explode("-", $booking_date);
	$year =$yr[0];
	?>
	<option value="<?= $row_booking['booking_id'] ?>"><?= get_forex_booking_id($row_booking['booking_id'],$year) ?></option>
	<?php
}