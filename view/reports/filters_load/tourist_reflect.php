<?php
include "../../../model/model.php";

$branch_id = $_GET['branch_id'];
 
  $query="select * from travelers_details where 1";
 
  if($branch_id!=""){
    $query .=" and traveler_group_id in (select traveler_group_id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
  }
 
  $query .=" and status='Active'";
  $sq = mysql_query($query); ?>
  <option value=""> Select Tourist Name </option>
 <?php while($row=mysql_fetch_assoc($sq))
  { ?>
     <option value="<?= $row['traveler_id'] ?>"><?= $row['first_name']." ".$row['middle_name']." ".$row['last_name'] ?></option> 
<?php  }    
   
?>
 