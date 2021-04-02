<?php include "../../../model/model.php"; ?>
<?php 
$booking_id = $_GET['booking_id'];
?>
<option value="">Select Payment</option>
<?php
$sq_payment =  mysql_query("select payment_id, booking_id, amount, payment_for from package_payment_master where booking_id='$booking_id'");
while($row_payment = mysql_fetch_assoc($sq_payment))
{
	$sq_receipt_id = mysql_fetch_assoc(mysql_query("select * from package_receipt_master where booking_id='$row_payment[booking_id]' and payment_id = '$row_payment[payment_id]'"));
	$receipt_id = $sq_receipt_id['receipt_id'];
?>
	<option value="<?php echo $row_payment['payment_id']; ?>"><?php echo $row_payment['payment_for']."-".get_package_booking_payment_id($row_payment['payment_id'])."-".$row_payment['amount']; ?></option>
<?php 
}
?>