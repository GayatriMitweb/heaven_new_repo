<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/train_ticket/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Train Ticket Booking',53) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
	<label for="rd_train_ticket_home" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_train_ticket_home" name="rd_ticket" checked onchange="train_ticket_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_train_ticket_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_train_ticket_payment" name="rd_ticket"onchange="train_ticket_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>    
    <label for="rd_train_ticket_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_train_ticket_report" name="rd_ticket"onchange="train_ticket_content_reflect()">
        &nbsp;&nbsp;Passenger Report
    </label>
    <label for="rd_train_trip_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_train_trip_report" name="rd_ticket"onchange="train_ticket_content_reflect()">
        &nbsp;&nbsp;Ticket Report
    </label>
    <label for="rd_train_ticket_upload" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_train_ticket_upload" name="rd_ticket"onchange="train_ticket_content_reflect()">
        &nbsp;&nbsp;Ticket Upload
    </label>
</div>

<div id="div_train_ticket_content"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	function train_ticket_content_reflect()
	{	
		var branch_status = $('#branch_status').val();
		var id = $('input[name="rd_ticket"]:checked').attr('id');
		if(id=="rd_train_ticket_home"){
			$.post('home/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
		if(id=="rd_train_ticket_payment"){
			$.post('payment/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
		if(id=="rd_train_ticket_upload"){
			$.post('upload_ticket/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
		if(id=="rd_train_ticket_report"){
			$.post('member_report/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
		if(id=="rd_train_trip_report"){
			$.post('trip_report/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
		if(id=="rd_payment_status"){
			$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
				$('#div_train_ticket_content').html(data);
			});
		}
	}
	train_ticket_content_reflect();
</script>
<script src="../js/train_ticket.js"></script>
<script src="../js/train_business_calculation.js"></script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php');
?>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>