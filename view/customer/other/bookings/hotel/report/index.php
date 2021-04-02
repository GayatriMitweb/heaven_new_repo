<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
<input type="hidden" name="base_url" id="base_url" value="<?= BASE_URL?>">	
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="booking_id_filter" id="booking_id_filter" style="width:100%" onchange="booking_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_booking = mysql_query("select * from hotel_booking_master where customer_id='$customer_id'");
			        while($row_booking = mysql_fetch_assoc($sq_booking)){

						$date = $row_booking['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			          ?>
			          <option value="<?= $row_booking['booking_id'] ?>"><?= get_hotel_booking_id($row_booking['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>	
		</div>
	</div>

<div id="div_report_content" class="main_block"></div>
<div id="div_model_view" class="main_block"></div>


<script>
$('#booking_id_filter').select2();
function booking_report_reflect()
{
	var booking_id = $('#booking_id_filter').val();
	$.post('bookings/hotel/report/booking_report_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_report_content').html(data);
	});	
}
booking_report_reflect();

function images_modal(hotel_id)
{
	var base_url = $('#base_url').val();

	$.post(base_url+'view/customer/other/bookings/hotel/report/hotel_images_model.php', {hotel_id : hotel_id}, function(data){
		$('#div_model_view').html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>