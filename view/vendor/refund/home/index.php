<?php
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');
?>
<div class="row text-right mg_bt_20"> <div class="col-md-12">
	<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
	<button class="btn btn-info btn-sm ico_left" id="btn_show_save_modal" onclick="save_modal()"><i class="fa fa-plus"></i>&nbsp;&nbsp;Refund</button>
</div> </div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<select id="estimate_id_filter" name="estimate_id_filter" style="width:100%" title="Supplier Costing">
		        <option value="">Supplier Costing</option>
		        <?php 
		        $sq_estimate = mysql_query("select * from vendor_estimate where status='Cancel' order by estimate_id desc");
		        while($row_estimate = mysql_fetch_assoc($sq_estimate)){
							$date = $row_estimate['purchase_date'];
							$yr = explode("-", $date);
							$year =$yr[0];
		          $vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);
		          ?>
		          <option value="<?= $row_estimate['estimate_id'] ?>"><?= get_vendor_estimate_id($row_estimate['estimate_id'],$year)." : ".$vendor_type_val."(".$row_estimate['vendor_type'].")" ?></option>
		          <?php
		        }
		        ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" id="payment_from_date_filter" name="payment_from_date_filter" placeholder="Payment From Date" title="Payment From Date">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<input type="text" id="payment_to_date_filter" name="payment_to_date_filter" placeholder="Payment To Date" title="Payment To Date">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>	

<div id="div_modal_content"></div>
<div id="div_list_content" class="main_block"></div>

<script>
$('#payment_from_date_filter, #payment_to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#estimate_id_filter').select2();
function save_modal()
{
	$('#btn_show_save_modal').button('loading');
	$.post('home/save_modal.php', {}, function(data){
	$('#btn_show_save_modal').button('reset');
		$('#div_modal_content').html(data);
	});
}
function update_modal(refund_id)
{
	$.post('home/update_modal.php', { refund_id : refund_id }, function(data){
		$('#div_modal_content').html(data);
	});
}

function list_reflect()
{
	var estimate_id = $('#estimate_id_filter').val();
	var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();

	$.post('home/list_reflect.php', { estimate_id : estimate_id, payment_from_date : payment_from_date, payment_to_date : payment_to_date }, function(data){
		$('#div_list_content').html(data);
	});
}
function estimate_id_reflect()
{
  var estimate_id= $('#estimate_id').val();
  $.post('home/refund_estimate_reflect.php', { estimate_id : estimate_id }, function(data)
    {
      $('#div_refund_estimate').html(data);
    });
}
function excel_report()
{
   	var estimate_id = $('#estimate_id_filter').val();
    var payment_from_date = $('#payment_from_date_filter').val();
	var payment_to_date = $('#payment_to_date_filter').val();
 
  	window.location = 'home/excel_report.php?estimate_id='+estimate_id+'&payment_from_date='+payment_from_date+'&payment_to_date='+payment_to_date;
}
list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>