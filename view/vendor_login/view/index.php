<?php 
include "../../../model/model.php";
include_once('layouts/admin_header.php');
?>
<div class="app_panel">
  <div class="app_panel_head mg_bt_20">
      <h2 class="pull-left">Quotation Request</h2>
  </div>
  <div id="div_request_list" class="main_block"></div>
</div>

<script>
function vendor_requests_reflect()
{
	$.post('quotation_request/vendor_requests_reflect.php', {  }, function(data){
		$('#div_request_list').html(data);
	});
}
vendor_requests_reflect();
function vendor_request_view_modal(entry_id)
{
	$.post('quotation_request/quotation_request_view_modal.php', { entry_id : entry_id }, function(data){
		$('#div_bid_modal').html(data);
	});
}
</script>
<?php 
include_once('layouts/admin_footer.php');
?>