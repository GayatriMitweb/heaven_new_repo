<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='income/dashboard/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Other Receipts',82) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_income_advance" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_income_advance" name="rd_income_payment1" checked onchange="income_dashboard_content_reflect()">
      &nbsp;&nbsp;Advances
  </label>
  <label for="rd_income_payment" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_income_payment" name="rd_income_payment1" onchange="income_dashboard_content_reflect()">
      &nbsp;&nbsp;Sales Receipt
  </label>
  <label for="rd_other" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_other" name="rd_income_payment1" onchange="income_dashboard_content_reflect()">
      &nbsp;&nbsp;Other Income
  </label>
</div>

<div id="div_income_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function income_dashboard_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var id = $('input[name="rd_income_payment1"]:checked').attr('id');
  if(id=="rd_income_advance"){
      $.post('corporate_advance/index.php', {branch_status : branch_status}, function(data){
        $('#div_income_dashboard_content').html(data);
      });
  }
  if(id=="rd_income_payment"){
      $.post('sales/index.php', {branch_status : branch_status}, function(data){
        $('#div_income_dashboard_content').html(data);
      });
  }
  if(id=="rd_other"){
      $.post('other_income/index.php', {branch_status : branch_status}, function(data){
        $('#div_income_dashboard_content').html(data);
      });
  }
}
income_dashboard_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>