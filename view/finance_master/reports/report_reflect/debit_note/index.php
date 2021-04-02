<?php include "../../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<input type="text" id="to_date_filter" onchange="report_reflect()" name="to_date_filter" placeholder="Till Date" title="Till Date">
		</div>
	</div>
</div>

<hr>

<div id="div_report" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="sales_reg" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="customer_name"></div>
<script type="text/javascript">
$('#gl_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
var column = [
	{ title: "S_No." },
	{ title: "date" },
	{ title: "supplier_name" },
	{ title: "purchase_type" },
	{ title: "amount" , className: "success"}
];
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	$.post('report_reflect/debit_note/report_reflect.php',{to_date : to_date,branch_status : branch_status, role : role,branch_admin_id : branch_admin_id}, function(data){
		pagination_load(data, column, true, false, 20, 'sales_reg');
		$('.loader').remove();
	});
}
report_reflect();
function excel_report()
{
	var to_date = $('#to_date_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	window.location = 'report_reflect/debit_note/excel_report.php?to_date='+to_date+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>