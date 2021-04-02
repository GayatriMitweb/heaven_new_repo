<?php 
 include "../../../../../model/model.php";
 $enquiry_id = $_POST['enquiry_id'];
?>
<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?= $enquiry_id ?>"> 
<div class="row">
	<div class="col-md-10 col-md-offset-1 text-right">
	 
	  <button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#followup_save_modal" title="Add new Followup"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Followup</button>
	</div>
</div>

<?php include_once('enquiry_followup_home.php'); ?>


<div id="list_div"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function list_reflect()
{
	var enquiry_id = $('#enquiry_id').val();
	$.post('followup/list_reflect.php', {enquiry_id : enquiry_id}, function(data){
		$('#list_div').html(data);
	});
}
 list_reflect();
function followup_type_reflect(followup_status){
		$.post('followup/followup_type_reflect.php', {followup_status : followup_status}, function(data){
		$('#followup_type').html(data);
	}); 
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../../../layouts/admin_footer.php'); 
?>


 