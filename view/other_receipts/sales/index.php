<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
include_once('payment_save_modal.php');
?>
<div class="app_panel_content Filter-panel">
	<div class="row mg_bt_10 text-center">
		<div class="col-md-12">
			<button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#s_payment_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Receipt</button>
		</div>
	</div>
</div>


<script>
$('#cust_id_filter1').select2();
function get_customer_outstanding(cust_id,for_id)
{
	var cust_id = $('#'+cust_id).val();
	$.post('sales/get_customer_outstanding.php', { cust_id : cust_id }, function(data){
		$('#'+for_id).html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>