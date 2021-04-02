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
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			 <input type="text" id="till_date" name="till_date" placeholder="Select Date" onchange="report_reflect()" title="Select Date" value="<?= date('d-m-Y') ?>" >
		</div>
		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10_xs">
               <select class="form-control" id="party_name" name="party_name" onchange="report_reflect()" title="Select Customer" >
                  <?php get_customer_dropdown($role,$branch_admin_id,$branch_status); ?>
              </select>
        </div>
	</div>
</div>

<hr>
<!-- <div id="div_report_receive" class="main_block loader_parent"></div> -->
<div id="div_modal"></div>
<div class="row mg_tp_10 main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="rec_age" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div></div>
<script type="text/javascript">
$('#party_name').select2(); 
$('#till_date').datetimepicker({ timepicker:false, format:'d-m-Y' });
var column = [
{ title : "S_No."},
{ title:"Customer_name", className:"text-center"},
{ title : "Booking_Type", className:"text-center"},
{ title : "View", className:"text-center"},
{ title : "Total_Outstanding", className:"text-center"},
{ title : "Not_Due", className:"text-center"},
{ title : "Total_Due", className:"text-center"},
{ title : "0_To_30", className:"text-center"},
{ title : "31_To_60", className:"text-center"},
{ title : "61_To_90", className:"text-center"},
{ title : "91_To_120", className:"text-center"},
{ title : "121_To_180", className:"text-center"},
{ title : "181_To_360", className:"text-center"},
{ title : "361_&_above", className:"text-center"}
];
function report_reflect()
{
	$('#div_report_receive').append('<div class="loader"></div>');
	var till_date = $('#till_date').val();
 	var customer_id = $('#party_name').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();

	$.post('report_reflect/receivables_ageing/get_customer_booking.php',{ till_date : till_date, customer_id : customer_id , branch_status : branch_status , role : role,branch_admin_id : branch_admin_id }, function(data){
			// console.log(data);
			pagination_load(data, column, true, true, 20, 'rec_age');
	});
}
function view_modal(booking_id_arr,pending_amt_arr,not_due_arr,total_days_arr,due_date_arr)
{
	$.post('report_reflect/receivables_ageing/view_modal.php', {booking_id_arr : booking_id_arr,pending_amt_arr : pending_amt_arr,total_days_arr : total_days_arr,not_due_arr : not_due_arr, due_date_arr:due_date_arr}, function(data){
 
		$('#div_modal').html(data);

	});

}

function excel_report()
{
	var till_date = $('#till_date').val();
 	var customer_id = $('#party_name').val();
	var branch_status = $('#branch_status').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var role = $('#role').val();
	if(till_date == '' && customer_id == ''){
		error_msg_alert("Select atleast one filter");
		return false;
	}
	window.location = 'report_reflect/receivables_ageing/excel_report.php?till_date='+till_date+'&customer_id='+customer_id+'&branch_status='+branch_status+'&branch_admin_id='+branch_admin_id+'&role='+role;
}

$(function () {
    $("[data-toggle='tooltip']").tooltip({placement: 'bottom'});
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>