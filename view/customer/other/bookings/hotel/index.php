<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Hotel Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
            <label for="rd_booking" class="app_dual_button active">
                <input type="radio" id="rd_booking" name="app_hotel_booking" checked  onchange="hotel_booking_home_content_reflect()">
                &nbsp;&nbsp;Booking
            </label>    
            <label for="rd_payment" class="app_dual_button">
                <input type="radio" id="rd_payment" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
                &nbsp;&nbsp;Receipt
            </label>
            <label for="rd_report" class="app_dual_button">
                <input type="radio" id="rd_report" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
                &nbsp;&nbsp;Report
            </label>
            <label for="rd_refund" class="app_dual_button">
                <input type="radio" id="rd_refund" name="app_hotel_booking" onchange="hotel_booking_home_content_reflect()">
                &nbsp;&nbsp;Refund
            </label>
        </div>
    </div>
  </div>


    <div id="div_hotel_booking_content" class="main_block"></div>

</div>

<script>
function hotel_booking_home_content_reflect()
{
	var id = $('input[name="app_hotel_booking"]:checked').attr('id');
	if(id=="rd_booking"){
		$.post('bookings/hotel/booking/index.php', {}, function(data){
			$('#div_hotel_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('bookings/hotel/payment/index.php', {}, function(data){
			$('#div_hotel_booking_content').html(data);
		});
	}
    if(id=="rd_report"){
        $.post('bookings/hotel/report/index.php', {}, function(data){
            $('#div_hotel_booking_content').html(data);
        });
    }
    if(id=="rd_refund"){
        $.post('bookings/hotel/refund/index.php', {}, function(data){
            $('#div_hotel_booking_content').html(data);
        });
    }
}
hotel_booking_home_content_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>