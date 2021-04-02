<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Bus Booking Cancel/Refund',76) ?>

<div class="row text-center text_left_sm_xs mg_bt_10">
    <label for="rd_cancel" class="app_dual_button mg_bt_10 active">
        <input type="radio" id="rd_cancel" name="rd_bus" checked  onchange="content_reflect()">
        &nbsp;&nbsp;Cancel
    </label>
    <label for="rd_refund" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_refund" name="rd_bus"  onchange="content_reflect()">
        &nbsp;&nbsp;Refund
    </label>    
    <label for="rd_report" class="app_dual_button mg_bt_10">
        <input type="radio" id="rd_report" name="rd_bus" onchange="content_reflect()">
        &nbsp;&nbsp;Report
    </label> 
</div>

<div id="div_content"></div>


<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function content_reflect()
{
	var id = $('input[name="rd_bus"]:checked').attr('id');

    if(id=="rd_cancel"){ url = 'cancel/index.php'; }
    if(id=="rd_refund"){ url = 'refund/index.php'; }
    if(id=="rd_report"){ url = 'report/index.php'; }

	$.post(url, {}, function(data){
		$('#div_content').html(data);
	});
}
content_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>