<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Passport Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
        	<label for="rd_passport_home" class="app_dual_button active">
		        <input type="radio" id="rd_passport_home" name="rd_passport" checked onchange="passport_content_reflect()">
		        &nbsp;&nbsp;Home
		    </label>    
		    <label for="rd_passport_payment" class="app_dual_button">
		        <input type="radio" id="rd_passport_payment" name="rd_passport"onchange="passport_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_passport_report" class="app_dual_button">
		        <input type="radio" id="rd_passport_report" name="rd_passport"onchange="passport_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		    <label for="rd_passport_refund" class="app_dual_button">
		        <input type="radio" id="rd_passport_refund" name="rd_passport"onchange="passport_content_reflect()">
		        &nbsp;&nbsp;Refund
		    </label>
        </div>
    </div>
  </div>

  <div id="div_passport_content" class="main_block"></div>

</div>

<script>
function passport_content_reflect()
{
	var id = $('input[name="rd_passport"]:checked').attr('id');
	if(id=="rd_passport_home"){
		$.post('bookings/passport/home/index.php', {}, function(data){
			$('#div_passport_content').html(data);
		});
	}
	if(id=="rd_passport_payment"){
		$.post('bookings/passport/payment/index.php', {}, function(data){
			$('#div_passport_content').html(data);
		});
	}
	if(id=="rd_passport_report"){
		$.post('bookings/passport/report/index.php', {}, function(data){
			$('#div_passport_content').html(data);
		});
	}
	if(id=="rd_passport_refund"){
		$.post('bookings/passport/refund/index.php', {}, function(data){
			$('#div_passport_content').html(data);
		});
	}
	 
}
passport_content_reflect();
</script>
