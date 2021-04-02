<?php include "../../../../model/model.php"; ?>
<?php 

$customer_id = $_POST['customer_id'];
echo '<option value="">Select Booking</option>';

$query = "select * from hotel_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";	
}

$sq_booking = mysql_query($query);
while($row_booking = mysql_fetch_assoc($sq_booking)){

  $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
  $date = $row_booking['created_at'];
  $yr = explode("-", $date);
  $year =$yr[0];
  ?>
  <option value="<?= $row_booking['booking_id'] ?>"><?= get_hotel_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
  <?php
}

?>