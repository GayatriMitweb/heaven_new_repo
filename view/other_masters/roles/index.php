<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Roles',4) ?>

<div class="row text-right">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Role</button>
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect()
{
	$.post('list_reflect.php', {}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
function update_modal(role_id)
{
	$.post('update_modal.php', { role_id : role_id }, function(data){
		$('#div_modal').html(data);
	});
}
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>