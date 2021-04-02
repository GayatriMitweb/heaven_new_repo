<?php 
include "../../../../model/model.php";
include_once('../layouts/admin_header.php');
?>
<div class="app_panel">

  <div class="app_panel_head mg_bt_20">
      <h2 class="pull-left">B2B Booking Summary</h2>
  </div>
 <div id="table_div" class="main_block"></div>
 <div id="view_modal" class="main_block"></div>
</div>
<script>
function list_reflect()
{
	$.post('list_reflect.php', {}, function(data){
		$('#table_div').html(data);
	});
}
function view_modal(id){
  $.post('view/index.php', {id:id}, function(data){
		$('#view_modal').html(data);
	});
}
list_reflect();
</script>
<?php 
include_once('../layouts/admin_footer.php');
?>