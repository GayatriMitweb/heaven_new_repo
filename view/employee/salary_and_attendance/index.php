<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysql_fetch_assoc(mysql_query("select * from branch_assign where link='employee/salary_and_attendance/index.php'"));
$branch_status = $sq['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('User Attendance',88) ?>
      <div class="header_bottom">
        <div class="row text-center hidden">
            <label for="rd_emp_attendance" class="app_dual_button active">
		        <input type="radio" id="rd_emp_attendance" name="rd_emp_attendance_salary" checked onchange="emp_attendance_and_salary_reflect()">
		        &nbsp;&nbsp;Attendance
		    </label>    
        </div>
      </div> 

  <!--=======Header panel end======-->




<div class="app_panel_content">


<div id="div_emp_attendance_salary_content"></div>
<?= end_panel() ?>
<script>
	function emp_attendance_and_salary_reflect()
	{
		var id = $('input[name="rd_emp_attendance_salary"]:checked').attr('id');
		var branch_status = $('#branch_status').val();
		if(id=="rd_emp_attendance"){
			$.post('attendance/index.php', {branch_status : branch_status}, function(data){
				$('#div_emp_attendance_salary_content').html(data);
			});
		}
	}
	emp_attendance_and_salary_reflect();
</script>

<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>