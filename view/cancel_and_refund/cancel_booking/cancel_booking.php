<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>
<?= begin_panel('Package Booking Cancel & Refund',68) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">	
    <label for="rd_package_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_package_cancel" name="rd_package" checked onchange="booking_content_reflect()">
        &nbsp;&nbsp;Cancel
    </label>    
    <label for="rd_package_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_package_refund" name="rd_package"  onchange="booking_content_reflect()">
        &nbsp;&nbsp;Refund
    </label>
</div>

<div id="div_booking_content_reflect"></div>

<script>
function booking_content_reflect()
{
	var id = $('input[name="rd_package"]:checked').attr('id');
	if(id=="rd_package_cancel"){
		$.post('cancel_booking_main.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_package_refund"){
		$.post('../refund/refund_booking_select.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	
}
booking_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>