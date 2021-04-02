<?php
include "../../../model/model.php";
$login_role = $_POST['login_role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$role = $_POST['role'];
$active_flag = $_POST['active_flag'];
$location_id = $_POST['location_id'];
$branch_id = $_POST['branch_id'];
$branch_status = $_POST['branch_status'];
 
$query = "select * from emp_master where 1";

if($role != ""){
	$query_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_name = '$role'")); 
	$query .=" and role_id='$query_role[role_id]'";
}
if($active_flag!=""){
	$query .=" and active_flag='$active_flag' ";
}
if($location_id!=""){
	$query .=" and location_id='$location_id' ";
}
if($branch_id!=""){
	$query .=" and branch_id='$branch_id' ";
}
if($branch_status=='yes' && $login_role!='Admin' && $role!='Admin'){
	$query .= " and branch_id = '$branch_admin_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="tbl_emp_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>User_Id</th>
			<th>User_Name</th>
			<th>Location</th>
			<th>Branch</th>
			<th>Role</th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_emp = mysql_query($query);
		while($row_emp = mysql_fetch_assoc($sq_emp)){
			if($row_emp['emp_id']!=0){
			if($row_emp['id_proof_url']!=""){
				$url = $row_emp['id_proof_url'];
				$url = explode('uploads/', $url);
				$url = BASE_URL.'uploads/'.$url[1];
		    }

			$sq_location = mysql_fetch_assoc(mysql_query("select * from locations where location_id='$row_emp[location_id]'"));
			$sq_branch = mysql_fetch_assoc(mysql_query("select * from branches where branch_id='$row_emp[branch_id]'"));
			$sq_login = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='$row_emp[emp_id]'"));

		    $sq_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_id='$row_emp[role_id]'"));

			$bg = ($row_emp['active_flag']=="Inactive") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= $row_emp['emp_id'] ?></td>
				<td><?= $row_emp['first_name'].' '.$row_emp['last_name'] ?></td>
				<!-- <td><?= $row_emp['mobile_no'] ?></td>
				<td><?= $row_emp['email_id'] ?></td> -->
				<td><?= $sq_location['location_name'] ?></td>
				<td><?= $sq_branch['branch_name'] ?></td>
				<td><?= strtoupper($sq_role['role_name']) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_emp['emp_id'] ?>)" title="View User"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_emp['emp_id'] ?>)" title="Edit User"><i class="fa fa-pencil-square-o"></i></button>
				</td>
				<!-- <td>
					<a href="<?= $url ?>" download class="btn-sm btn btn-info"><i class="fa fa-download"></i></a>
				</td> -->
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>
</div> </div> </div>

<script>
$('#tbl_emp_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>