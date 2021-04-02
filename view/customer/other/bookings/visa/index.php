<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Visa Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
        	<label for="rd_visa_home" class="app_dual_button active">
		        <input type="radio" id="rd_visa_home" name="rd_visa" checked onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Home
		    </label>    
		    <label for="rd_visa_payment" class="app_dual_button">
		        <input type="radio" id="rd_visa_payment" name="rd_visa" onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_visa_report" class="app_dual_button">
		        <input type="radio" id="rd_visa_report" name="rd_visa"onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		    <label for="rd_visa_refund" class="app_dual_button">
		        <input type="radio" id="rd_visa_refund" name="rd_visa" onchange="visa_content_reflect()">
		        &nbsp;&nbsp;Refund
		    </label>
        </div>
    </div>
  </div>

<div id="div_visa_content" class="main_block"></div>

</div>

<script>
function visa_content_reflect()
{
	var id = $('input[name="rd_visa"]:checked').attr('id');
	if(id=="rd_visa_home"){
		$.post('bookings/visa/home/index.php', {}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_visa_payment"){
		$.post('bookings/visa/payment/index.php', {}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_visa_report"){
		$.post('bookings/visa/report/index.php', {}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	if(id=="rd_visa_refund"){
		$.post('bookings/visa/refund/index.php', {}, function(data){
			$('#div_visa_content').html(data);
		});
	}
	
}
visa_content_reflect();
</script>