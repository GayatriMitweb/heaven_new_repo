<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
	
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#email_group_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Email Group</button>
	</div>
</div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="email_id" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
<div id="div_sms_group_list"></div>
<div id="div_sms_group_edit_content"></div>

<?php include_once('email_group_save_modal.php'); ?>
<script>
var column = [
	{ title : "S_No."},
	{ title:"Email_ID_group", className:"text-center"},
	{ title : "Actions", className:"text-center"}
];
function email_group_list_reflect()
{
    var branch_status = $('#branch_status').val();
	$.post('email_group/email_group_list_reflect.php', { branch_status : branch_status  }, function(data){
		pagination_load(data, column, true, false, 20, 'email_id');
	});
}
email_group_list_reflect();
$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>