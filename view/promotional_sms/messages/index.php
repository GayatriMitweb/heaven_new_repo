<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>

<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#sms_message_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Message</button>
	</div>
</div>

<div id="div_message_list" class="loader_parent"></div>


<?php include_once('message_save_modal.php'); ?>
<script>
function sms_message_list_reflect()
{
	$('#div_message_list').append('<div class="loader"></div>');

	var branch_status = $('#branch_status').val();
	$.post('messages/message_list_reflect.php', {  branch_status : branch_status }, function(data){
		$('#div_message_list').html(data);
	});
}
sms_message_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>