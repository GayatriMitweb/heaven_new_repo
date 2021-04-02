<?php
include "../../model/model.php";

$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<option value="">Booking ID</option>
<?php
$query = "select * from excursion_master where 1";
if($customer_id!=""){
	$query .="  and customer_id='$customer_id'";
}
include "../../model/app_settings/branchwise_filteration.php";
 echo $query;
$sq_exc = mysql_query($query);
while($row_exc = mysql_fetch_assoc($sq_exc)){

	$booking_date = $row_exc['created_at'];
	$yr = explode("-", $booking_date);
	$year =$yr[0];
	?>
	<option value="<?= $row_exc['exc_id'] ?>"><?= get_exc_booking_id($row_exc['exc_id'],$year) ?></option>
	<?php
}
?>