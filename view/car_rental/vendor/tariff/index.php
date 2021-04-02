<?php
include "../../../../model/model.php";

?>

<div class="row text-right mg_bt_20">
    <div class="col-md-12 text-right">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Car Rental tariff</button>
    </div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
			<select name="vehicle_name1" id="vehicle_name1" title="Vehicle Name" class="form-control">
                <option value="">*Select Vehicle</option>
                <?php
                    $sql = mysql_query("select * from b2b_transfer_master");
                    while($row = mysql_fetch_assoc($sql)){ 
                    ?>
                        <option value="<?= $row['vehicle_name']?>"><?= $row['vehicle_name']?></option>
                <?php }  ?>
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
$('#vehicle_name1').select2();
function tarrif_list_reflect()
{
	var active_flag = $('#active_flag_filter').val();
	var vehicle_name = $('#vehicle_name1').val();
	$.post('tariff/tarrif_list_reflect.php', { active_flag : active_flag, vehicle_name : vehicle_name }, function(data){
		$('#div_vendors_list').html(data);
	});
}
tarrif_list_reflect();
function vendor_update_modal(entry_id)
{
	$.post('tariff/tariff_update_modal.php', { entry_id : entry_id }, function(data){
		// console.log(data);
		$('#div_vendors_update').html(data);
	});
}
function vendor_view_modal(entry_id)
{
	$.post('tariff/view_modal.php', { entry_id : entry_id}, function(data){
		$('#div_vendors_view').html(data);
	});
}
function save_modal()
{
	$('#btn_save_modal').button('loading');
	$.post('tariff/vendor_tarrif_save.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_vendors_update').html(data);
	});
}
</script>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>
