<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Package Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
            <label for="rd_booking" class="app_dual_button active">
                <input type="radio" id="rd_booking" name="rd_package_booking" checked  onchange="package_booking_content_reflect()">
                &nbsp;&nbsp;Home
            </label>    
            <label for="rd_payment" class="app_dual_button">
                <input type="radio" id="rd_payment" name="rd_package_booking" onchange="package_booking_content_reflect()">
                &nbsp;&nbsp;Receipt
            </label>
            <label for="rd_refund" class="app_dual_button">
                <input type="radio" id="rd_refund" name="rd_package_booking" onchange="package_booking_content_reflect()">
                &nbsp;&nbsp;Refund
            </label>    
        </div>
    </div>
  </div>
    
    <div id="div_package_booking_content" class="main_block"></div>

</div>



<script>
function package_booking_content_reflect()
{
	var id = $('input[name="rd_package_booking"]:checked').attr('id');
	if(id=="rd_booking"){
		$.post('bookings/package_booking/booking/index.php', {}, function(data){
			$('#div_package_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('bookings/package_booking/payment/index.php', {}, function(data){
			$('#div_package_booking_content').html(data);
		});
	}
    if(id=="rd_refund"){
        $.post('bookings/package_booking/refund/index.php', {}, function(data){
            $('#div_package_booking_content').html(data);
        });
    }  
}
package_booking_content_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>