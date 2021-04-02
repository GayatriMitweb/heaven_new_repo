<?php
include "../../../../model/model.php";
?>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 col-xs-12">
			<select name="booking_id" id="booking_id" style="width:100%"  title="Select Booking" onchange="refund_content_reflect()" class="app_select2">
		        <option value="">Select Booking</option>
		        <?php 
		        $sq_booking = mysql_query("select * from car_rental_booking where status='Cancel' order by booking_id desc");
		        while($row_booking = mysql_fetch_assoc($sq_booking)){
		        	$date = $row_booking['created_at'];
			         $yr = explode("-", $date);
			         $year =$yr[0];
	              $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
		          ?>
		          <option value="<?= $row_booking['booking_id'] ?>"><?= get_car_rental_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
		          <?php } ?>
		    </select>
		</div>
	</div>
</div>

<div id="div_refund_content" class="main_block"></div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>
$('#booking_id').select2();
function refund_content_reflect()
{
	var booking_id = $('#booking_id').val();
	if(booking_id != ''){
		$.post('home/refund_content_reflect.php', { booking_id : booking_id }, function(data){
			$('#div_refund_content').html(data);
		});
	}
	else{
		error_msg_alert("Select Booking ID!");
		$('#div_refund_content').html('');
		return false;
	}
}
</script>