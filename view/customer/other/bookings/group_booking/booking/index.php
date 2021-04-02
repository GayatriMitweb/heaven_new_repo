<?php
include "../../../../../../model/model.php";
$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="tourwise_traveler_id1" id="tourwise_traveler_id1" title="Select Booking" onchange="group_list_reflect()" style="width: 100%">
					<option value="">Select Booking</option>
					<?php 
					$sq_booking = mysql_query("select * from tourwise_traveler_details where customer_id='$customer_id'");
					while($row_booking = mysql_fetch_assoc($sq_booking)){
						$date = $row_booking['form_date'];
						$yr = explode("-", $date);
						$year =$yr[0];
						$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$customer_id'"));
						?>
						<option value="<?= $row_booking['id'] ?>"><?= get_group_booking_id($row_booking['id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
	</div>

<div id="div_payment_list" class="main_block"></div>

<script>
$('#tourwise_traveler_id1').select2();
function group_list_reflect()
{
	var tourwise_traveler_id = $('#tourwise_traveler_id1').val();
	$.post('bookings/group_booking/booking/group_list_reflect.php', { tourwise_traveler_id : tourwise_traveler_id }, function(data){
		$('#div_payment_list').html(data);
	});
}
group_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>