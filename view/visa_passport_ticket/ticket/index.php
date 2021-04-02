<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/ticket/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Flight Ticket',52) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
	<label for="rd_ticket_home" class="app_dual_button active mg_bt_10">
        <input type="radio" id="rd_ticket_home" name="rd_ticket" checked onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_ticket_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_ticket_payment" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>    
    <label for="rd_member_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_member_report" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Passenger Report
    </label>
    <label for="rd_ticket_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_ticket_report" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Ticket Report
    </label>    
	
    <!-- <label for="rd_payment_status" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_payment_status" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Summary
    </label> -->
    <label for="rd_ticket_upload" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_ticket_upload" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Ticket Upload
    </label>
	<label for="rd_visa" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_visa" name="rd_ticket"onchange="ticket_content_reflect()">
        &nbsp;&nbsp;Visa Status
    </label>
</div>

<div id="div_ticket_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	function ticket_content_reflect()
	{	
		var branch_status = $('#branch_status').val();
		var id = $('input[name="rd_ticket"]:checked').attr('id');
		if(id=="rd_ticket_home"){
			$.post('home/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_payment"){
			$.post('payment/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_upload"){
			$.post('upload_ticket/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_ticket_report"){
			$.post('ticket_report/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}		
		if(id=="rd_member_report"){
			$.post('member_report/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_payment_status"){
			$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
		if(id=="rd_visa"){
			$.post('../../visa_status/air_ticket/index.php', {branch_status : branch_status}, function(data){
				$('#div_ticket_content').html(data);
			});
		}
	}
	ticket_content_reflect();
</script>
<script src="../js/ticket.js"></script>
<script>
function business_rule_load(){
		get_auto_values('booking_date','basic_cost','payment_mode','service_charge','markup','save','true','basic','discount');
	}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>