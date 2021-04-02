<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_tp_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;ROE</button>
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list"></div>
<script>
function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('roe/save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect(){
	$.post('roe/list_reflect.php', {}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();

function update_modal(entry_id){
	$.post('roe/update_modal.php', { entry_id : entry_id }, function(data){
		$('#div_modal').html(data);
	});
}
</script>