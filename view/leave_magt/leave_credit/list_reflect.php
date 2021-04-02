<?php
include "../../../model/model.php";
$emp_id = $_POST['emp_id'];
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$emp_id1 = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$login_emp_id = $_SESSION['emp_id'];

$query = "select * from leave_credits where 1 ";
if($emp_id!=""){
	$query .=" and emp_id='$emp_id' ";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Hr' || $role=='Accountant' || $role_id>'7'){
		$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7' && $role!='Hr'){
		$query .= " and emp_id='$login_emp_id' and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr' && $role_id!='7'){
	$query .= " and emp_id='$login_emp_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad mg_tp_20"> <div class="table-responsive">

<table class="table table-hover" id="tbl_customer_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>User_Name</th>
			<th>Casual_Leave</th>
			<th>Paid_Leave</th>
			<th>Medical_Leave</th>
			<th>Maternity_Leave</th>
			<th>Paternity_Leave</th>
			<th>Leave without Pay</th>
			<?php if($role_id=="1" || $role_id=="5" || $role_id=="6"){ ?><th>Edit</th><?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_credit = mysql_query($query);
		while($row_credit = mysql_fetch_assoc($sq_credit)){
			$sq_emp = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$row_credit[emp_id]'"));
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_emp['first_name'].' '.$sq_emp['last_name']  ?></td>
			    <td><?= $row_credit['casual'] ?></td> 
				<td><?= $row_credit['paid'] ?></td>
				<td><?= $row_credit['medical'] ?></td>
				<td><?= $row_credit['maternity'] ?></td>
		        <td><?= $row_credit['paternity']?></td> 
				<td><?= $row_credit['leave_without_pay'] ?></td>				
				<?php if($role_id=="1" || $role_id=="5" || $role_id=="6"){ ?><td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_credit['emp_id'] ?>)" title="Edit customer"><i class="fa fa-pencil-square-o"></i></button>
				</td><?php } ?>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>	

</div> </div> </div>
<div id="div_customer_update_modal"></div>
<script>
$('#tbl_customer_list').dataTable({
		"pagingType": "full_numbers"
	});

</script>