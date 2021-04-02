<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='other_expense/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Other Expense',83) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_expense_booking" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_expense_booking" name="rd_expense" checked  onchange="expense_dashboard_content_reflect()">
      &nbsp;&nbsp;Expense Booking
  </label>
  <label for="rd_expense_payment" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_expense_payment" name="rd_expense" onchange="expense_dashboard_content_reflect()">
      &nbsp;&nbsp;Payment
  </label>
</div>

<div id="div_expense_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function expense_dashboard_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var id = $('input[name="rd_expense"]:checked').attr('id');
  if(id=="rd_expense_booking"){
      $.post('booking/index.php', {branch_status : branch_status}, function(data){
        $('#div_expense_dashboard_content').html(data);
      });
  }
  if(id=="rd_expense_payment"){
      $.post('payment/index.php', {branch_status : branch_status}, function(data){
        $('#div_expense_dashboard_content').html(data);
      });
  }
}
expense_dashboard_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>