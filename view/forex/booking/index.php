<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='forex/booking/index.php'"));
$branch_status = $sq['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
?>
<?= begin_panel('Forex Booking',58) ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
	<label for="rd_forex_home" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_forex_home" name="rd_forex" checked onchange="forex_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_forex_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_forex_payment" name="rd_forex" onchange="forex_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>
    <!-- <label for="rd_payment_status" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_payment_status" name="rd_forex" onchange="forex_content_reflect()">
        &nbsp;&nbsp;Summary
    </label> -->
</div>

<div id="div_bus_content" class="forex_module"></div>

<?= end_panel() ?>

<script>
function forex_content_reflect()
{
	var id = $('input[name="rd_forex"]:checked').attr('id');
	var branch_status = $('#branch_status').val();
	if(id=="rd_forex_home"){
		$.post('booking/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}
	if(id=="rd_forex_payment"){
		$.post('payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}
	if(id=="rd_payment_status"){
		$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}	
}
forex_content_reflect();

function booking_dropdown_load(customer_id, booking_id)
{
    var customer_id = $('#'+customer_id).val();
    var branch_status = $('#branch_status').val();
    $.post('inc/booking_dropdown_load.php', { customer_id : customer_id , branch_status : branch_status}, function(data){
        $('#'+booking_id).html(data);
    });
}
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>