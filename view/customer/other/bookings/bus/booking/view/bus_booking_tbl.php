<?php 
function get_dyn_tbl()
{
	?>
	
	<script>
		$('#date_of_journey1').datetimepicker({ format:'d-m-Y H:i:s' });
		$('#reporting_time1').datetimepicker({ datepicker:false, format:'H:i' });
	</script>
	<?php
}
if(!$update_form){
	get_dyn_tbl();
}
else{
	$sq_entry_count = mysql_num_rows(mysql_query("select entry_id from bus_booking_entries where booking_id='$booking_id'"));
	if($sq_entry_count==0){
		get_dyn_tbl();
	}
	else{
		$count = 0;
		$sq_entry = mysql_query("select * from bus_booking_entries where booking_id='$booking_id'");
		while($row_entry = mysql_fetch_assoc($sq_entry)){
			if($row_entry['status']=='Cancel'){
				$bg="danger";
			}
			else{
				$bg="";
			}
			$count++;
			?>
			<tr class="<?= $bg ?>">
			    <td><?= $count ?></td>
			    <td><?= $row_entry['company_name'] ?></td>
			    <td><?= $row_entry['seat_type'] ?></td>
			    <td><?= $row_entry['bus_type'] ?></td>
			    <td> <?= $row_entry['pnr_no'] ?></td>
			    <td><?= $row_entry['origin'] ?></td>
			    <td><?= $row_entry['destination'] ?></td>
			    <td><?= ($row_entry['date_of_journey']=='1970-01-01 05:30:00') ? "" : date("d-m-Y H:i",strtotime($row_entry['date_of_journey'] )) ?></td>
			    <td><?= $row_entry['reporting_time'] ?></td>
			    <td><?= $row_entry['boarding_point_access'] ?></td>
			</tr>
			<script>
				$('#date_of_journey<?= $count ?>_u').datetimepicker({ format:'d-m-Y H:i:s' });
				$('#reporting_time<?= $count ?>_u').datetimepicker({ datepicker:false, format:'H:i' });
			</script>
			<?php
		}
		
	}
}
?>