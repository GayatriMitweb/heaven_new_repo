<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_tp_20"> <div class="col-md-12">
   <button class="btn btn-info btn-sm ico_left" onclick="state_save()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;State</button>
</div> </div>

<div id="div_list_content" class="loader_parent">
    <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
        <table id="state_table" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div></div></div>
</div>
<div id="div_state_list_update_modal"></div>
<script>
var columns = [
          { title: "State_Id" },
          { title: "State_Name" },
          { title: "Status" },
          { title: "Actions", className:"text-center" }
      ];
function list_reflect(){
  $('#div_list_content').append('<div class="loader"></div>');
  $.post('states/list_reflect.php', {}, function(data){
     setTimeout(() => {
      pagination_load(data,columns,true, false, 20, 'state_table');
      $('.loader').remove();
     }, 1000);
   });
}list_reflect();

function state_master_update_modal(id)
{
  $('#div_state_list_update_modal').load('states/update_modal.php', { id : id }).hide().fadeIn(500);
}

function state_save() {
	 $('#state_save_modal').button('loading');
	$.post('states/save_modal.php', {}, function(data){
		$('#state_save_modal').button('reset');
		$('#div_state_list_update_modal').html(data);
	});
}
</script>