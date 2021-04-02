<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_tp_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Airline</button>
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list" class="loader_parent">
	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="airline_table" class="table table-hover" style="margin: 20px 0 !important;">
		</table>
	</div>
</div>
<script>
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('airlines/save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
// function list_reflect()
// {
// 	$.post('airlines/list_reflect.php', {}, function(data){
// 		$('#div_list').html(data);
// 	});
// }
// list_reflect();
var columns = [
          { title: "S_NO" },
          { title: "Airline_Name" },
          { title: "Code" },
		  { title: "Status" },
          { title: "Actions" }
      ];
function list_reflect(){
	$('#div_list').append('<div class="loader"></div>');
  $.post('airlines/list_reflect.php', {}, function(data){
	setTimeout(() => {
    	pagination_load(data,columns,true, false,20, 'airline_table');
		$('.loader').remove();
    }, 1000);
  });
}list_reflect();
function update_modal(airline_id)
{
	$.post('airlines/update_modal.php', { airline_id : airline_id }, function(data){
		$('#div_modal').html(data);
	});
}
</script>