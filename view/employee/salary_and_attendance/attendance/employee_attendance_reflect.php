<?php 
include "../../../../model/model.php";
$attendence_date = $_POST['attendence_date'];
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$attendence_date = date('Y-m-d', strtotime($attendence_date));
?>
<div class="row mg_bt_20">
	<div class="col-xs-8 text_left mg_tp_20">
		<label for="rd_all_present" class="app_dual_button">
	        <input type="radio" id="rd_all_present" name="rd_status" >
	        &nbsp;&nbsp;All Present
	    </label>    
	    <label for="rd_all_absent" class="app_dual_button">
	        <input type="radio" id="rd_all_absent" name="rd_status">
	        &nbsp;&nbsp;All Absent
	    </label>
	</div>
</div>

<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-hover no-marg-sm" id="tbl_att_list">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>User Name</th>
				<th style="width:800px">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count = 0; 
				
			 	$query = "select * from emp_master where 1 and active_flag!='Inactive'";
				    
				if($branch_status=='yes' && $role!='Admin'){
					$query .= " and branch_id = '$branch_admin_id'";
				}
				      $query .= " order by first_name";
				      $sq_emp = mysql_query($query);
				      while($row_emp = mysql_fetch_assoc($sq_emp)){
				      	++$count;
				      	$sq_att= mysql_fetch_assoc(mysql_query("select * from employee_attendance_log where att_date='$attendence_date' and emp_id='$row_emp[emp_id]'"));
				      
				      	if($sq_att['status']=="Present"){ $bg = "success";}
				      	else if($sq_att['status']=="Absent") { $bg = "danger"; }
						else if($sq_att['status']=="On Tour"||$sq_att['status']=="Half Day" || $sq_att['status']=="Work From Home" || $sq_att['status']=="Holiday Off" || $sq_att['status']=="Weekly Off") { $bg = "warning"; }
						else{
							$bg = "";
						}
				      	
				?>
				<tr class="<?= $bg ?>">
					<td><?= $count ?></td>
					<td><?= $row_emp['first_name'].' '.$row_emp['last_name']  ?></td>
					<input type="hidden" id="emp_id_<?= $count ?>" name="emp_status_id" value="<?= $row_emp['emp_id'] ?>">
					<td style="width:133px">
						<select name="status" id="status_<?= $count ?>" title="Status" style="width: 139px;" class="form-control">
							<?php 
							if($sq_att['status']!=""){
								?>
								<option value="<?= $sq_att['status'] ?>"><?= $sq_att['status'] ?></option>
								<?php
							}
							else{
								?>
								<option value="">Select Status</option>
								<?php
							}
							?>
							<option value="Present">Present</option>
							<option value="Absent">Absent</option>
							<option value="On Tour">On Tour</option>
							<option value="Half Day">Half Day</option>
							<option value="Work From Home">Work From Home</option>
							<option value="Holiday Off">Holiday Off</option>
							<option value="Weekly Off">Weekly Off</option>
						</select>
					</td>
				</tr>
				<?php
			   }
			?>		
		</tbody>
	</table>
	</div> </div> </div>
	<div class="row mg_tp_20 text-center">
		<div class="col-md-4 col-md-offset-4 col-xs-4">
			<button id="btn_att_save" class="btn btn-sm btn-success" onclick="user_attendence_Save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Attendance</button>
		</div>
	</div>

<script>
$('#tbl_att_list').dataTable({
		"pagingType": "full_numbers"
});

$('input[name="rd_status"]').change(function(){
	 
	var id = $('input[name="rd_status"]:checked').attr('id');
	if(id=="rd_all_present"){
		 
		$('select[name="status"]').each(function(){		
			$(this).find('option[value="Present"]').prop('selected', true);
		});
	}
	if(id=="rd_all_absent"){
		$('select[name="status"]').each(function(){	
			$(this).find('option[value="Absent"]').prop('selected', true);
		});
	}

});

function user_attendence_Save(){
    var att_date = $('#attendence_date').val();
	var status_arr = new Array();
	var emp_arr = new Array();

	$('select[name="status"]').each(function(){
		var value = $(this).val();
		 status_arr.push(value);

	});
	$('input[name="emp_status_id"]').each(function(){
		var emp_id = $(this).val();
		if(emp_id!=0){
		  emp_arr.push(emp_id);
		 
	    }
	});
	var status_value = 0;
	for(var i=0;i<status_arr.length;i++){
		if(status_arr[i] != ''){ status_value++; }
	}
	
	if(status_value == '0'){ error_msg_alert("Atleast select one user attendance"); return false; }
	var base_url = $('#base_url').val();

	$('#btn_att_save').button('loading');

	$.ajax({
		type:'post',
		url:base_url+'controller/employee/attendance/user_log_update.php',
		data:{ att_date : att_date, emp_arr : emp_arr, status_arr : status_arr },
		success:function(result){
			msg_alert(result);
			$('#btn_att_save').button('reset');
			emp_attendance_reflect();
		}
	});

}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>