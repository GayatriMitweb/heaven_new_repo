<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<?= begin_panel('Tour Expense') ?>

<div class="row"> <div class="col-md-12 text-center">
<div>

  <ul class="nav nav-tabs responsive" role="tablist">
    <li role="presentation" class="active"><a href="#group_tour_expense_tab" aria-controls="group_tour_expense_tab" role="tab" data-toggle="tab">Group Tour Expense</a></li>
    <li role="presentation"><a href="#package_tour_expense_tab" aria-controls="profile" role="package_tour_expense_tab" data-toggle="tab">Package Tour Expense</a></li>
    <!-- <li role="presentation"><a href="#entity_tab" aria-controls="profile" role="entity_tab" data-toggle="tab">Entity</a></li> -->
  </ul>

  <div class="tab-content responsive main_block">
    <div role="tabpanel" class="tab-pane active mg_tp_20 no-marg-sm-xs" id="group_tour_expense_tab">
    	<?php include_once('group_tour/tour_expense_save_select.php'); ?>
    </div>
    <div role="tabpanel" class="tab-pane mg_tp_20 no-marg-sm-xs" id="package_tour_expense_tab">
    	<?php include_once('package_tour/tour_expense_save_select.php'); ?>
    </div><!-- 
    <div role="tabpanel" class="tab-pane mg_tp_20 no-marg-sm-xs" id="entity_tab">
      <?php include_once('tour_entities/tour_entities_save.php'); ?>
    </div> -->
  </div>

</div>

</div> </div>

<?= end_panel() ?>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>