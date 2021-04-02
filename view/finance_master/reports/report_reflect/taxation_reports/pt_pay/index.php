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
		<div class="col-md-3 col-sm-6">
			<select name="month_filter" style="width: 100%" onchange="report_reflect()" id="month_filter" title="Month">
				<option value="">Month</option>
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>

		</div>
		
	</div>
</div>
<hr>
<div id="div_report_pt" class="main_block"></div>
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="pt_pay" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>
<script type="text/javascript">
$('#month_filter').select2(); 
var column = [
{ title : "S_No."},
{ title:"User_ID", className:"text-center"},
{ title : "User_Name"},
{ title : "Gross_Salary"},
{ title : "PT Deducted"}
]; 
function report_reflect()
{
	var month = $('#month_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
 
	$.post('report_reflect/taxation_reports/pt_pay/report_reflect.php',{  month : month ,branch_status : branch_status, role : role,branch_admin_id : branch_admin_id }, function(data){
		// console.log(data);
		pagination_load(data, column, true, false, 20, 'pt_pay');
	});
}

function excel_report()
{
	var month = $('#month_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();

	window.location = 'report_reflect/taxation_reports/pt_pay/excel_report.php?month='+month+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>