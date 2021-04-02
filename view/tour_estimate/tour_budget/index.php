<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#calculate_budget" aria-controls="calculate_budget" role="tab" data-toggle="tab">Calculate Budget</a></li>
    <li role="presentation"><a href="#tour_entities" aria-controls="tour_entities" role="tab" data-toggle="tab">Expense Title</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="calculate_budget">
      <?php include_once('budget_calculate/budget_calculate.php') ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tour_entities">
      <?php include_once('tour_entities/tour_entities_save.php') ?>
    </div>
  </div>

</div>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>