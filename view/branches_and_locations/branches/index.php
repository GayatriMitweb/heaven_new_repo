<?php 
include_once('../../../model/model.php');
?>
<div class="row mg_bt_20">
<div class="col-md-12 text-right">
  <button class="btn btn-info btn-sm ico_left" onclick="branche_save_modal()" title="Add new Branch"><i class="fa fa-plus"></i>&nbsp;&nbsp;Branch</button>
</div>
</div>
<div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3 col-sm-6 text-left"> 
      <select name="location_id_filter" id="location_id_filter" title="Select Location" onchange="branches_list_reflect(this.value)" style="width: 100%">
        <?php get_locations_dropdown(); ?>
      </select>
    </div>
  </div>
</div>
<input type="hidden" name="branch_count" id="branch_count">
 <div id="div_branch_save_modal"></div>
 <div id="branch_list_div" class="main_block"></div>

<script>
$('#location_id_filter').select2();
function branche_save_modal()
{
  check_package_type('<?= $setup_package ?>','branch');
  var branch_count = $('#branch_count').val();
  if(<?= $setup_package ?> == '1' || <?= $setup_package ?> == '2'){
  		if(branch_count == '0'){
  			$.post('branches/branches_save_modal.php', {}, function(data){
		      $('#div_branch_save_modal').html(data);
		    });
  		}
  		else {
  			$('#package_permission').removeClass('hidden');   
  		}
  }
  else{
  	$.post('branches/branches_save_modal.php', {}, function(data){
      $('#div_branch_save_modal').html(data);
    });
  }
}
</script>

<script src="js/branch.js"></script>