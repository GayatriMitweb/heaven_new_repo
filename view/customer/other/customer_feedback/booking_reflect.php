<?php
include_once('../../../../model/model.php');
$booking_type = $_POST['booking_type'];
$customer_id = $_POST['customer_id'];
if($booking_type=="Group Booking"){ 
	$query = "select * from tourwise_traveler_details where customer_id='$customer_id'";  
	$sq_booking = mysql_query($query); 
	while($row_booking = mysql_fetch_assoc($sq_booking)){

		$sq_tour = mysql_fetch_assoc(mysql_query("select from_date,to_date from tour_groups where group_id='$row_booking[tour_group_id]'"));
		$tour_group_from = date("d-m-Y", strtotime($sq_tour['from_date']));
		$tour_group_to = date("d-m-Y", strtotime($sq_tour['to_date'])); ?>
		<option value="<?php echo $row_booking['id']; ?>"><?php echo  get_group_booking_id($row_booking['id']).' ('.$tour_group_from." To ".$tour_group_to.')' ?></option>; 
	<?php
	} 
}
elseif($booking_type=="Package Booking"){
	$query = "select * from package_tour_booking_master as m left join package_travelers_details as t on m.booking_id=t.booking_id where m.customer_id='$customer_id' and t.status != 'Cancel'";
	$sq_booking = mysql_query($query); 
	while($row_booking = mysql_fetch_assoc($sq_booking)){ ?>
		<option value="<?php echo $row_booking['booking_id']; ?>"><?php echo  get_package_booking_id($row_booking['booking_id']).' ('.date('d-m-Y', strtotime($row_booking['tour_from_date'])).' To '. date('d-m-Y', strtotime($row_booking['tour_to_date'])).')' ?></option>; 
	<?php 
	} 
} ?>
<script>
$('#booking_id').select2();
</script>