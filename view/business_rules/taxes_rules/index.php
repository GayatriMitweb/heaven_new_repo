<?php
include "../../../model/model.php";
?>
<div class="row text-right mg_bt_10">
    <div class="col-sm-12 text-right">
        <button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" data-toggle="tooltip" title="Add Tax Rule"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tax Rule</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <select name="tax_filter" id="tax_filter" title="Select Tax" data-toggle="tooltip" onchange="t_list_reflect()" style="width:100%" class='form-control'>
                <option value="">Select Tax</option>
                <?php 
                $sq = mysql_query("select * from tax_master");
                while($row_taxes = mysql_fetch_assoc($sq))
                {
                    $rate = ($row_taxes['rate_in'] == "Percentage") ? $row_taxes['rate'].'(%)': $row_taxes['rate'];
                    $string = $row_taxes['name'].'-'.$rate;
                ?>
                <option value="<?= $row_taxes['entry_id']?>"><?= $string ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="active_flag_filter" id="active_flag_filter1" title="Status" data-toggle="tooltip" onchange="t_list_reflect()" style="width:100%" class='form-control'>
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div id="div_taxes_list" class="main_block loader_parent mg_tp_20">
 <div class="table-responsive">
        <table id="tax_rules_tab" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_modal_content"></div>
<div id="div_view_modal"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#tax_filter').select2();
var columns1 = [
    { title: "S_NO" },
    { title: "Tax" },
    { title: "Name" },
    { title: "Ledger" },
    { title: "Validity" },
    { title : "Travel_Type"},
    { title: "Actions", className:"text-center" }
];

function t_list_reflect(){
    $('#div_taxes_list').append('<div class="loader"></div>');
    var active_flag = $('#active_flag_filter1').val();
    var tax_filter = $('#tax_filter').val();
    $.post('taxes_rules/list_reflect.php', {status:active_flag,tax_filter:tax_filter}, function(data){
	setTimeout(() => {
        pagination_load(data,columns1, true, false, 20, 'tax_rules_tab');
        $('.loader').remove();
    }, 1000);
  });
}
t_list_reflect();

function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('taxes_rules/save_rules.php', {type:'rule_master'}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal_content').html(data);
	});
}

function update_modal(rule_id){
	$.post('taxes_rules/update_modal.php', {rule_id : rule_id}, function(data){
		$('#div_modal_content').html(data);
	});
}
function copy_rule(rule_id){

    var base_url = $('#base_url').val();
	$.post(base_url+'controller/business_rules/taxes_rules/clone.php', {rule_id : rule_id}, function(data){
        success_msg_alert(data);
        t_list_reflect();
	});
}
function inclusive_checker(){
  if(($('input[name=\'applicable\']:checked').val() == 'on') && ($('#calc_mode').val() == 'Inclusive')){
      error_msg_alert('Inclusive Taxes Cannot Be Applied on Purchase');
      $("#applicable").prop("checked", false);
  }
}
</script>