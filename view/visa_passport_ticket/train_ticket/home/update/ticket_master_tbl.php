<?php 
$sq_booking_count = mysql_num_rows(mysql_query("select entry_id from train_ticket_master_entries where train_ticket_id='$train_ticket_id'"));
if($sq_booking_count==0){
    include_once('../save/ticket_master_tbl.php');
}
else{
    $count = 0;

    $sq_entry = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
    while($row_entry = mysql_fetch_assoc($sq_entry)){
        $count++;
    ?>
        <tr>
            <td><input class="css-checkbox" id="chk_ticket<?= $count ?>_u" type="checkbox"  onchange="get_auto_values('booking_date','basic_fair','payment_mode','service_charge','markup','update','true','basic','basic');" checked disabled><label class="css-label" for="chk_ticket<?= $count ?>_u"> </label></td>
            <td><input maxlength="15" value="<?= $count ?>" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
            <td><select name="honorific" id="honorific<?= $count ?>_u" title="Honorific">
                <option value="<?= $row_entry['honorific'] ?>"><?= $row_entry['honorific'] ?></option>
                <?php get_hnorifi_dropdown(); ?>
            </select></td>
            <td><input type="text" id="first_name<?= $count ?>_u" onchange="fname_validate(this.id)" name="first_name" placeholder="First Name" title="First Name" value="<?= $row_entry['first_name'] ?>" /></td>
            <td><input type="text" id="middle_name<?= $count ?>_u" onchange="fname_validate(this.id)" name="middle_name" placeholder="Middle Name" title="Middle Name" value="<?= $row_entry['middle_name'] ?>"/></td>
            <td><input type="text" id="last_name<?= $count ?>_u" name="last_name" onchange="fname_validate(this.id)" placeholder="Last Name" title="Last Name" value="<?= $row_entry['last_name'] ?>"/></td>
            <td><input type="text" id="birth_date<?= $count ?>_u" name="birth_date" class="app_datepicker" placeholder="DOB" title="DOB" onchange="adolescence_reflect(this.id)"  value="<?= get_date_user($row_entry['birth_date']) ?>"/></td>    
            <td><input type="text" id="adolescence<?= $count ?>_u" name="adolescence" placeholder="Adolescence" title="Adolescence" disabled value="<?= $row_entry['adolescence'] ?>"/></td>   
            <td><input type="text" id="coach_number<?= $count ?>_u" name="coach_number" style="text-transform: uppercase;" placeholder="Coach Number" title="Coach Number" onchange=" validate_specialChar(this.id);" value="<?= $row_entry['coach_number'] ?>"></td>
            <td><input type="text" id="seat_number<?= $count ?>_u"  style="text-transform: uppercase;" name="seat_number" onchange="validate_specialChar(this.id);" placeholder="Seat Number" title="Seat Number" value="<?= $row_entry['seat_number'] ?>"></td>
            <td><input type="text" id="ticket_number<?= $count ?>_u"  style="text-transform: uppercase;" onchange=" validate_specialChar(this.id);" name="ticket_number" placeholder="Ticket Number" title="Ticket Number" value="<?= $row_entry['ticket_number'] ?>"></td>
            <td class="hidden"><input type="text" value="<?= $row_entry['entry_id'] ?>"></td>
        </tr>
        <script>
        $('#birth_date<?= $count ?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
        </script>
    <?php        
    }
    
}
?>
