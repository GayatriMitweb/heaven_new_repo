<?php 
$sq_booking_count = mysql_num_rows(mysql_query("select entry_id from train_ticket_master_entries where train_ticket_id='$train_ticket_id'"));
if($sq_booking_count==0){
    include_once('../save/ticket_master_tbl.php');
}
else{
    $count = 0;

    $sq_entry = mysql_query("select * from train_ticket_master_entries where train_ticket_id='$train_ticket_id'");
    while($row_entry = mysql_fetch_assoc($sq_entry)){
        if($row_entry['status']=="Cancel")
        {
            $bg="danger";
        }
        else
        {
            $bg="#fff";
        }
        $count++;
    ?>
        <tr class="<?php echo $bg; ?>">
            <td><?php echo $count; ?></td>
            <td><?php echo $row_entry['first_name']." ".$row_entry['last_name']; ?> </td>
            <td><?= get_date_user($row_entry['birth_date']) ?></td>
            <td><?php echo $row_entry['adolescence']; ?></td>
            <td><?php echo $row_entry['coach_number'];  ?></td>    
            <td><?php echo $row_entry['seat_number'];  ?></td>   
            <td><?php echo $row_entry['ticket_number'];  ?></td>
        </tr>
        <script>
        $('#birth_date<?= $count ?>_u').datetimepicker({ timepicker:false, format:'d-m-Y' });
        </script>
    <?php        
    }
    
}
?>
