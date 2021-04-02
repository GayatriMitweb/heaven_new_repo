<?php
include "../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$customer_id = $_POST['customer_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from tourwise_traveler_details where tour_group_status != 'Cancel' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($branch_status=='yes' && $role!='Admin'){
$query .=" and branch_admin_id = '$branch_admin_id'";
}
 
?>
<option value="">Select Booking</option>
<?php 
$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
	?>
	<option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id']) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	<?php
}?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>