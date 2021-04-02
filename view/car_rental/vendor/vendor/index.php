<?php
include "../../../../model/model.php";

?>

<div class="row text-right mg_bt_20">
    <div class="col-md-12 text-right">
    	<button class="btn btn-info btn-sm ico_left mg_bt_10_sm_xs" onclick="generic_city_save_modal()" id="btn_city_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;City</button>
    	&nbsp;&nbsp;
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Car Rental Supplier</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="vendor_list_reflect()">
            </select>
        </div>
		<div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
	        <select name="active_flag_filter" id="active_flag_filter" title="Status" onchange="vendor_list_reflect()">
	            <option value="">Status</option>
	            <option value="Active">Active</option>
	            <option value="Inactive">Inactive</option>
	        </select>
	    </div>   
	</div>
</div>



<div id="div_vendors_list" class="main_block"></div>
<div id="div_vendors_update"></div>
<div id="div_vendors_view"></div>

<?= end_panel() ?>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
city_lzloading('#city_id_filter');
function vendor_list_reflect()
{
	var active_flag = $('#active_flag_filter').val();
	var city_id = $('#city_id_filter').val();
	$.post('vendor/vendor_list_reflect.php', { active_flag : active_flag, city_id : city_id }, function(data){
		$('#div_vendors_list').html(data);
	});
}
vendor_list_reflect();
function vendor_update_modal(vendor_id)
{
	$.post('vendor/vendor_update_modal.php', { vendor_id : vendor_id}, function(data){
		$('#div_vendors_update').html(data);
	});
}
function vendor_view_modal(vendor_id)
{
	$.post('vendor/view_modal.php', { vendor_id : vendor_id}, function(data){
		$('#div_vendors_view').html(data);
	});
}
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('vendor/vendor_save.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_vendors_update').html(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>
