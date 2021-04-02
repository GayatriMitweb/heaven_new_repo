<?php
include "../../../model/model.php";
$emp_id= $_SESSION['emp_id'];
$role= $_SESSION['role'];
$branch_admin_id= $_SESSION['branch_admin_id'];

$query = "select * from leave_credits where 1 ";
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Hr' || $role=='Accountant' || $role_id>'7'){
		$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7' && $role!='Hr'){
		$query .= " and emp_id='$emp_id' and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr'  && $role!='Accountant' && $role_id!='7'){
	$query .= " and emp_id='$emp_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad mg_tp_20"> <div class="table-responsive">

<table class="table table-hover" id="ldatatable" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>SR.NO</th>
			<th>User_Name</th>
			<th>Casual Leave</th>
			<th>Paid Leave</th>
			<th>Medical Leave</th>
			<th>Maternity Leave</th>
			<th>Paternity Leave</th>
			<th>Leave Without Pay</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 1;
		$sq_c = mysql_query($query);
		while($row_c = mysql_fetch_assoc($sq_c)){
			 $sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_c[emp_id]'"));
			?>
			<tr>
				<td><?= $count++ ?></td>
				<td><?= $sq_emp['first_name'].' '.$sq_emp['last_name'] ?></td>
				<td><?= $row_c['casual'] ?></td>
				<td><?= $row_c['paid']  ?></td>
				<td><?= $row_c['medical'] ?></td>
				<td><?= $row_c['maternity']  ?></td>
				<td><?= $row_c['paternity'] ?></td>
				<td><?= $row_c['leave_without_pay']  ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>	
</div>
</div>
</div>
 
<script>
 $('#ldatatable').dataTable({
		"pagingType": "full_numbers"
	});
</script>