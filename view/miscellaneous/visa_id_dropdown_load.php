<?php
include "../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
?>
<option value="">Select Booking ID</option>
<?php
$query = "select * from miscellaneous_master where 1";
$query .=" and customer_id='$customer_id' ";
include "../../model/app_settings/branchwise_filteration.php";

$sq_visa = mysql_query($query);
while($row_visa = mysql_fetch_assoc($sq_visa)){
	
 		$created_at = $row_visa['created_at'];
        $yr = explode("-", $created_at);
       	$year =$yr[0];
       	?>
	<option value="<?= $row_visa['misc_id'] ?>"><?= get_misc_booking_id($row_visa['misc_id'],$year) ?></option>
	<?php
}
?>