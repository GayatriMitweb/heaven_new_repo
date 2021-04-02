<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >

<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#sms_group_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New SMS Group</button>
	</div>
</div>

<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="email_id" class="table table-hover" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>
<!-- <div id="div_sms_group_list" class="loader_parent"></div> -->

<div id="div_sms_group_edit_content"></div>
<?php include_once('sms_group_save_modal.php'); ?>
<script>
var column = [
	{ title : "S_No."},
	{ title:"Sms_group", className:"text-center"},
	{ title : "Actions", className:"text-center"}
];
function sms_group_list_reflect()
{
	$('#div_sms_group_list').append('<div class="loader"></div>');
	var branch_status = $('#branch_status').val();
	$.post('sms_group/sms_group_list_reflect.php', {  branch_status : branch_status }, function(data){
		pagination_load(data, column, true, false, 20, 'email_id');
	});
}
sms_group_list_reflect();

$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>