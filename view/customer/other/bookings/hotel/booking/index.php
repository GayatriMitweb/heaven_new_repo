<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>	
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="booking_id_filter" id="booking_id_filter" style="width:100%" onchange="booking_list_reflect()">
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

<div id="div_booking_list" class="main_block"></div>
<div id="div_booking" class="main_block"></div>
<script>
$('#booking_id_filter').select2();
function booking_list_reflect()
{
	var booking_id = $('#booking_id_filter').val();

	$.post('bookings/hotel/booking/booking_list_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_booking_list').html(data);
	});
}
booking_list_reflect();
function booking_display_modal(booking_id)
{
	$.post('bookings/hotel/booking/view/index.php', { booking_id : booking_id }, function(data){
		$('#div_booking').html(data);
	});
}

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>