<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Miscellaneous Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
        	<label for="rd_miscellaneous_home" class="app_dual_button active">
		        <input type="radio" id="rd_miscellaneous_home" name="rd_miscellaneous" checked onchange="miscellaneous_content_reflect()">
		        &nbsp;&nbsp;Home
		    </label>    
		    <label for="rd_miscellaneous_payment" class="app_dual_button">
		        <input type="radio" id="rd_miscellaneous_payment" name="rd_miscellaneous" onchange="miscellaneous_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_miscellaneous_report" class="app_dual_button">
		        <input type="radio" id="rd_miscellaneous_report" name="rd_miscellaneous"onchange="miscellaneous_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		    <label for="rd_miscellaneous_refund" class="app_dual_button">
		        <input type="radio" id="rd_miscellaneous_refund" name="rd_miscellaneous" onchange="miscellaneous_content_reflect()">
		        &nbsp;&nbsp;Refund
		    </label>
        </div>
    </div>
  </div>

<div id="div_miscellaneous_content" class="main_block"></div>

</div>

<script>
function miscellaneous_content_reflect()
{
	var id = $('input[name="rd_miscellaneous"]:checked').attr('id');
	if(id=="rd_miscellaneous_home"){
		$.post('bookings/miscellaneous/home/index.php', {}, function(data){
			$('#div_miscellaneous_content').html(data);
		});
	}
	if(id=="rd_miscellaneous_payment"){
		$.post('bookings/miscellaneous/payment/index.php', {}, function(data){
			$('#div_miscellaneous_content').html(data);
		});
	}
	if(id=="rd_miscellaneous_report"){
		$.post('bookings/miscellaneous/report/index.php', {}, function(data){
			$('#div_miscellaneous_content').html(data);
		});
	}
	if(id=="rd_miscellaneous_refund"){
		$.post('bookings/miscellaneous/refund/index.php', {}, function(data){
			$('#div_miscellaneous_content').html(data);
		});
	}
	
}
miscellaneous_content_reflect();
</script>