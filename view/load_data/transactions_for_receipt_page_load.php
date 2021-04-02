<?php include "../../model/model.php"; ?>
<?php
  
  $tour_id = $_GET['tour_id'];  
  $tour_group_id = $_GET['tour_group_id'];  
  $traveler_group_id = $_GET['traveler_group_id'];  
  $traveling_type = $_GET['traveling_type'];

  $sq = mysql_fetch_assoc(mysql_query("select id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id='$tour_group_id' and  traveler_group_id='$traveler_group_id'  "));

  $tourwise_id = $sq['id'];
?>
	<option value="select"> Select Transaction </option>   
<?php

  $sq = mysql_query("select * from payment_master where tourwise_traveler_id='$tourwise_id' and payment_for='$traveling_type'");
  while($row = mysql_fetch_assoc($sq))
  {
    if($row['amount']!=0)
    {  
  	?> 

     <option value="<?php echo $row['payment_id'] ?>"><?php echo $row['payment_id'].'-'.$row['amount']; ?></option>

    <?php
    } 
  }  

?>