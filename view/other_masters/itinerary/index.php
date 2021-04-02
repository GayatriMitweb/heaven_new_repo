<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_tp_20 mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" title="New Itinerary" id="btn_savei_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Itinerary</button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="text-left col-md-3 col-sm-6">
			<select id="dest_id1"  name="dest_name1" title="Select Destination" class="form-control" onchange="list_reflect(this.value)" style="width:100%"> 
				<option value="">Destination</option>
				<?php
				$sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
				while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
				<option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list" class="main_block"></div>
<script>
$('#dest_id1').select2();
function save_modal()
{
	$('#btn_savei_modal').button('loading');
	$.post('itinerary/save_modal.php', {}, function(data){
		$('#btn_savei_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect()
{
	var dest_id = $('#dest_id1').val();
	$.post('itinerary/list_reflect.php', {dest_id:dest_id}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
function update_modal(dest_id)
{
	$.post('itinerary/update_modal.php', { dest_id : dest_id }, function(data){
		$('#div_modal').html(data);
	});
}
</script>