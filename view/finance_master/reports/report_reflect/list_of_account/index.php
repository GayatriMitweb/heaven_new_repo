<?php include "../../../../../model/model.php"; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];

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
<input type="hidden" name="financial_year_id" id="financial_year_id" value="<?= $financial_year_id ?>">

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="Till Date" title="Till Date">
		</div>
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>	
	</div>
</div>

<hr>

<div id="div_report" class="main_block loader_parent"></div>
<script type="text/javascript">
$('#gl_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var branch_id_filter = $('#branch_id_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var financial_year_id = $('#financial_year_id').val();
	var role = $('#role').val();
	$.post('report_reflect/list_of_account/report_reflect.php',{ from_date : from_date ,branch_status : branch_status, role : role,branch_admin_id : branch_admin_id,financial_year_id : financial_year_id  }, function(data){
		$('#div_report').html(data);
	});
}
report_reflect();


function excel_report()
{
	var from_date = $('#from_date_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var financial_year_id = $('#financial_year_id').val();
	var role = $('#role').val();
	
	window.location = 'report_reflect/list_of_account/excel_report.php?from_date='+from_date+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role+'&financial_year_id='+financial_year_id;
}
 
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>