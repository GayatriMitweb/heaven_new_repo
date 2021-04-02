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
$query = "select * from visa_master where 1 ";
if($customer_id !=''){
	$query .= " and customer_id='$customer_id'";
}
include "../../../model/app_settings/branchwise_filteration.php";
$query .= " order by visa_id desc";
$sq_visa = mysql_query($query);
while($row_visa = mysql_fetch_assoc($sq_visa)){
	$booking_date = $row_visa['created_at'];
    $yr = explode("-", $booking_date);
    $year =$yr[0];
	?>
	<option value="<?= $row_visa['visa_id'] ?>"><?= get_visa_booking_id($row_visa['visa_id'],$year) ?></option>
	<?php
}
?>