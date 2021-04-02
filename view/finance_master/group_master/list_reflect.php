<?php
include "../../../model/model.php";
?>
 <div class="table-responsive">
    <table id="tbl_list_group" class="table table-hover" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-grouping-row">
			<th>SR_No</th>
			<th>Group_Name</th>
			<th>Group/SubGroup_Name</th>
			<th>Head_Name</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_group = mysql_query("select * from subgroup_master where 1");
		while($row_gr = mysql_fetch_assoc($sq_group)){
			$count++;
			
			?>
			<tr>
				<td><?= $count ?></td>
				<td><?= $row_gr['subgroup_name'] ?></td>
				<?php if($count <= '111'){ 
					$sq_group1 = mysql_fetch_assoc(mysql_query("select * from group_master where group_id='$row_gr[group_id]'"));
			        $sq_head = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='$sq_group1[head_id]'"));
				?>
				<td><?= $sq_group1['group_name'] ?></td>
				<td><?= $sq_head['head_name'] ?></td>
				<?php }
				else{
					$sq_group1 = mysql_fetch_assoc(mysql_query("select * from subgroup_master where subgroup_id='$row_gr[group_id]'"));
					$sq_group2 = mysql_fetch_assoc(mysql_query("select * from group_master where group_id='$sq_group1[group_id]'"));
					$sq_head1 = mysql_fetch_assoc(mysql_query("select * from head_master where head_id='$sq_group2[head_id]'"));
					?>
				<td><?= $sq_group1['subgroup_name'] ?></td>
				<td><?= $sq_head1['head_name'] ?></td>	
				<?php } ?>

				<?php if($count >= '112'){ ?>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_gr['subgroup_id'] ?>)" title="Update Group"><i class="fa fa-pencil-square-o"></i></button>
				</td>
				<?php } 
				else { ?>
				<td></td>
					<?php } ?>

			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> 

<script>
$('#tbl_list_group').dataTable({
		"pagingType": "full_numbers"
	});
</script>