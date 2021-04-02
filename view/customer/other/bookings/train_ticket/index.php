<?php
include "../../../../../model/model.php";
?>
<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Train Ticket Booking</h2>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="panel-body text-center main_block">
        	<label for="rd_ticket_home" class="app_dual_button active">
		        <input type="radio" id="rd_ticket_home" name="rd_ticket" checked onchange="ticket_content_reflect()">
		        &nbsp;&nbsp;Home
		    </label>    
		    <label for="rd_ticket_payment" class="app_dual_button">
		        <input type="radio" id="rd_ticket_payment" name="rd_ticket"onchange="ticket_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_member_report" class="app_dual_button">
		        <input type="radio" id="rd_member_report" name="rd_ticket"onchange="ticket_content_reflect()">
		        &nbsp;&nbsp;Passenger Report
		    </label>
		    <label for="rd_ticket_report" class="app_dual_button">
		        <input type="radio" id="rd_ticket_report" name="rd_ticket"onchange="ticket_content_reflect()">
		        &nbsp;&nbsp;Ticket Report
		    </label>
		    <label for="rd_ticket_refund" class="app_dual_button">
		        <input type="radio" id="rd_ticket_refund" name="rd_ticket"onchange="ticket_content_reflect()">
		        &nbsp;&nbsp;Refund
		    </label>
        </div>
    </div>
  </div>

	<div id="div_ticket_content" class="main_block"></div>

</div>

<script>
	function ticket_content_reflect()
	{
		var id = $('input[name="rd_ticket"]:checked').attr('id');
		if(id=="rd_ticket_home"){
			$.post('bookings/train_ticket/home/index.php', {}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_payment"){
			$.post('bookings/train_ticket/payment/index.php', {}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_member_report"){
			$.post('bookings/train_ticket/member_report/index.php', {}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_report"){
			$.post('bookings/train_ticket/report/index.php', {}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_refund"){
			$.post('bookings/train_ticket/refund/index.php', {}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
	}
	ticket_content_reflect();
</script>