<?php
include "../../../../../model/model.php";
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="csv_report_generate()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
	
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			<select name="year_filter" style="width: 100%" id="year_filter" title="Year">
				<option value="">Year</option>
				<?php 
				for($year_count=2018; $year_count<2099; $year_count++){
					?>
					<option value="<?= $year_count ?>"><?= $year_count ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="col-md-3 col-sm-6 mg_bt_10_xs">
			<select name="month_filter" style="width: 100%" id="month_filter" title="Month">
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

			<div class="col-md-3 mg_bt_10_xs">
			<select id="emp_id_filter" name="emp_id_filter" title="User Name" style="width: 100%">
				<option value="">Select User</option>
				<?php 
				$query ="select * from emp_master where 1 and active_flag!='Inactive'";  
				if($branch_status=='yes' && $role!='Admin'){
				    $query .=" and branch_id='$branch_admin_id'";
				} 
				 
				$sq_users = mysql_query($query);
				while($row_users = mysql_fetch_assoc($sq_users)){
					?>
					<option value="<?= $row_users['emp_id'] ?>"><?= $row_users['first_name'].' '.$row_users['last_name'] ?></option>
					<?php
				} ?>
			</select>
		</div>	

		
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<form action="report_reflect\emp_attendance\report_csv_generator.php" target="_BLANK" id="frm_csv_generator" method="POST">
    <input type="hidden" id="csv_report_title" name="csv_report_title" value="User Attendance">
    <input type="hidden" id="csv_table_title_row_arr" name="csv_table_title_row_arr">
    <input type="hidden" id="csv_table_row_arr" name="csv_table_row_arr">
    <input type="hidden" id="csv_table_footer_row_arr" name="csv_table_footer_row_arr"> 
</form>

<hr>
<div id="div_report" class="main_block loader_parent">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table id="report" class="table table-hover mg_tp_20" style="margin: 20px 0 !important;">         
	</table>
</div></div></div>
</div>

<script type="text/javascript">
$('#emp_id_filter,#year_filter, #month_filter').select2();
function report_reflect(){

	$('#div_report').append('<div class="loader"></div>');
	var base_url = $('#base_url').val();
	var year = $('#year_filter').val();
	var month = $('#month_filter').val();
	var emp_id = $('#emp_id_filter').val();
	if(year=='' || month==''){
		error_msg_alert("Year and Month filters are mandatory!");
		return false;
	}
	var column = [
	{ title : "User_ID"},
	{ title:"user_name", className:"text-center"}];
	var col2= [];
	for(var days = 1; days <= parseInt(daysInMonth(month,year)); days++){
		var day_col = [
			{title : String(days)}
		];
		col2.push(day_col);
	}
	var column2 = [
		{ title : "Present"},
		{ title : "Absent"},
		{ title : "On_Tour"},
		{ title : "Half_Day"},
		{ title : "Work_FromHome"},
		{ title : "Holiday_OFF"},
		{ title : "Weekly_OFF"}
	];
	var col3 = column.concat(col2.flat());
	var col4 = col3.concat(column2);
	$('#report th').empty();
	$.post(base_url+'view/reports/staff_mgmt/report_reflect/emp_attendance/report_reflect.php', { year : year, month : month, emp_id : emp_id }, function(data){
		pagination_load(data, col4, false, false, 20, 'report');
		$('.loader').remove();
	});
}

function daysInMonth (month, year) {
    return new Date(year, month, 0).getDate();
}
function csv_report_generate()
{
	var year = $('#year_filter').val();
	var month = $('#month_filter').val();
	if(year=='' || month==''){
		error_msg_alert("Year and Month filters are mandatory!");
		return false;
	}
  $('table').dataTable().fnDestroy();

  var title = $('#csv_report_title').val();

  var table_row_arr = new Array();
  var title_row_arr = new Array();
  var table_footer_arr = new Array();

  var count = 0;
  $("table thead tr").each(function(){
      title_row_arr[count] = new Array();
      var row = title_row_arr[count];

      var col_count = 0
      $(this).find('th').each(function(){
          row[col_count] = $(this).text();  
          col_count++;
      });
      count++;
  });

  var count = 0;
  $("table tbody tr").each(function(){
      table_row_arr[count] = new Array();
      var row = table_row_arr[count];

      var col_count = 0
      $(this).find('td').each(function(){
          row[col_count] = $(this).text();  
          col_count++;
      });
      count++;
  });

  var count = 0;
  $("table tfoot tr").each(function(){
      table_footer_arr[count] = new Array();
      var row = table_footer_arr[count];

      var col_count = 0
      $(this).find('th').each(function(){
          row[col_count] = $(this).text();  
          col_count++;
      });
      count++;
  });

  var title_row_arr = JSON.stringify(title_row_arr);
  var table_row_arr = JSON.stringify(table_row_arr);
  var table_footer_arr = JSON.stringify(table_footer_arr);
  $('#csv_report_title').val(title); 
  $('#csv_table_title_row_arr').val(title_row_arr);
  $('#csv_table_row_arr').val(table_row_arr);
  $('#csv_table_footer_row_arr').val(table_footer_arr);
  $('#frm_csv_generator').submit();
  $('table').dataTable();
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>