<?php include_once("../../../model/model.php"); ?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Currency_Name</th>
			<th>Currency_Rate</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 1;
		$sq_roe = mysql_query("select * from roe_master");
		while($row_roe = mysql_fetch_assoc($sq_roe)){
			$sq_cur = mysql_fetch_assoc(mysql_query("select currency_code from currency_name_master where id='$row_roe[currency_id]'"));
			?>
			<tr class="<?= $bg ?>">
				<td><?= $count++ ?></td>
				<td><?= $sq_cur['currency_code'] ?></td>
				<td><?= $row_roe['currency_rate'] ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_roe['entry_id'] ?>)" title="Edit ROE"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php } ?>
	</tbody>
</table>
</div> </div> </div>
<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>