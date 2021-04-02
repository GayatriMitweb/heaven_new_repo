<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

      <div class="app_panel_content Filter-panel">
      	<div class="row">
			<div class="col-md-3">
				<select name="booking_idp" id="booking_idp" title="Booking ID" onchange="payment_list_reflect()" style="width: 100%">
					<option value="">Select Booking</option>
					<?php 
					$sq_booking = mysql_query("select * from package_tour_booking_master where customer_id='$customer_id'");
					while($row_booking = mysql_fetch_assoc($sq_booking)){

						$date = $row_booking['booking_date'];
						$yr = explode("-", $date);
						$year =$yr[0];
						$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
						?>
						<option value="<?= $row_booking['booking_id'] ?>"><?= get_package_booking_id($row_booking['booking_id'],$year) ?> : <?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>
      </div>

<div id="div_payment_list" class="main_block"></div>

<script>
$('#booking_idp').select2();
function payment_list_reflect()
{
	var booking_id = $('#booking_idp').val();
	$.post('bookings/package_booking/payment/payment_list_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_payment_list').html(data);
	});
}
payment_list_reflect();
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>