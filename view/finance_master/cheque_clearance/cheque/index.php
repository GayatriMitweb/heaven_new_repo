<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<select id="status_filter" name="status_filter" title="Status" onchange="list_reflect()">
				<option value="Pending">Pending</option>
				<option value="Cancelled">Cancelled</option>
				<option value="Cleared">Cleared</option>
				<option value="All">All</option>
			</select>
		</div>
	</div>
</div>	

<div id="div_list" class="main_block"></div>

<script>
function list_reflect(){
	
	var branch_status = $('#branch_status').val();
	var status = $('#status_filter').val();
	$.post('cheque/list_reflect.php',{ status : status, branch_status : branch_status }, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
</script>