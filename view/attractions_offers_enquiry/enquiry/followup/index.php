<?php
include "../../../../model/model.php";
/*======******Header******=======*/
$enquiry_id = $_GET['enquiry_id'];
$branch_status = $_GET['branch_status'];
include_once('../../../layouts/fullwidth_app_header.php'); 
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Online Booking</title>	

	<?php admin_header_scripts(); ?>

</head>
<body>
<input type="hidden" id="base_url" name="base_url" value="<?= BASE_URL ?>">

<div class="app_content_wrap" style="padding-left: 0;">
 
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>">
<div class="row text-center mg_bt_20">
	<label for="rd_followup" class="app_dual_button active">
		<input type="radio" id="rd_followup" name="rd_enquiry" checked onchange="enquiry_content_reflect()">
		&nbsp;&nbsp;Followup
	</label> 
	<label for="rd_enquiry_home" class="app_dual_button">
		<input type="radio" id="rd_enquiry_home" name="rd_enquiry" onchange="enquiry_content_reflect()">
		&nbsp;&nbsp;Enquiry
	</label>    
</div>

<div class="app_panel_content">
	<div class="row">
		<div class="col-md-12">
			<div id="div_enquiry_content"></div>
		</div>
	</div>
</div>
<script>
function enquiry_content_reflect(){
	var id = $('input[name="rd_enquiry"]:checked').attr('id');
	if(id=="rd_followup"){
		var enquiry_id = $('#enquiry_id').val();
		$.post('followup/index.php', {enquiry_id : enquiry_id}, function(data){
			$('#div_enquiry_content').html(data);
		});
	}
	if(id=="rd_enquiry_home"){
		var enquiry_id = $('#enquiry_id').val();
		var branch_status = $('#branch_status').val();
		$.post('enquiry_master_update.php', {enquiry_id : enquiry_id, branch_status : branch_status}, function(data){
			$('#div_enquiry_content').html(data);
		});
	}		
}
enquiry_content_reflect();
</script>

<?php
/*======******Footer******=======*/
include_once('../../../layouts/fullwidth_app_footer.php');
?>