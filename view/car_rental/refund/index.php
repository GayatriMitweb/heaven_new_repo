<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Car Rental Refund',70) ?>

<div class="row text-center mg_bt_20">
		
	<label for="rd_refund_home" class="app_dual_button active">
        <input type="radio" id="rd_refund_home" name="rd_refund" checked  onchange="refund_reflect()">
        &nbsp;&nbsp;Refund
    </label>    
    <label for="rd_report" class="app_dual_button">
        <input type="radio" id="rd_report" name="rd_refund" onchange="refund_reflect()">
        &nbsp;&nbsp;Report
    </label>

</div>

<div id="div_refund"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function refund_reflect()
{
	var id = $('input[name="rd_refund"]:checked').attr('id');
	if(id=="rd_refund_home"){
		$.post('home/index.php', { }, function(data){
			$('#div_refund').html(data);
		});		
	}
	if(id=="rd_report"){
		$.post('report/index.php', { }, function(data){
			$('#div_refund').html(data);
		});		
	}
	
}
refund_reflect();
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>
