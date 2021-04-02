<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<select id="status_filter1" name="status_filter1" title="Status" onchange="list_reflect1()">
				<option value="Pending">Pending</option>
				<option value="Cancelled">Cancelled</option>
				<option value="Cleared">Cleared</option>
				<option value="All">All</option>
			</select>
		</div>
	</div>
</div>	

<div id="div_list1" class="main_block"></div>

<script>
function list_reflect1(){
	
	var branch_status = $('#branch_status').val();
	var status = $('#status_filter1').val();
	$.post('credit_card/list_reflect.php',{ status : status, branch_status : branch_status }, function(data){
		$('#div_list1').html(data);
	});
}
list_reflect1();
</script>