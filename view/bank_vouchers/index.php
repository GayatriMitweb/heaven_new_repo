<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='bank_vouchers/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Bank Vouchers',87) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_cash_deposit" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_cash_deposit" name="rd_bank1" checked onchange="bank_dashboard_content_reflect()">
      &nbsp;&nbsp;Cash Deposits
  </label>
  <label for="rd_cash_withdraw" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_cash_withdraw" name="rd_bank1" onchange="bank_dashboard_content_reflect()">
      &nbsp;&nbsp;Cash Withdrawal
  </label>
  <label for="rd_inter_bank" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_inter_bank" name="rd_bank1" onchange="bank_dashboard_content_reflect()">
      &nbsp;&nbsp;Inter Bank Transfers
  </label>
</div>

<div id="div_bank_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
function bank_dashboard_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var id = $('input[name="rd_bank1"]:checked').attr('id');
  if(id=="rd_cash_deposit"){
      $.post('cash_deposit/index.php', {branch_status : branch_status}, function(data){
        $('#div_bank_dashboard_content').html(data);
      });
  }
  if(id=="rd_cash_withdraw"){
      $.post('cash_withdrawal/index.php', {branch_status : branch_status}, function(data){
        $('#div_bank_dashboard_content').html(data);
      });
  }
  if(id=="rd_inter_bank"){
      $.post('inter_banks/index.php', {branch_status : branch_status}, function(data){
        $('#div_bank_dashboard_content').html(data);
      });
  }
}
bank_dashboard_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>