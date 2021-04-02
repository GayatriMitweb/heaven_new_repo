<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_tp_20">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left" id="btn_savepackage_btn" onclick="save_package_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Destination</button>
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list" class="loader_parent"></div>
<script>
function save_package_modal()
{
    $('#btn_savepackage_btn').button('loading');
    $.post('destinations/save_package_modal.php', {}, function(data){
        $('#btn_savepackage_btn').button('reset');
        $('#div_modal').html(data);
    });
}

function list_reflect()
{
	$('#div_list').append('<div class="loader"></div>');
	$.post('destinations/list_reflect.php', {}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();

function update_modal(dest_id)
{
	$.post('destinations/update_modal.php', { dest_id : dest_id }, function(data){
		$('#div_modal').html(data);
	});
}
function excel_report()
{ 
    window.location = 'destinations/excel_report.php';
}
</script>