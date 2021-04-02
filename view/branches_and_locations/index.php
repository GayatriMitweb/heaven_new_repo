<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Locations And Branches',2) ?>

<div class="alert alert-danger hidden" role="alert" id="package_permission">
 Please upgrade the subscription to add more branches.
 <button type="button" class="close" onclick="remove_hidden_class()"><span>x</span></button>
</div>

<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_cash_deposit" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_cash_deposit" name="app_reports" checked>
      &nbsp;&nbsp;Location
  </label>
  <label for="rd_cash_withdraw" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_cash_withdraw" name="app_reports">
      &nbsp;&nbsp;Branches
  </label>
</div>

<div class="app_panel_content">
  <div class="row branches_and_locations_panel">
    <div class="col-md-12">
        <div id="locations_panel">
            <?php include_once('locations/index.php'); ?>
        </div>
    </div>
  </div>
  <div class="row branches_and_locations_panel hidden">
    <div class="col-md-12">
        <div id="branches_panel">
        	<?php include_once('branches/index.php'); ?>
        </div>
    </div>
  </div>
</div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
	$(function(){
		$('input[name="app_reports"]').change(function(){
			$('.branches_and_locations_panel').toggleClass('hidden');
		});
	});
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>