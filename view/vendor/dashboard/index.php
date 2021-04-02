<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='vendor/dashboard/index.php'"));
$branch_status = $sq['branch_status'];
?>
<?= begin_panel('Purchase & Payment Dashboard',62) ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>">
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_payment_estimate" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_payment_estimate" name="rd_vendor_payment1" checked  onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;Purchase Cost
  </label>
  <label for="rd_vendor_advance" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_vendor_advance" name="rd_vendor_payment1" onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;PrePurchase Adv
  </label>
  <label for="rd_vendor_payments" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_vendor_payments" name="rd_vendor_payment1" onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;Payment
  </label>
  <label for="rd_vendor_payment" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_vendor_payment" name="rd_vendor_payment1" onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;MultiPayment
  </label>
  <label for="rd_report" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_report" name="rd_vendor_payment1" onchange="vendor_dashboard_content_reflect()">
      &nbsp;&nbsp;Report
  </label>
</div>

<div id="div_vendor_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>

<script>

function vendor_dashboard_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var id = $('input[name="rd_vendor_payment1"]:checked').attr('id');
  if(id=="rd_payment_estimate"){
      $.post('estimate/index.php', {branch_status : branch_status}, function(data){
        $('#div_vendor_dashboard_content').html(data);
      });
  }
  if(id=="rd_vendor_advance"){
      $.post('advances/index.php', {branch_status : branch_status}, function(data){
        $('#div_vendor_dashboard_content').html(data);
      });
  }
  if(id=="rd_vendor_payments"){
      $.post('multiple_invoice_payment/index.php', {branch_status : branch_status}, function(data){
        $('#div_vendor_dashboard_content').html(data);
      });
  }
  if(id=="rd_vendor_payment"){
      $.post('payment/index.php', {branch_status : branch_status}, function(data){
        $('#div_vendor_dashboard_content').html(data);
      });
  }
  if(id=="rd_report"){
      $.post('report/index.php', {branch_status : branch_status}, function(data){
        $('#div_vendor_dashboard_content').html(data);
      });
  }
}
vendor_dashboard_content_reflect();
</script>
<script src="../js/vendor_master.js"></script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>