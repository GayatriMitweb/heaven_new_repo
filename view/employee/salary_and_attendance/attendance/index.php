<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='employee/salary_and_attendance/index.php'"));
$branch_status = $_POST['branch_status'];

?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
 
<div class="app_panel_content Filter-panel">
	
	<div class="row text-center">
		<div class="col-md-2 col-sm-6 mg_bt_10_xs col-md-offset-4">
			 <input type="text" id="attendence_date" name="attendence_date" placeholder="*Select Date" onchange="emp_attendance_reflect()" title="Select Date" value="<?= date('d-m-Y') ?>" >
		</div>
	</div>
</div>

<div id="div_reflect" class="main_block"></div>

<?php include "guidline_modal.php";?>

<script>
$('#attendence_date').datetimepicker({ timepicker:false, format:'d-m-Y' });

emp_attendance_reflect();
function emp_attendance_reflect(){
	var attendence_date = $('#attendence_date').val();
	var branch_status = $('#branch_status').val();
	if(attendence_date==""){
		error_msg_alert("Please select a Date!!!");
	}
 
		$.post('attendance/employee_attendance_reflect.php',{ attendence_date : attendence_date, branch_status: branch_status },function(data){
			$('#div_reflect').html(data);
		});
		 
}

</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>