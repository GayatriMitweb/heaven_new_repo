<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Activity Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
        	<label for="rd_exc_home" class="app_dual_button active">
		        <input type="radio" id="rd_exc_home" name="rd_exc" checked onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Home
		    </label>    
		    <label for="rd_exc_payment" class="app_dual_button">
		        <input type="radio" id="rd_exc_payment" name="rd_exc" onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_exc_report" class="app_dual_button">
		        <input type="radio" id="rd_exc_report" name="rd_exc"onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		    <label for="rd_exc_refund" class="app_dual_button">
		        <input type="radio" id="rd_exc_refund" name="rd_exc" onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Refund
		    </label>
        </div>
    </div>
  </div>


	<div id="div_exc_content" class="main_block"></div>

</div>

<script>
function exc_content_reflect()
{
	var id = $('input[name="rd_exc"]:checked').attr('id');
	if(id=="rd_exc_home"){
		$.post('bookings/excursion/home/index.php', {}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_exc_payment"){
		$.post('bookings/excursion/payment/index.php', {}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_exc_report"){
		$.post('bookings/excursion/report/index.php', {}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_exc_refund"){
		$.post('bookings/excursion/refund/index.php', {}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	
}
exc_content_reflect();
</script>