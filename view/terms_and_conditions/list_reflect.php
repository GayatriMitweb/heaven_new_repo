<?php
include "../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$type = $_POST['type']; 
$query = "select * from terms_and_conditions where 1 ";
if($type != ''){
	$query .= " and type = '$type'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}elseif($role!='Admin' && $role!='Branch Admin'){
    $query .= " and emp_id='$emp_id'";
}

?>
<div class="table-responsive mg_tp_20">
<table class="table" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Type</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_terms = mysql_query($query);
		while($row_terms = mysql_fetch_assoc($sq_terms)){

			$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_terms[city_id]'"));

			$bg = ($row_terms['active_flag']=="Inactive") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_terms['type'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_terms['terms_and_conditions_id'] ?>)" title="Edit"><i class="fa fa-pencil"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<script>
$('#tbl_list').dataTable({"pagingType": "full_numbers"});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>