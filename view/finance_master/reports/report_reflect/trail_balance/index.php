<?php include "../../../../../model/model.php"; 
$financial_year_id = $_SESSION['financial_year_id']; 
$branch_admin_id = $_SESSION['branch_admin_id'];
?>

<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">

<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter2" id="from_date_filter2" placeholder="Till Date" title="Till Date" onchange="report_reflect()">
		</div>
	</div>
</div>

<hr>

<div id="div_report_trail" class="main_block loader_parent"></div>
<script type="text/javascript">
$('#gl_id_filter').select2();
$('#from_date_filter2').datetimepicker({ timepicker:false, format:'d-m-Y' });
function report_reflect()
{
	$('#div_report_trail').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter2').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
	$.post('report_reflect/trail_balance/report_reflect.php',{ from_date : from_date,branch_admin_id : branch_admin_id,financial_year_id : financial_year_id}, function(data){
		$('#div_report_trail').html(data);
	});
}
report_reflect();
function excel_report()
{
 	var from_date = $('#from_date_filter2').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
  window.location = 'report_reflect/trail_balance/excel_report.php?from_date='+from_date+'&financial_year_id='+financial_year_id+'&branch_admin_id='+branch_admin_id;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>