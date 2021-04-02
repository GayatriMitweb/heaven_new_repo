<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='visa_passport_ticket/passport/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Passport Booking',57) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
	<label for="rd_passport_home" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_passport_home" name="rd_passport" checked onchange="passport_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_passport_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_passport_payment" name="rd_passport"onchange="passport_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>
    <label for="rd_passport_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_passport_report" name="rd_passport"onchange="passport_content_reflect()">
        &nbsp;&nbsp;Report
    </label>
    <!-- <label for="rd_passport_payment_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_passport_payment_report" name="rd_passport"onchange="passport_content_reflect()">
        &nbsp;&nbsp;Summary
    </label> -->
</div>

<div id="div_passport_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
	function passport_content_reflect()
	{
		var branch_status = $('#branch_status').val();
		var id = $('input[name="rd_passport"]:checked').attr('id');
		if(id=="rd_passport_home"){
			$.post('home/index.php', {branch_status : branch_status}, function(data){
				$('#div_passport_content').html(data);
			});
		}
		if(id=="rd_passport_payment"){
			$.post('payment/index.php', {branch_status : branch_status}, function(data){
				$('#div_passport_content').html(data);
			});
		}
		if(id=="rd_passport_report"){
			$.post('report/index.php', {branch_status : branch_status}, function(data){
				$('#div_passport_content').html(data);
			});
		}
		if(id=="rd_passport_payment_report"){
			$.post('payment_report/index.php', {branch_status : branch_status}, function(data){
				$('#div_passport_content').html(data);
			});
		}
	}
	passport_content_reflect();
</script>
<script src="../js/passport.js"></script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>