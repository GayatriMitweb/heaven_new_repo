<?php
include "../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-md-offset-4">
			<?php $sq_template = mysql_query("select * from email_template_master order by template_type");	?>
				<select name="template_type" id="template_type" class="form-control" onchange="list_email_template(this.value)" title="Template Type">
					<option value="">Template Type</option>
					<?php 
					while($row_template = mysql_fetch_assoc($sq_template)){
					?>
						<option value="<?php echo $row_template['template_id']; ?>"><?php echo $row_template['template_type']; ?></option>
					<?php } ?>
				</select>
			</div>
		<div class="col-md-5 text-right">
			<button class="btn btn-sm btn-success ico_left" onclick="view_modal()">&nbsp;&nbsp;View<i class="fa fa-eye"></i></button>
		</div>
	</div>
</div>
<div id="div_view_modal"></div>
<div id="div_template_list" class="main_block"></div>

</div>
<?php include_once('message_save_modal.php'); ?>
<script>
$('#template_type').select2();
function list_email_template(template_type)
{
	$.post('templates/list_email_template.php', { template_type : template_type }, function(data){
		$('#div_template_list').html(data);
	});
}
function view_modal()
{
    $.post('templates/view_modal.php', {  }, function(data){
    	$('#div_view_modal').html(data);
    });
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>