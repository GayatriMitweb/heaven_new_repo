<?php 
$sq_entry_count = mysql_num_rows(mysql_query("select entry_id from ticket_master_entries where ticket_id='$ticket_id'"));
if($sq_entry_count>0){

	$count = 0;

	$sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$ticket_id'");
	while($row_entry = mysql_fetch_assoc($sq_entry)){
		$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
		$count++;
		?>
		 <tr class="<?= $bg ?>">
		    <td><input class="css-checkbox" id="chk_ticket<?= $count ?>_u" type="checkbox" checked disabled><label class="css-label" for="chk_ticket<?= $count ?>_u"> <label></td>
		    <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
		    <td><input type="text" id="first_name<?= $count ?>_u" name="first_name"  onchange="fname_validate(this.id)"  placeholder="*First Name" title="First Name" value="<?= $row_entry['first_name'] ?>" /></td>
		    <td><input type="text" id="middle_name<?= $count ?>_u" name="middle_name"  onchange="fname_validate(this.id)"  placeholder="Middle Name" title="Middle Name" value="<?= $row_entry['middle_name'] ?>"/></td>
		    <td><input type="text" id="last_name<?= $count ?>_u" name="last_name"  onchange="fname_validate(this.id)"  placeholder="Last Name" title="Last Name" value="<?= $row_entry['last_name'] ?>"/></td>    
		    <td class="hidden"><input type="text" id="birth_date<?= $count ?>_u" name="birth_date" placeholder="Birth Date" title="Birth Date" class="app_datepicker" onchange="adolescence_reflect(this.id)" value="<?= get_date_user($row_entry['birth_date']) ?>"/></td>
			<td><select id="adolescence<?= $count ?>_u" name="adolescence" placeholder="*Adolescence" title="Adolescence" disabled>
					<option value="">Select Adolescence</option>
					<option <?php echo ($row_entry['adolescence'] == 'Adult')?"selected":"" ?> >Adult</option>
					<option <?php echo ($row_entry['adolescence'] == 'Child')?"selected":"" ?> >Child</option>
					<option <?php echo ($row_entry['adolescence'] == 'Infant')?"selected":"" ?> >Infant</option>
    			</select>
			</td>
		    <td><input type="text" id="ticket_no<?= $count ?>_u" style="text-transform: uppercase;" name="ticket_no" placeholder="Ticket No" onchange="validate_spaces(this.id)" title="Ticket No" value="<?= $row_entry['ticket_no'] ?>"/></td>
		    <td><input type="text" id="gds_pnr<?= $count ?>_u" style="text-transform: uppercase;" name="gds_pnr" placeholder="GDS PNR" onchange="validate_spaces(this.id)" title="GDS PNR" value="<?= $row_entry['gds_pnr'] ?>"></td>
			<td><input type="text" id="baggage_info<?= $count ?>_u" style="text-transform: uppercase;" name="baggage_info" placeholder="Baggage" onchange="validate_spaces(this.id)" title="Baggage" value="<?= $row_entry['baggage_info'] ?>"></td>
			<td><input type="<?= ($row_entry['main_ticket'] == '') ? 'hidden' : 'text' ?>" class="form-control"  id="main_ticket<?= $count ?>_u" style="text-transform: uppercase;" name="main_ticket" placeholder="*Main Ticket Number" onchange="validate_spaces(this.id)" title="Main Ticket Number" value="<?= $row_entry['main_ticket'] ?>"></td>
		    <td class="hidden"><input type="text" value="<?= $row_entry['entry_id'] ?>"></td>
		</tr>
		<script>
			$('#birth_date<?= $count ?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
		</script>
		<?php

	}
}
else{
	include_once('../save/ticket_master_tbl.php');
}

?>
