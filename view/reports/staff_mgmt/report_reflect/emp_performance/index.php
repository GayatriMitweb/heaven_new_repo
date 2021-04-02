<?php
include "../../../../../model/model.php";
$branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
?>
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" id="btn_save_modal" onclick="save_modal()" title="Add New"><i class="fa fa-plus"></i>&nbsp;&nbsp;Performance</button>
	</div>
</div>
<input type='hidden' id="branch_status" name='branch_status' avlue="<?= $branch_status ?>"/>
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<select id="emp_id_filter1" name="emp_id_filter1" title="User Name" style="width: 100%">
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
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>
<div id="div_report" class="main_block mg_tp_10"></div>
<div id="div_modal"></div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="emp_perf" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
<script type="text/javascript">
$('#emp_id_filter1,#year_filter').select2();
function save_modal()
{
	var branch_status = $('#branch_status').val();
	var base_url = $('#base_url').val();
	$('#btn_save').button('loading');

	$.post(base_url+'view/reports/staff_mgmt/report_reflect/emp_performance/save_modal.php', { branch_status : branch_status}, function(data){

		$('#btn_save').button('reset');

		$('#div_modal').html(data);

	});

}
 
function rating_reflect()
{
	var leadership = $('#leadership').val();
	var communication = $('#communication').val();
	var analytical_skills = $('#analytical_skills').val();
	var ethics = $('#ethics').val();
	var conceptual_thinking = $('#conceptual_thinking').val();
	var teamwork = $('#teamwork').val();
   
  if(leadership==""){ leadership=0; }
  if(communication==""){ communication=0; }
  if(analytical_skills==""){ analytical_skills=0; }
  if(ethics==""){ ethics=0; }
  if(conceptual_thinking==""){ conceptual_thinking=0; }
  if(teamwork==""){ teamwork=0; }
   
  var total_addition =  parseFloat(leadership) + parseFloat(communication) + parseFloat(analytical_skills) + parseFloat(ethics) + parseFloat(conceptual_thinking) + parseFloat(teamwork);

   total_addition = round_off_value(total_addition);
   var ave_ratings = parseFloat(total_addition) / 6;
   
  $('#ave_ratings').val(ave_ratings.toFixed(2));

}
var column = [

{ title:"User_ID"},
{ title : "User_Name"},
{ title : "Month"},
{ title : "Teamwork"},
{ title : "Leadership"},
{ title : "Communication."},
{ title : "Analytical Skills"},
{ title : "Ethics"},
{ title : "Conceptual_Thinking"},
{ title : "Average Rating"}	
];
function report_reflect()
{
	var base_url = $('#base_url').val();
	var year = $('#year_filter').val();
	var month = $('#month_filter').val();
	var emp_id = $('#emp_id_filter1').val();

	$.post(base_url+'view/reports/staff_mgmt/report_reflect/emp_performance/report_reflect.php', { year : year,month : month,  emp_id : emp_id }, function(data){
	    pagination_load(data, column, true, false, 20, 'emp_perf');
	});
}
report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>