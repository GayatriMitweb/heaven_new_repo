<?php
include "../../../model/model.php";
?>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-sm-4 mg_bt_10_sm_xs">
			<select name="tour_id" id="tour_id" style="width:100%" onchange="tour_group_reflect(this.id, false);" title="Tour Name">
				<option value="">Tour Name</option>
				<?php 
				$sq_tour = mysql_query("select tour_id, tour_name from tour_master order by tour_name");
				while($row_tour = mysql_fetch_assoc($sq_tour))
				{
					?>
					<option value="<?= $row_tour['tour_id'] ?>"><?= $row_tour['tour_name'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-sm-4 col-sm-4 mg_bt_10_sm_xs">
			<select name="tour_group_id" id="tour_group_id" title="Tour Group" style="width:100%" title="Tour Group">
				<option value="">Tour Group</option>
			</select>
		</div>
		<div class="col-sm-4">
			<button class="btn btn-sm btn-info ico_right" onclick="checklist_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>

	</div>
</div>

<div id="div_checklist_reflect" class="main_block"></div>

<script>
$('#tour_id, #tour_group_id').select2();
$('#tour_id, #tour_group_id').change(function(){
	$('#div_checklist_reflect').html('');
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>