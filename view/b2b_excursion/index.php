<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Activity',17) ?>

<div class="row text-right">
	<div class="col-md-12 mg_bt_20">
		<button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>Activity</button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
   <div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_sm_xs">
            <select id="city_id_filter1" name="city_id_filter1" style="width:100%" title="Select City Name" onchange="list_reflect()">
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="active_flag_filter" id="active_flag_filter" title="Status" data-toggle="tooltip" onchange="list_reflect()" style="width:100%" class='form-control'>
                <option value="">Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<div id="div_list" class="main_block loader_parent mg_tp_20">
 <div class="table-responsive">
        <table id="exc_master_tab" class="table table-hover" style="margin: 20px 0 !important;">         
        </table>
    </div>
</div>
<div id="div_modal"></div>

<?= end_panel() ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>
city_lzloading('#city_id_filter1');
function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}

var columns= [
          { title: "S_NO" },
          { title: "City" },
          { title: "Activity_Name" },
          { title: "Pickup_Point" },
          { title: "Duration" },
          { title: "Currency" },
          { title: "Actions", className:"text-center" }
      ];
function list_reflect()
{
  	$('#div_list').append('<div class="loader"></div>');
	var active_flag = $('#active_flag_filter').val();
	var city_id = $('#city_id_filter1').val();

    $.post('list_reflect.php', {active_flag : active_flag, city_id : city_id}, function(data){
	setTimeout(() => {
		pagination_load(data,columns, true, false, 20, 'exc_master_tab');
		$('.loader').remove();
    }, 800);
  });
}
list_reflect();

function update_modal(service_id){
	$.post('update_modal.php', {entry_id : service_id}, function(data){
		$('#div_modal').html(data);
	});
}
function time_slotupdate_modal(entry_id){
	$.post('time_slot_update.php', {entry_id : entry_id}, function(data){
		$('#div_modal').html(data);
	});
}
function display_format_modal(){
    var base_url = $('#base_url').val();
    window.location = base_url+"images/csv_format/tour_excursions.csv";
}
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>