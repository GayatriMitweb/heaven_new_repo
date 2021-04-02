<?php
include "../../../../../model/model.php";
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

?>
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
 <input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<select id="emp_id_filter" name="emp_id_filter" title="User Name" style="width: 100%">
				<option value="">Select User</option>
				<?php 
				$query ="select * from emp_master where 1";  
				 
				if($role=='Branch Admin' && $branch_status=='yes'){
				    $query .=" and branch_id='$branch_admin_id'";
				} 
				 
				$sq_emp = mysql_query($query);
		       while($row_emp = mysql_fetch_assoc($sq_emp)){?>
		       <?php ?>
		        <option value="<?php echo $row_emp['emp_id']; ?>"><?php echo $row_emp['first_name'].' '.$row_emp['last_name']; ?></option>  
				<?php }
				?>
		    </select>  
		</div>
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filter" id="from_date_filter" placeholder="From Date" title="From Date">
		</div>
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="to_date_filter" id="to_date_filter" placeholder="To Date" title="To Date">
		</div>
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>
<div id="div_report" class="main_block mg_tp_10"></div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="daily_activity" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<script type="text/javascript">
$('#emp_id_filter').select2();
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false,format:'d-m-Y' });
var column = [
{ title : "S_No."},
{ title:"Activity_Date", className:"text-center"},
{ title : "User_name"},
{ title : "Activity_type"},
{ title : "Time_taken"},
{ title : "Description"}	
];
function report_reflect()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var emp_id = $('#emp_id_filter').val();
	var branch_status = $('#branch_status').val();
	$.post('report_reflect/daily_activity_report/report_reflect.php', { from_date : from_date, to_date : to_date, emp_id : emp_id, branch_status : branch_status}, function(data){
		pagination_load(data, column, true, false, 20, 'daily_activity');
	});
}
function excel_report()
{
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var emp_id = $('#emp_id_filter').val();
	var branch_status = $('#branch_status').val(); 
	window.location = 'report_reflect/daily_activity_report/excel_report.php?emp_id='+emp_id+'&from_date='+from_date+'&to_date='+to_date+'&branch_status='+branch_status;
}
report_reflect();


</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>