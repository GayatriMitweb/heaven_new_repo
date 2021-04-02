<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Supplier Packages',19) ?>

<div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>Package</button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
   <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter" name="city_id_filter" style="width:100%" title="Select City Name" onchange="list_reflect()">
            </select>
        </div>
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
			<select name="supplier_id_filter" id="supplier_id_filter" title="Select Supplier Type" style="width:100%" onchange="list_reflect()">
			   <option value="">Supplier Type</option>		              
			   <option value="Hotel">Hotel</option>		              
			   <option value="Transport">Transport</option>	
			   <option value="Car Rental">Car Rental</option>	
			   <option value="DMC">DMC</option>	
			   <option value="Visa">Visa</option>	
			   <option value="Passport">Passport</option>	
			   <option value="Ticket">Ticket</option>	
			   <option value="Excursion">Excursion</option>	
			   <option value="Insuarance">Insuarance</option>	
			   <option value="Train Ticket">Train Ticket</option>	
			   <option value="Other">Other</option>	
			   <option value="Bus">Bus</option>	
			   <option value="Forex">Forex</option>	
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
<div id="div_list" class="main_block loader_parent"></div>

<div id="div_modal"></div>

<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script>
city_lzloading('#city_id_filter');
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}
function list_reflect()
{
	$('#div_list').append('<div class="loader"></div>');
	var active_flag = $('#active_flag_filter').val();
	var supplier_id = $('#supplier_id_filter').val();
	var city_id = $('#city_id_filter').val();

	$.post('list_reflect.php', {active_flag : active_flag, city_id : city_id, supplier_id : supplier_id}, function(data){
		$('#div_list').html(data);
	});
}
list_reflect();

function update_modal(package_id)
{
	$.post('update_modal.php', {package_id : package_id}, function(data){
		$('#div_modal').html(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>