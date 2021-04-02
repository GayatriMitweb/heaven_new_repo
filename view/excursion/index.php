<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='excursion/index.php'"));
$branch_status = $sq['branch_status'];
?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Activity Booking',59) ?>
      <div class="header_bottom">
        <div class="row text-center text_left_sm_xs">
			<label for="rd_exc_home" class="app_dual_button active mg_bt_10">
		        <input type="radio" id="rd_exc_home" name="rd_exc" checked onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Booking
		    </label>    
		    <label for="rd_exc_payment" class="app_dual_button mg_bt_10">
		        <input type="radio" id="rd_exc_payment" name="rd_exc" onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Receipt
		    </label>
		    <label for="rd_exc_report" class="app_dual_button mg_bt_10">
		        <input type="radio" id="rd_exc_report" name="rd_exc" onchange="exc_content_reflect()">
		        &nbsp;&nbsp;Report
		    </label>
		</div>
      </div> 

<div class="app_panel_content">
<div id="div_exc_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function exc_content_reflect()
{
	var branch_status = $('#branch_status').val();
	var id = $('input[name="rd_exc"]:checked').attr('id');
	if(id=="rd_exc_home"){
		$.post('home/index.php', {branch_status : branch_status}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_exc_payment"){
		$.post('payment/index.php', {branch_status : branch_status}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_exc_report"){
		$.post('report/index.php', {branch_status : branch_status}, function(data){
			$('#div_exc_content').html(data);
		});
	}
	if(id=="rd_payment_status"){
		$.post('payment_status/index.php', {branch_status : branch_status}, function(data){
			$('#div_exc_content').html(data);
		});
	}
}
exc_content_reflect();
function exc_id_dropdown_load(customer_id_filter, exc_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var branch_status = $('#branch_status').val();

	$.post('exc_id_dropdown_load.php', { customer_id : customer_id, branch_status : branch_status }, function(data){
		$('#'+exc_id_filter).html(data);
	});
}
</script>
<script src="js/excursion.js"></script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>