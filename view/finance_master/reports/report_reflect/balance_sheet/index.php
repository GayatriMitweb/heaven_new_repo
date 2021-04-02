<?php include "../../../../../model/model.php"; 
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<input type="hidden" name="branch_admin_id" value='<?= $branch_admin_id ?>' id="branch_admin_id">

<div class="row text-right mg_bt_10">
	<div class="col-md-6 col-md-offset-6 text-right">		
		<button class="btn btn-pdf btn-sm mg_bt_10" onclick="excel_report()" id="print_button1" title="Print"><i class="fa fa-print"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date">
		</div>	
		<div class="col-md-3 mg_bt_10_xs">
			<select name="financial_year_id_filter" id="financial_year_id_filter" title="Financial Year">
				<?php get_financial_year_dropdown(); ?>
			</select>
		</div>	
		<div class="col-md-3">
			<button class="btn btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>

<div id="div_report_balance" class="main_block loader_parent"></div>
<div id="div_report1"></div>

<script type="text/javascript">
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

function report_reflect()
{
	$('#div_report_balance').append('<div class="loader"></div>');

	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	var branch_admin_id = $('#branch_admin_id').val();
	$.post('report_reflect/balance_sheet/report_reflect.php',{ from_date : from_date, to_date : to_date, financial_year_id : financial_year_id,branch_admin_id : branch_admin_id }, function(data){
		$('#div_report_balance').html(data);		
	});
}

function excel_report()
{
 	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var financial_year_id = $('#financial_year_id_filter').val();
	var branch_admin_id = $('#branch_admin_id').val();
	if(from_date != ''){
		if(to_date == ''){
		error_msg_alert("Select To date");
		return false;
		}
	}
	if(to_date != ''){
		if(from_date == ''){
		error_msg_alert("Select From date");
		return false;
		}
	}
	$('#print_button1').button('loading');
	$.post('report_reflect/balance_sheet/excel_report.php',{ from_date : from_date, to_date : to_date, financial_year_id : financial_year_id,branch_admin_id : branch_admin_id }, function(data){
		$('#print_button1').button('reset');
		$('#div_report1').html(data);
	});
}

report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>