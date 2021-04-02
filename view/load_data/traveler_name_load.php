<?php include "../../model/model.php"; ?>
<?php
  
  $traveler_group_id = $_GET['traveler_group_id'];  

?>
<option value="select"> Select Traveler Name </option>        
<?php
  $sq = mysql_query("select * from travelers_details where traveler_group_id= '$traveler_group_id' and status='Active' ");
  while($row = mysql_fetch_assoc($sq))
  {
   ?>
    <option value="<?php echo $row['traveler_id'] ?>"><?php echo $row['first_name']." ".$row['last_name']; ?></option>
   <?php 
  }  

?>