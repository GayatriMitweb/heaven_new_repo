<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>
<?= begin_panel('Visa Cancel & Refund',71) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">
    <label for="rd_visa_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_visa_cancel" name="rd_visa" checked onchange="booking_content_reflect()">
        &nbsp;&nbsp;Cancel
    </label>
    <label for="rd_visa_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_visa_refund" name="rd_visa"  onchange="booking_content_reflect()">
        &nbsp;&nbsp;Refund
    </label>    
    <label for="rd_visa_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_visa_report" name="rd_visa" onchange="booking_content_reflect()">
        &nbsp;&nbsp;Report Summary
    </label>
</div>

<div id="div_booking_content_reflect"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function booking_content_reflect()
{
	var id = $('input[name="rd_visa"]:checked').attr('id');
	if(id=="rd_visa_cancel"){
		$.post('cancel/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_visa_refund"){
		$.post('refund/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_visa_report"){
		$.post('report/index.php', {}, function(data){
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
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>