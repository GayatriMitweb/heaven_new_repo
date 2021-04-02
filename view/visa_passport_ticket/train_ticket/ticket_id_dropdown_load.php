<?php
include "../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
?>
<option value="">Booking ID</option>
<?php
$query = "select * from train_ticket_master where 1";
$query .=" and customer_id='$customer_id' ";
include "../../../model/app_settings/branchwise_filteration.php";
$sq_ticket = mysql_query($query);
while($row_ticket = mysql_fetch_assoc($sq_ticket)){

$booking_date = $row_ticket['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
      ?>
      <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
	<?php
}
?>