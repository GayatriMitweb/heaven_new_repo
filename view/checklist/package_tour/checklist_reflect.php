<?php
include "../../../model/model.php";

$booking_id = $_POST['booking_id'];
?>
<div class="row mg_tp_10"> <div class="col-md-6 col-md-offset-3"> <div class="table-responsive">
	
	<table class="table table-bordered no-marg-sm">
		<thead>
			<tr class="active table-heading-row">
				<th></th>
				<th>S_No.</th>
				<th>To_Do</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0; 
			$sq_entities = mysql_query("select * from checklist_entities where booking_id='$booking_id'");
			while($row_entity = mysql_fetch_assoc($sq_entities))
			{
				?>
				<?php
					$sql=mysql_query("select * from to_do_entries where entity_id='$row_entity[entity_id]'");

					while($sq_todo_list=mysql_fetch_assoc($sql))
					{
						$sq_chk_count = mysql_num_rows(mysql_query("select * from checklist_package_tour where booking_id='$booking_id' and entity_id='$sq_todo_list[id]'"));
						$chk_status = ($sq_chk_count==1) ? "checked" : "";
						$bg = ($sq_chk_count==1) ? "success" : "";
						$count++;
				
						?>
						<tr class="<?= $bg ?>">
							<td>
								<input type="checkbox" id="chk_package_tour_checklist_<?= $count ?>" name="chk_package_tour_checklist" <?= $chk_status ?> data-entity-id="<?= $sq_todo_list['id'] ?>" >

							</td>
							<td><?= $count ?></td>
							<td><?= $sq_todo_list['entity_name'] ?></td>
						</tr>
						<?php
					}
			}
			?>
		</tbody>		
	</table>

</div> </div> </div>

<div class="row text-center">
	<div class="col-md-12">
		<button class="btn btn-sm btn-success" onclick="package_tour_checklist_save()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Checklist</button>
	</div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>