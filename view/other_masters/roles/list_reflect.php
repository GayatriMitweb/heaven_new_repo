<?php
include_once("../../../model/model.php");
if($setup_package == '1' || $setup_package == '2'){
	$query = "select * from role_master where role_id not in('4','5')";
}
else if($setup_package == '3'){
	$query = "select * from role_master where role_id not in('4')";
}
else {
	$query = "select * from role_master where 1 ";
}
?>

<div class="table-responsive mg_tp_20">
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>

		<tr class="table-heading-row">

			<th>Role ID</th>

			<th>Role</th>

			<th>Edit</th>

		</tr>

	</thead>

	<tbody>

		<?php

		$count = 0;

		$sq_role = mysql_query($query);

		while($row_role = mysql_fetch_assoc($sq_role)){

			$bg = ($row_role['active_flag']=="Inactive") ? "danger" : "";
			$ristrict_arr = array(1, 2, 3, 4,5,6,7);

			$restrict = (in_array($row_role['role_id'], $ristrict_arr)) ? true : false;

			?>
			<tr class="<?= $bg ?>">

				<td><?= $row_role['role_id'] ?></td>

				<td><?php echo strtoupper($row_role['role_name']); ?></td>

				<td>

					<?php if(!$restrict) : ?>

					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_role['role_id'] ?>)" title="Edit role"><i class="fa fa-pencil-square-o"></i></button>

				<?php endif; ?>

				</td>

			</tr>

			<?php } ?>

	</tbody>

</table>



</div>



<script>

$('#tbl_list').dataTable({

		"pagingType": "full_numbers"

	});

</script>