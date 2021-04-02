<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_bt_10">
    <div class="col-md-12">
        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="New Credit Card Company"><i class="fa fa-plus"></i>&nbsp;&nbsp;Company</button>
    </div>
</div>
<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="active_flag_filter" id="active_flag_filter" class="form-control" title="Status" onchange="list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>
<div id="div_list_cr" class="main_block loader_parent mg_tp_20"></div>
<div id="div_modal" class="main_block"></div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
function save_modal(){

    $('#btn_save_modal').button('loading');
    $.post('credit_card_charges/save_modal.php', {}, function(data){
        $('#btn_save_modal').button('reset');
        $('#div_modal').html(data);
    });
}

function list_reflect(){

    var active_flag = $('#active_flag_filter').val();
	$.post('credit_card_charges/list_reflect.php', {active_flag:active_flag}, function(data){
        console.log(data);
        $('#div_list_cr').html(data);
    });
}
list_reflect();

function update_modal(entry_id){

    $.post('credit_card_charges/update_modal.php', {entry_id : entry_id}, function(data){
        $('#div_modal').html(data);
    });
}
</script>