<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
 
?>
<?= begin_panel('Cruise Supplier Information',27) ?>
<div class="row text-right mg_bt_20">
  <div class="col-sm-12 text_left_sm_xs">
    <button class="btn btn-info btn-sm ico_left" onclick="generic_city_save_modal()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;City</button>
    	&nbsp;&nbsp;
	<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal1"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cruise Supplier</button>
  </div>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="cruise_list_reflect()">
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select name="active_flag_filter" id="active_flag_filter" title="Status" onchange="cruise_list_reflect()">
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>    
    </div>
</div>


<div id="div_cruise_list" class="main_block"></div>
<div id="div_modal_content"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
city_lzloading('#city_id_filter');

function cruise_list_reflect()
{
	var active_flag = $('#active_flag_filter').val();
  var city_id = $('#city_id_filter').val();
  
	$.post('cruise_list_reflect.php', { active_flag : active_flag , city_id : city_id}, function(data){
		$('#div_cruise_list').html(data);
	});
}
cruise_list_reflect();
function save_modal()
{
    $.post('save_modal.php', {}, function(data){
        $('#btn_save_modal1').button('reset');
        $('#div_modal_content').html(data);
    });
}
function display_format_modal()
{
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/cruise_vendor.xlsx";
}

function excel_report()
{
    var active_flag = $('#active_flag_filter').val();
    var city_id = $('#city_id_filter').val();

    window.location = 'excel_report.php?active_flag='+active_flag+'&city_id='+city_id;
}

</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>