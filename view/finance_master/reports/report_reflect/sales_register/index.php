<?php include "../../../../../model/model.php"; 
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='finance_master/reports/index.php'"));
$branch_status = $sq['branch_status'];
?>

<input type="hidden" name="branch_status" value="<?= $branch_status ?>" id="branch_status">
<input type="hidden" name="role" value="<?= $role ?>" id="role">
<input type="hidden" name="branch_admin_id" value="<?= $branch_admin_id ?>" id="branch_admin_id">

<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
					<select name="sale_type_filter" id="sale_type_filter" title="Sale Type">
                        <option value="">Sale Type</option>
                        <option value="Bus Booking">Bus</option>
                        <option value="Car Rental Booking">Car Rental</option>
                         <option value="Flight Booking">Flight Ticket</option>
                        <option value="Group Booking">Group Booking</option>
                        <option value="Hotel Booking">Hotel</option>
                        <option value="Package Booking">Package Booking</option>
                        <option value="Passport Booking">Passport</option>
                        <option value="Train Ticket Booking">Train Ticket</option>
                        <option value="Visa Booking">Visa</option> 
                        <option value="Excursion Booking">Excursion</option> 
                        <option value="Forex Booking">Forex</option>
                        <option value="Miscellaneous Booking">Miscellaneous</option> 
                    </select>
				</div>
		<div class="col-md-3">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3 col-sm-6">
			<input type="text" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date">
		</div>	
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
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
	{ title: "Booking_Type" },
	{ title: "Customer_Name" },
	{ title: "Booking_ID" },
	{ title: "Amount" , className: "success text-right"}
];
function report_reflect()
{
	$('#div_report').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var sale_type = $('#sale_type_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	
	$.post('report_reflect/sales_register/report_reflect.php',{ from_date : from_date,to_date : to_date,sale_type : sale_type,branch_status : branch_status, role : role,branch_admin_id : branch_admin_id   }, function(data){
		pagination_load(data, column, true, true, 20, 'sales_reg');
		$('.loader').remove();
	});
}
report_reflect();
function excel_report()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var sale_type = $('#sale_type_filter').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	
	window.location = 'report_reflect/sales_register/excel_report.php?sale_type='+sale_type+'&from_date='+from_date+'&to_date='+to_date+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>