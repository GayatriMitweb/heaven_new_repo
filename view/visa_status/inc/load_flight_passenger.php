<?php  
include "../../../model/model.php";
$booking_id = $_POST['booking_id'];
$count = 0;
?>
<option value="">Select Passenger</option>
<?php 
      $sq_traveler = mysql_query("select * from ticket_master_entries where ticket_id='$booking_id' and status!='Cancel'");
      while($row_traveler = mysql_fetch_assoc($sq_traveler))
      {
      	$count++;
       ?>
       <option value="<?php echo $row_traveler['entry_id'] ?>"><?php echo $count." : ".$row_traveler['first_name']." ".$row_traveler['last_name']; ?></option>
       <?php    
      }    
?>