<?php
include "../../../model/model.php";
 
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$login_id = $_POST['login_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from user_logs where 1 ";

if($login_id!=""){
	$query .= " and login_id='$login_id'";
}
if($from_date!='' && $to_date!=''){
	$from_date1 = date('Y-m-d', strtotime($from_date));
	$to_date1 = date('Y-m-d', strtotime($to_date));
	$query .=" and login_date between '$from_date1' and '$to_date1'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' ||$role=='Hr'){
		$query .= " and login_id in(select emp_id from emp_master where branch_id='$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Hr'){
		$query .= " and login_id in(select emp_id from emp_master where emp_id='$emp_id' and branch_id='$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr'){
	$query .= " and login_id in(select emp_id from emp_master where emp_id='$emp_id')";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>User_Name</th>
			<th>Login_Date/Time</th>
			<th>Logout_Date/Time</th>
			<th>IP_Address</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_log = mysql_query($query);
		while($row_log = mysql_fetch_assoc($sq_log)){
			if($row_log['login_time']!="00:00:00"){

			$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='$row_log[login_id]'"));
			$sq_emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$sq_login[emp_id]'"));

			$login_time = $row_log['login_time'];
			if($login_time=="" || $login_time=="00:00:00"){
				$login_time = "N/A";
			}
			$logout_time = $row_log['logout_time'];
			if($logout_time=="" || $logout_time=="00:00:00" ){
				$logout_time = "";
			}
			$logout_date1 = $row_log['logout_date'];
			if($logout_date1=="" || $logout_date1=="0000-00-00"){
				$logout_date1 = "";
			}
			else
			{
				$logout_date1= date('d-m-Y', strtotime($logout_date1));
			}
			 
 
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= ($sq_emp_info['first_name']=="") ? 'Admin' : $sq_emp_info['first_name'].' '.$sq_emp_info['last_name']  ?></td>
				<td><?= date('d-m-Y', strtotime($row_log['login_date'])).' '.$login_time ?></td>
				<td><?= $logout_date1.' '.$logout_time ?></td>
				<td><?= $row_log['user_ip']  ?></td>
			</tr>
			<?php
		    }
		}
		?>	
	</tbody>
	 
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>