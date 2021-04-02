<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Transfer Tariff',2) ?>
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_master" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_master" name="app_transfer" checked>
      &nbsp;&nbsp;Vehicle
  </label>
  <label for="rd_tariff" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_tariff" name="app_transfer">
      &nbsp;&nbsp;Tariff
  </label>
</div>

<div class="app_panel_content">
  <div class="row transfer_panel">
    <div class="col-md-12">
        <div id="locations_panel">
            <?php include_once('master/index.php'); ?>
        </div>
    </div>
  </div>
  <div class="row transfer_panel hidden">
    <div class="col-md-12">
        <div id="branches_panel">
        	<?php include_once('tariff/index.php'); ?>
        </div>
    </div>
  </div>
</div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
	$(function(){
		$('input[name="app_transfer"]').change(function(){
			$('.transfer_panel').toggleClass('hidden');
		});
	});
</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>