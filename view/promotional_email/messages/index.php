<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query1 = "select * from email_group_master where 1";
if($branch_status=='yes' && $role=='Branch Admin'){
	$query1 .=" and branch_admin_id = '$branch_admin_id'";
}
$sq_email = mysql_query($query1);
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
		<?php $sq_template = mysql_query("select * from email_template_master order by template_type");	?>
			<select name="template_type" id="template_type" class="form-control"  title="Template Type">
				<option value="">Select Template Type</option>
				<?php 
				while($row_template = mysql_fetch_assoc($sq_template)){
				?>
					<option value="<?php echo $row_template['template_id']; ?>"><?php echo $row_template['template_type']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-4">
			<select name="group_name" class="form-control" id="group_name" title="Group Name">
				<option value="">Select Email Group</option>
			<?php 
			while($row_email = mysql_fetch_assoc($sq_email)){   ?>
				<option value="<?php echo $row_email['email_group_id']; ?>"><?php echo $row_email['email_group_name']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<button class="btn btn-success btn-sm" id="send" onclick="mail_send()"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
		</div>
	</div>
</div>

</div>
<?php include_once('message_save_modal.php'); ?>
<script>
$('#template_type').select2();
function mail_send(sms_message_id, offset){

	var template_type = $('#template_type').val();
	var group_name = $('#group_name').val();
	
	var base_url = $('#base_url').val();
	$('#send').button('loading');
	$.ajax({
		type:'post',
		url:base_url+'controller/promotional_email/message/mail_send.php',
		data:{ template_type : template_type, group_name : group_name },
		success:function(result){
			msg_alert(result);
			$('#send').button('reset');
			// list_email_template();
		}
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>