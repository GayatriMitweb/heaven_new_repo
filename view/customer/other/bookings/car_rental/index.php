<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Car Rental Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
            <label for="rd_booking" class="app_dual_button active">
                <input type="radio" id="rd_booking" name="rd_car_rental_booking" checked  onchange="car_rental_booking_content_reflect()">
                &nbsp;&nbsp;Home
            </label>    
            <label for="rd_payment" class="app_dual_button">
                <input type="radio" id="rd_payment" name="rd_car_rental_booking" onchange="car_rental_booking_content_reflect()">
                &nbsp;&nbsp;Receipt
            </label>
            <label for="rd_refund" class="app_dual_button">
                <input type="radio" id="rd_refund" name="rd_car_rental_booking" onchange="car_rental_booking_content_reflect()">
                &nbsp;&nbsp;Refund
            </label>
        </div>
    </div>
  </div>

    <div id="div_car_rental_booking_content" class="main_block"></div>

</div>

<script>
function car_rental_booking_content_reflect()
{
	var id = $('input[name="rd_car_rental_booking"]:checked').attr('id');
	if(id=="rd_booking"){
		$.post('bookings/car_rental/booking/index.php', {}, function(data){
			$('#div_car_rental_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('bookings/car_rental/payment/index.php', {}, function(data){
			$('#div_car_rental_booking_content').html(data);
		});
	}
    if(id=="rd_refund"){
        $.post('bookings/car_rental/refund/index.php', {}, function(data){
            $('#div_car_rental_booking_content').html(data);
        });
    }
}
car_rental_booking_content_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>