<?php 
include_once('../../../../model/model.php');
$branch_status = $_POST['branch_status'];
?><div class="row text-right mg_bt_20">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="vendor_type2" id="vendor_type2" title="Supplier Type" onchange="vendor_type_data_load(this.value, 'div_vendor_type_content2')">
				<option value="">Supplier Type</option>
				<?php 
				$sq_vendor = mysql_query("select * from vendor_type_master order by vendor_type");
				while($row_vendor = mysql_fetch_assoc($sq_vendor)){
					?>
					<option value="<?= $row_vendor['vendor_type'] ?>"><?= $row_vendor['vendor_type'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div id="div_vendor_type_content2"></div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="estimate_type2" id="estimate_type2" title="Purchase Type" onchange="payment_for_data_load(this.value, 'div_payment_for_content2')">
				<option value="">Purchase Type</option>
				<?php 
				$sq_estimate_type = mysql_query("select * from estimate_type_master order by estimate_type");
				while($row_estimate = mysql_fetch_assoc($sq_estimate_type)){
					?>
					<option value="<?= $row_estimate['estimate_type'] ?>"><?= $row_estimate['estimate_type'] ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div id="div_payment_for_content2"></div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="from_date" name="from_date" class="form-control" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<input type="text" id="to_date" name="to_date" class="form-control" placeholder="To Date" title="To Date">
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 text-left">
			<button class="btn btn-sm btn-info ico_right" onclick="report_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

</div>
<div id="div_report_list" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="report" class="table table-hover mg_tp_20" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>

<script>
$('#from_date, #to_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

var column = [
	{ title : "S_No."},
	{ title:"Supplier_Type", className:"text-center"},
	{ title : "Purchase_ID"},
	{ title : "Purchase_Type"},
	{ title : "Supplier_Name"},
	{ title : "Date"},
	{ title : "Credit", className:"info text-right"},
	{ title : "Debit", className:"success text-right"}
];
function report_list_reflect()
{
	$('#div_report_list').append('<div class="loader"></div>');
	
	var estimate_type = $('#estimate_type2').val();
	var vendor_type = $('#vendor_type2').val();
	var branch_status = $('#branch_status').val();
	var estimate_type_id = get_estimate_type_id('estimate_type2');
 	var vendor_type_id = get_vendor_type_id('vendor_type2');
 	var branch_status = $('#branch_status').val();
 	var from_date = $('#from_date').val();
 	var to_date = $('#to_date').val();
	$.post('report/report_list_reflect.php', { estimate_type : estimate_type, estimate_type_id : estimate_type_id, vendor_type : vendor_type, vendor_type_id : vendor_type_id , branch_status : branch_status,from_date : from_date, to_date : to_date}, function(data){
		pagination_load(data, column, true, true, 20, 'report');
		$('.loader').remove();
	});
}
function excel_report()
{
	var estimate_type = $('#estimate_type2').val();
	var vendor_type = $('#vendor_type2').val();
	var branch_status = $('#branch_status').val();
	var estimate_type_id = get_estimate_type_id('estimate_type2');
 	var vendor_type_id = get_vendor_type_id('vendor_type2');
 	var from_date = $('#from_date').val();
 	var to_date = $('#to_date').val();

	window.location = 'report/excel_report.php?estimate_type='+estimate_type+'&vendor_type='+vendor_type+''+'&vendor_type_id='+vendor_type_id+''+'&estimate_type='+estimate_type+''+'&estimate_type_id='+estimate_type_id+'&branch_status='+branch_status+'&from_date='+from_date+'&to_date='+to_date;
}
report_list_reflect();
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>