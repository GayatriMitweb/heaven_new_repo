<?php 
include "../../../../model/model.php";
include_once('../layouts/admin_header.php');
?>
<div class="app_panel">

  <div class="app_panel_head mg_bt_20">
      <h2 class="pull-left">Booking Summary</h2>
  </div>
 <div id="div_vendor_estimate_list" class="main_block"></div>
</div>
<script>
function vendor_estimate_list_reflect()
{
	$.post('vendor_estimate_list_reflect.php', {}, function(data){
		$('#div_vendor_estimate_list').html(data);
	});
}
vendor_estimate_list_reflect();
</script>
<?php 
include_once('../layouts/admin_footer.php');
?>