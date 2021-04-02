<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Clearance',2) ?>

<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_cheque" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_cheque" name="app_clearance" checked>
      &nbsp;&nbsp;Cheque
  </label>
  <label for="rd_credit" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_credit" name="app_clearance">
      &nbsp;&nbsp;Credit Card
  </label>
</div>

<div class="app_panel_content">
  <div class="row clearance_panel">
    <div class="col-md-12">
        <div id="cheque_panel">
            <?php include_once('cheque/index.php'); ?>
        </div>
    </div>
  </div>
  <div class="row clearance_panel hidden">
    <div class="col-md-12">
        <div id="credit_card_panel">
        	<?php include_once('credit_card/index.php'); ?>
        </div>
    </div>
  </div>
</div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
	$(function(){
		$('input[name="app_clearance"]').change(function(){
			$('.clearance_panel').toggleClass('hidden');
		});
	});
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>