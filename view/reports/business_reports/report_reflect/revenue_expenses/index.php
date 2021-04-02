<?php
include "../../../../../model/model.php";
?>
<div class="row text-center"> <div class="col-md-12 ">
<div class="app_panel_content">

  <ul class="nav nav-tabs responsive" role="tablist">
    <li role="presentation" class="active"><a href="#group_tour_expense_tab" aria-controls="group_tour_expense_tab" role="tab" data-toggle="tab">Group Tour</a></li>
    <li role="presentation"><a href="#package_tour_expense_tab" aria-controls="profile" role="package_tour_expense_tab" data-toggle="tab">Package Tour</a></li>
    <li role="presentation"><a href="#other_tour_tab" aria-controls="profile" role="other_tour_tab" data-toggle="tab">Other Sale</a></li>
  </ul>
  <div class="tab-content responsive main_block">
    <div role="tabpanel" class="tab-pane active mg_tp_20 no-marg-sm-xs" id="group_tour_expense_tab">
    	<?php include_once('group_tour/tour_expense_save_select.php'); ?>
    </div>
    <div role="tabpanel" class="tab-pane mg_tp_20 no-marg-sm-xs" id="package_tour_expense_tab">
    	<?php include_once('package_tour/package_tour_expense_select.php'); ?>
    </div> 
    <div role="tabpanel" class="tab-pane mg_tp_20 no-marg-sm-xs" id="other_tour_tab">
      <?php include_once('other_sale/tour_expense_save_select.php'); ?>
    </div>
  </div>

</div>

</div> </div>
<script type="text/javascript">
    
</script>
