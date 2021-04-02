<?php
include "../../../model/model.php";

$customer_id = $_POST['customer_id'];

$query = "select booking_id, customer_id from package_tour_booking_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
?>
  <option value="">Booking ID</option>
<?php 
  $sq_booking = mysql_query($query);
  while($row_booking = mysql_fetch_assoc($sq_booking))
  {
      $sq_customer = mysql_fetch_assoc(mysql_query("select first_name, middle_name, last_name from customer_master where customer_id='$row_booking[customer_id]'"));
      $sq_booking = mysql_fetch_assoc(mysql_query("select * from package_tour_booking_master where booking_id='$row_booking[booking_id]'"));
      $date = $sq_booking['booking_date'];
      $yr = explode("-", $date);
      $year =$yr[0];
       ?>
       <option value="<?php echo $row_booking['booking_id'] ?>"><?php echo get_package_booking_id($row_booking['booking_id'],$year)."-"." ".$sq_customer['first_name']." ".$sq_customer['last_name']; ?></option>
       <?php    
  }    
?>