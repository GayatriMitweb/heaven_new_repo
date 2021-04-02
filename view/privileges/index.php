<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Privileges',5) ?>
<div id="top"></div>
<div class="row text-center mg_bt_20">
	<div class="col-md-12">
		<label for="rd_user" class="app_dual_button active">
	        <input type="radio" id="rd_user" name="rd_app" checked onchange="content_reflect()">
	        &nbsp;&nbsp;User
	    </label>
	    <label for="rd_branch" class="app_dual_button">
	        <input type="radio" id="rd_branch" name="rd_app" onchange="content_reflect()">
	        &nbsp;&nbsp;Branch
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
	if(id=="rd_user"){
		$.post(base_url+'view/role_mgt/assign_user_roles.php', {}, function(data){
			$('#div_privileges').html(data);
		});
	}
	if(id=="rd_branch"){
		$.post(base_url+'view/branch_mgt/assign_branch_filter.php', {}, function(data){
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