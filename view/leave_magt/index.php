<?php
include "../../model/model.php";
/*======******Header******=======*/

require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
 
?>
<?= begin_panel('Leave Management',90) ?>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-center mg_bt_20">
	<label for="rd_leave_credit" class="app_dual_button active">
        <input type="radio" id="rd_leave_credit" name="rd_home" checked onchange="content_reflect()">
        &nbsp;&nbsp;Leave Credit
    </label>
	<label for="rd_leave_req" class="app_dual_button">
        <input type="radio" id="rd_leave_req" name="rd_home" onchange="content_reflect()">
        &nbsp;&nbsp;Leave Request
    </label>
	<label for="rd_leave_reply" class="app_dual_button">
        <input type="radio" id="rd_leave_reply" name="rd_home" onchange="content_reflect()">
        &nbsp;&nbsp;Leave Remark
    </label>    
    
</div>

<div id="div_content"></div>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>

function content_reflect()
{
	 
	var id = $('input[name="rd_home"]:checked').attr('id');
	if(id=="rd_leave_reply"){
		$.post('leave_reply/index.php', {}, function(data){
			$('#div_content').html(data);
		});
	}
	if(id=="rd_leave_credit"){
		$.post('leave_credit/index.php', {}, function(data){
			$('#div_content').html(data);
		});
	}
	if(id=="rd_leave_req"){
		$.post('leave_request/index.php', {}, function(data){
			$('#div_content').html(data);
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