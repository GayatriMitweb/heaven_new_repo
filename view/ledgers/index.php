<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Ledgers',36) ?>
<div id="top"></div>
<div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<label for="rd_led" class="app_dual_button active">
	        <input type="radio" id="rd_led" name="rd_app" checked onchange="content_reflect()">
	        &nbsp;&nbsp;Ledgers
	    </label>
	    <label for="rd_group" class="app_dual_button">
	        <input type="radio" id="rd_group" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Groups
	    </label>
	</div>   
</div>

<div id="div_privileges"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>

<script>
function content_reflect()
{
	var base_url= $('#base_url').val();
	var id = $('input[name="rd_app"]:checked').attr('id');
	if(id=="rd_led"){
		$.post(base_url+'view/finance_master/ledger_master/index.php', {}, function(data){
			$('#div_privileges').html(data);
		});
	}
	if(id=="rd_group"){
		$.post(base_url+'view/finance_master/group_master/index.php', {}, function(data){
			$('#div_privileges').html(data);
		});
	}
}
content_reflect();
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>