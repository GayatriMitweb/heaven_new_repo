<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Group Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
            <label for="rd_booking" class="app_dual_button active">
                <input type="radio" id="rd_booking" name="rd_group_booking" checked  onchange="group_booking_content_reflect()">
                &nbsp;&nbsp;Home
            </label>    
            <label for="rd_payment" class="app_dual_button">
                <input type="radio" id="rd_payment" name="rd_group_booking" onchange="group_booking_content_reflect()">
                &nbsp;&nbsp;Receipt
            </label>
            <label for="rd_group_refund" class="app_dual_button">
                <input type="radio" id="rd_group_refund" name="rd_group_booking" onchange="group_booking_content_reflect()">
                &nbsp;&nbsp;Tour Refund
            </label>
            <label for="rd_group_trefund" class="app_dual_button">
                <input type="radio" id="rd_group_trefund" name="rd_group_booking" onchange="group_booking_content_reflect()">
                &nbsp;&nbsp;Traveller Refund
            </label>
        </div>
    </div>
  </div>

  <div id="div_group_booking_content" class="main_block"></div>

</div>

<script>
function group_booking_content_reflect()
{
	var id = $('input[name="rd_group_booking"]:checked').attr('id');
	if(id=="rd_booking"){
		$.post('bookings/group_booking/booking/index.php', {}, function(data){
			$('#div_group_booking_content').html(data);
		});
	}
	if(id=="rd_payment"){
		$.post('bookings/group_booking/payment/index.php', {}, function(data){
			$('#div_group_booking_content').html(data);
		});
	}
    if(id=="rd_group_refund"){
        $.post('bookings/group_booking/group_refund/index.php', {}, function(data){
            $('#div_group_booking_content').html(data);
        });
    }
    if(id=="rd_group_trefund"){
        $.post('bookings/group_booking/traveler_refund/index.php', {}, function(data){
            $('#div_group_booking_content').html(data);
        });
    }
    if(id=="rd_traveler_refund"){
        $.post('bookings/group_booking/traveler_refund/index.php', {}, function(data){
            $('#div_group_booking_content').html(data);
        });
    }
}
group_booking_content_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>