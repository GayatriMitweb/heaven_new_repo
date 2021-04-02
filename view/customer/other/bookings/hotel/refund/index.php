<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="booking_id" id="booking_id" style="width:100%" onchange="refund_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_hotel = mysql_query("select * from hotel_booking_master where customer_id='$customer_id' and  booking_id in ( select booking_id from hotel_booking_entries where status='Cancel') order by booking_id desc");
			        while($row_hotel = mysql_fetch_assoc($sq_hotel)){

						$date = $row_hotel['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_hotel[customer_id]'"));
			          ?>
			          <option value="<?= $row_hotel['booking_id'] ?>"><?= get_hotel_booking_id($row_hotel['booking_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_report_refund" class="main_block"></div>


<script>
$('#booking_id').select2();
function refund_report_reflect()
{
	var booking_id = $('#booking_id').val();
	$.post('bookings/hotel/refund/refund_report_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_report_refund').html(data);
	});
}
refund_report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>