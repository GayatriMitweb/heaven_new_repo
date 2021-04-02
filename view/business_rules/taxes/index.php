<?php
include "../../../model/model.php";
?>

<div class="row text-right mg_bt_10">
    <div class="col-sm-12 text-right">
        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" data-toggle="tooltip" title="Add New Tax"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tax</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <!-- <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="list_reflect()">
                <?php //get_cities_dropdown(); ?>
            </select>
        </div> -->
        <div class="col-md-3 col-sm-6">
            <select name="active_flag_filter" id="active_flag_filter" title="Status" data-toggle="tooltip" onchange="list_reflect()" style="width:100%" class='form-control'>
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>


<div id="div_taxes_list" class="main_block loader_parent mg_tp_20">
 <div class="table-responsive">
        <table id="tax_master_tab" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_modal_content"></div>
<div id="div_view_modal"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
var columns= [
          { title: "S_NO" },
          { title: "Code" },
          { title: "Name" },
          { title: "Rate" },
          { title: "Actions", className:"text-center" }
      ];
function list_reflect(){

    $('#div_taxes_list').append('<div class="loader"></div>');
	var active_flag = $('#active_flag_filter').val();
    $.post('taxes/list_reflect.php', {status:active_flag}, function(data){
	setTimeout(() => {
        pagination_load(data,columns, true, false, 20, 'tax_master_tab');
        $('.loader').remove();
    }, 1000);
  });
}
list_reflect();

function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('taxes/save_modal.php', {type:''}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal_content').html(data);
	});
}

function update_modal(entry_id){
	$.post('taxes/update_modal.php', {entry_id : entry_id}, function(data){
		$('#div_modal_content').html(data);
	});
}
function update_rulemodal(entry_id){
	$.post('taxes_rules/save_rules.php', {entry_id : entry_id}, function(data){
		$('#div_modal_content').html(data);
	});

}
function update_cache(){
	$.post('update_cache.php', {}, function(data){	});
}
function toggle_rate_validation(id){
  var offset = id.substr(4);
  var err_display = ($('#rate_in'+offset).val() == 'Percentage') ? percentage_validation(id) : flat_validation(id);
  if(!err_display){
    error_msg_alert('Incorrect Rate Value'); 
    $('#'+id).val(0);
  } 
}
</script>