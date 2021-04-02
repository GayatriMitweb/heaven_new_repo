<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<?= begin_panel('B2B Agent',0) ?>

<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="registration" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="registration" name="registration1" checked onchange="customer_content_reflect()">
      &nbsp;&nbsp;Registration
  </label>
  <label for="creditm" class="app_dual_button mg_bt_10">
      <input type="radio" id="creditm" name="registration1" onchange="customer_content_reflect()">
      &nbsp;&nbsp;Credit Management
  </label>
</div>

<div id="customer_dashboard_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    
<script>
function customer_content_reflect(){
  var branch_status = $('#branch_status').val();
  var id = $('input[name="registration1"]:checked').attr('id');
  if(id=="registration"){
      $.post('b2b_registration.php', {branch_status : branch_status}, function(data){
        $('#customer_dashboard_content').html(data);
      });
  }
  if(id=="creditm"){
      $.post('credit_management/index.php', {branch_status : branch_status}, function(data){
        $('#customer_dashboard_content').html(data);
      });
  }
}
customer_content_reflect();
</script>

<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>