<?php
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
?>
<option value="">Select Booking ID</option>
<?php
$query = "select * from passport_master where 1";
$query .=" and customer_id='$customer_id' ";
include "../../../model/app_settings/branchwise_filteration.php";
$sq_passport = mysql_query($query);
while($row_passport = mysql_fetch_assoc($sq_passport)){

		$booking_date = $row_passport['created_at'];
		$yr = explode("-", $booking_date);
		$year =$yr[0];
	?>
	<option value="<?= $row_passport['passport_id'] ?>"><?= get_passport_booking_id($row_passport['passport_id'],$year) ?></option>
	<?php
}
?>