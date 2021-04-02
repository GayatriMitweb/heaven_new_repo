	<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='bus_booking/booking/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Bus Booking',55) ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
	<label for="rd_bus_home" class="app_dual_button active mg_bt_10">
        <input type="radio" id="rd_bus_home" name="rd_bus" checked onchange="bus_content_reflect()">
        &nbsp;&nbsp;Booking
    </label>    
    <label for="rd_bus_payment" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_bus_payment" name="rd_bus" onchange="bus_content_reflect()">
        &nbsp;&nbsp;Receipt
    </label>
    <label for="rd_bus_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_bus_report" name="rd_bus" onchange="bus_content_reflect()">
        &nbsp;&nbsp;Report
    </label>
    <!-- <label for="rd_payment_status" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_payment_status" name="rd_bus" onchange="bus_content_reflect()">
        &nbsp;&nbsp;Summary
    </label> -->
</div>

<div id="div_bus_content"></div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
function bus_content_reflect()
{
	var id = $('input[name="rd_bus"]:checked').attr('id');
	var branch_status = $('#branch_status').val();
	if(id=="rd_bus_home"){
		$.post('booking/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}
	if(id=="rd_bus_payment"){
		$.post('payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}
	if(id=="rd_bus_report"){
		$.post('report/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}
	if(id=="rd_payment_status"){
		$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
			$('#div_bus_content').html(data);
		});
	}	
}
bus_content_reflect();

function booking_dropdown_load(customer_id, booking_id)
{
    var customer_id = $('#'+customer_id).val();
    var branch_status = $('#branch_status').val();
    $.post('inc/booking_dropdown_load.php', { customer_id : customer_id, branch_status : branch_status }, function(data){
        $('#'+booking_id).html(data);
    });
}
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>