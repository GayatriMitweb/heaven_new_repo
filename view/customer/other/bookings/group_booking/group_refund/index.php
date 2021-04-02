<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="tourwise_traveler_idr" id="tourwise_traveler_idr" title="Select Booking" onchange="refund_list_reflect()" style="width: 100%">
					<option value="">Select Booking</option>
					<?php 
					$sq_booking = mysql_query("select * from tourwise_traveler_details where customer_id='$customer_id' and tour_group_status='Cancel'");
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
$('#tourwise_traveler_idr').select2();
function refund_list_reflect()
{
	var tourwise_traveler_id = $('#tourwise_traveler_idr').val();
	$.post('bookings/group_booking/group_refund/refund_list_reflect.php', { tourwise_traveler_id : tourwise_traveler_id }, function(data){
		$('#div_payment_list').html(data);
	});
}
refund_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>