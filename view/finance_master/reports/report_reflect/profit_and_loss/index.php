<?php include "../../../../../model/model.php";
$financial_year_id = $_SESSION['financial_year_id']; 
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<div class="row mg_bt_10">
	<div class="col-md-6 col-md-offset-6 text-right">		
		<button class="btn btn-pdf btn-sm mg_bt_10" onclick="excel_report()" id="print_button" title="Print"><i class="fa fa-print"></i></button>
	</div>
</div>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date">
		</div>	
		<div class="col-md-3">
			<button class="btn btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<input type="hidden" id="financial_year_id" name="financial_year_id" value="<?= $financial_year_id ?>">
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>">

<div id="div_report1"></div>

<div class="main_block loader_parent" id="div_report"></div>


<script type="text/javascript">
$('#gl_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var financial_year_id = $('#financial_year_id').val();
	var branch_admin_id = $('#branch_admin_id').val();
	$.post('report_reflect/profit_and_loss/report_reflect.php',{ from_date : from_date, to_date : to_date, financial_year_id : financial_year_id,branch_admin_id : branch_admin_id }, function(data){
		$('#div_report').html(data);
	});
}
function excel_report()
{
 	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var financial_year_id = $('#financial_year_id').val();
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
	$('#print_button').button('loading');
	$.post('report_reflect/profit_and_loss/excel_report.php',{ from_date : from_date, to_date : to_date, financial_year_id : financial_year_id,branch_admin_id : branch_admin_id }, function(data){
		$('#print_button').button('reset');
		$('#div_report1').html(data);
	});
}
report_reflect();

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>