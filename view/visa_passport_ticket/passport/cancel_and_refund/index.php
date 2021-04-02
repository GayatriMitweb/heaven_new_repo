<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>
<?= begin_panel('Passport Cancel & Refund',72) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">
    <label for="rd_passport_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_passport_cancel" name="rd_passport" checked onchange="booking_content_reflect()">
        &nbsp;&nbsp;Cancel
    </label>  
    <label for="rd_passport_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_passport_refund" name="rd_passport"  onchange="booking_content_reflect()">
        &nbsp;&nbsp;Refund
    </label>    
    <label for="rd_passport_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_passport_report" name="rd_passport" onchange="booking_content_reflect()">
        &nbsp;&nbsp;Report Summary
    </label>
</div>

<div id="div_booking_content_reflect"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function booking_content_reflect()
{
	var id = $('input[name="rd_passport"]:checked').attr('id');
	if(id=="rd_passport_cancel"){
		$.post('cancel/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_passport_refund"){
		$.post('refund/index.php', {}, function(data){
			$('#div_booking_content_reflect').html(data);
		});
	}
	if(id=="rd_passport_report"){
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