<?php include "../../../../../model/model.php"; 
$financial_year_id = $_SESSION['financial_year_id']; 
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<input type="hidden" name="financial_year_id" id="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" name="branch_admin_id" id="branch_admin_id" value="<?= $branch_admin_id ?>">

<div class="row text-right mg_bt_10">
	<div class="col-md-6 col-md-offset-6 text-right">		
		<button class="btn btn-pdf btn-sm mg_bt_10" onclick="excel_report()" id="print_button" title="Print"><i class="fa fa-print"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter1" id="from_date_filter1" placeholder="Till Date" title="Till Date" onchange="report_reflect()">
		</div>
	</div>
</div>

<hr>

<div id="div_report_cashflow" class="main_block loader_parent"></div>
<div id="div_report1"></div>
<script type="text/javascript">
$('#gl_id_filter').select2();
$('#from_date_filter1').datetimepicker({ timepicker:false, format:'d-m-Y' });
function report_reflect()
{
	$('#div_report_cashflow').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter1').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
	$.post('report_reflect/cash_flow/report_reflect.php',{ from_date : from_date,financial_year_id : financial_year_id, branch_admin_id: branch_admin_id}, function(data){
		$('#div_report_cashflow').html(data);
	});
}
report_reflect();


function excel_report()
{
 	var from_date = $('#from_date_filter1').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();

	$('#print_button').button('loading');
	$.post('report_reflect/cash_flow/excel_report.php',{ from_date : from_date,financial_year_id : financial_year_id,branch_admin_id : branch_admin_id }, function(data){
		$('#print_button').button('reset');
		$('#div_report1').html(data);
	});
}

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>