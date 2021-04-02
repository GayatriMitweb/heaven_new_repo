<?php  
include "../../../model/model.php";
$booking_id = $_POST['booking_id'];
$count= 0;
?>
<option value="">Select Passenger</option>
<?php 
       $sq_travelers_details = mysql_query("select visa_id,entry_id, first_name, last_name from visa_master_entries where visa_id='$booking_id' and status != 'Cancel'  order by visa_id desc"); 
       while($row_travelers_details = mysql_fetch_assoc( $sq_travelers_details ))
       {
       	$count++;
        ?>
        <option value="<?php echo $row_travelers_details['entry_id'] ?>"><?php echo $count.' : '.$row_travelers_details['first_name'].' '.$row_travelers_details['last_name']; ?></option>
        <?php
       }  
?>