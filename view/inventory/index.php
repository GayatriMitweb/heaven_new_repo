<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='inventory/index.php'"));
$branch_status = $sq['branch_status'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<?= begin_panel('Inventory Management','') ?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >
<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_hotel_inv" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_hotel_inv" name="rd_inventory1" checked onchange="inventory_dashboard_content_reflect()">
      &nbsp;&nbsp;Hotel
  </label>
  <label for="rd_exc_inv" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_exc_inv" name="rd_inventory1" onchange="inventory_dashboard_content_reflect()">
      &nbsp;&nbsp;Excursion
  </label>
</div>

<div id="div_inventory_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
function inventory_dashboard_content_reflect()
{ 
  var branch_status = $('#branch_status').val();
  var branch_admin_id = $('#branch_admin_id').val();
  var id = $('input[name="rd_inventory1"]:checked').attr('id');
  if(id=="rd_hotel_inv"){
      $.post('hotel/index.php', {branch_status:branch_status,branch_admin_id:branch_admin_id }, function(data){
        $('#div_inventory_dashboard_content').html(data);
      });
  }
  if(id=="rd_exc_inv"){
      $.post('excursion/index.php', {branch_status:branch_status,branch_admin_id:branch_admin_id }, function(data){
        $('#div_inventory_dashboard_content').html(data);
      });
  }
}
inventory_dashboard_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>