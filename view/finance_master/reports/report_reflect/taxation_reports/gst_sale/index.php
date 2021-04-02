<?php include "../../../../../../model/model.php"; ?>
<?php
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status']; 
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >

<div class="row mg_bt_10">
	<div class="col-xs-12 text-right">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-2">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-2">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date">
		</div>
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="gst_on_sale" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>

<script type="text/javascript">
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
var column = [
{ title : "S_No."},
{ title : "Service_Name"},
{ title : "SAC/HSN_Code"},
{ title : "Customer_Name"},
{ title : "GSTIN/UIN"},
{ title : "Account_State"},
{ title : "Booking_ID"},
{ title : "Booking_Date"},
{ title : "Type_of_Supplies"},
{ title : "Place_of_Supply"},
{ title : "NET_AMOUNT"},
{ title : "Taxable_Amount"},
{ title : "TAX%"},
{ title : "TAX_Amount"},
{ title : "Markup"},
{ title : "TAX%_On_Markup"},
{ title : "TAX_amount_On_Markup"},
{ title : "Cess%"},
{ title : "Cess_Amount"},
{ title : "ITC_Eligibility"},
{ title : "Reverse_Charge"}
];
function report_reflect()
{
	$('#div_report_gstsale').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
	 
	$.post('report_reflect/taxation_reports/gst_sale/report_reflect.php',{ from_date : from_date, to_date : to_date , branch_status : branch_status }, function(data){
		// console.log({data});
		pagination_load(data, column, true, true, 20, 'gst_on_sale');
	});
}
report_reflect();

 function excel_report()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
	window.location = 'report_reflect/taxation_reports/gst_sale/excel_report.php?from_date='+from_date+'&to_date='+to_date;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>