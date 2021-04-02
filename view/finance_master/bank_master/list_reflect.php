<?php
include "../../../model/model.php";
?>
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Bank_Name</th>
			<th>A/c No.</th>
			<th>Account_Type</th>
			<th>view</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_bank = mysql_query("select * from bank_master");
		while($row_bank = mysql_fetch_assoc($sq_bank)){

			$bg = ($row_bank['active_flag']=="Active") ? "" : "danger";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_bank['bank_name'] ?></td>
				<td><?= $row_bank['account_no'] ?></td>
				<td><?= $row_bank['account_type'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_bank['bank_id'] ?>)" title="Basic Information"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_bank['bank_id'] ?>)" title="Update Bank"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
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