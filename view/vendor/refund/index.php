<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('Supplier Refund',63) ?> 

<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_estimate" class="app_dual_button active mg_bt_10">
      <input type="radio" id="rd_estimate" name="rd_refund" checked onchange="vendor_refund_content_reflect()">
      &nbsp;&nbsp;Purchase Cancellation
  </label>
  <label for="rd_home" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_home" name="rd_refund"  onchange="vendor_refund_content_reflect()">
      &nbsp;&nbsp;Refund
  </label>  
</div>

<div id="div_vendor_refund_content"></div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script>
function vendor_refund_content_reflect()
{
  var id = $('input[name="rd_refund"]:checked').attr('id');
  if(id=="rd_estimate"){
      $.post('estimate/index.php', {}, function(data){
        $('#div_vendor_refund_content').html(data);
      });
  } 
  if(id=="rd_home"){
      $.post('home/index.php', {}, function(data){
        $('#div_vendor_refund_content').html(data);
      });
  }  
}
vendor_refund_content_reflect();
</script>
<script src="../js/vendor_master.js"></script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>