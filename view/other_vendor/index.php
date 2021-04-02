<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Other Suppliers Information',31) ?>

<div class="row text-right mg_bt_20">
	<button class="btn btn-info btn-sm ico_left" onclick="generic_city_save_modal()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;City</button>
    	&nbsp;&nbsp;
	<button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Other Supplier</button>
</div>
<div class="app_panel_content Filter-panel">
   <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="list_reflect()">
            </select>
        </div>
		<div class="col-md-3 col-sm-6">
	        <select name="active_flag_filter" id="active_flag_filter" title="Status" onchange="list_reflect()">
	            <option value="">Status</option>
	            <option value="Active">Active</option>
	            <option value="Inactive">Inactive</option>
	        </select>
	    </div>   
	</div>
</div>

<div id="div_modal"></div>
<div id="div_list" class="main_block loader_parent"></div>
<div id="div_modal_view"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
city_lzloading('#city_id_filter');
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#div_modal').html(data);
		$('#btn_save_modal').button('reset');
	});
}
function update_modal(vendor_id)
{	
	$.post('update_modal.php', { vendor_id : vendor_id}, function(data){
		$('#div_modal').html(data);
	});
}
function view_modal(vendor_id)
{
	$.post('view_modal.php', { vendor_id : vendor_id}, function(data){
		$('#div_modal_view').html(data);
	});
}
function list_reflect()
{
	$('#div_list').append('<div class="loader"></div>');
	var active_flag = $('#active_flag_filter').val();
	var city_id = $('#city_id_filter').val();
	$.post('list_reflect.php', {active_flag : active_flag, city_id : city_id}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();
</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>