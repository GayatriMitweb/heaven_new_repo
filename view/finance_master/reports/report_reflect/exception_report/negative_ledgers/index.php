<?php include "../../../../../../model/model.php"; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>

<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">

<div class="row mg_bt_10">
		<div class="col-xs-12 text-right">
			<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
		</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
			<select name="ledger_name" id="ledger_name" title="Ledger Name" style="width:100%;" onchange="report_reflect_n();">
				<option value="">Select Ledger</option>
				<?php 
				$query1 = mysql_query("select * from ledger_master where 1 ");
				while($row_ledger = mysql_fetch_assoc($query1)){ ?>
					<option value="<?= $row_ledger['ledger_id'] ?>"><?= $row_ledger['ledger_name'] ?></option>
				<?php 	} ?>
			</select>
		</div>
	</div>
</div>
<hr>
<!-- <div id="div_report" class="main_block loader_parent"></div> -->
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="pay_age" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>
<script type="text/javascript">
$('#ledger_name').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
var column = [
{ title : "S_No."},
{ title:"Ledger"},
{ title : "Date"},
{ title : "Balance"},
{ title : "DR/CR"}
];
function report_reflect_n()
{
	$('#div_report').append('<div class="loader"></div>');
	var base_url = $('#base_url').val();
	var ledger_name = $('#ledger_name').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	$.post(base_url+'view/finance_master/reports/report_reflect/exception_report/negative_ledgers/report_reflect.php',{ ledger_name : ledger_name, branch_status : branch_status , role : role,branch_admin_id : branch_admin_id}, function(data){	
		pagination_load(data, column, true, false, 20, 'pay_age');
	});
}
report_reflect_n();
function excel_report()
{
	var ledger_name = $('#ledger_name').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
    window.location = 'report_reflect/exception_report/negative_ledgers/excel_report.php?ledger_name='+ledger_name+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>