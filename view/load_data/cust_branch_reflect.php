<?php
include "../../model/model.php";

$cust_id = $_POST['cust_id'];

$sq_user = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$cust_id'"));
 
$query = "select * from branches where 1";     
    $query .= " and branch_id = '$sq_user[branch_admin_id]'";
    $query .= " order by branch_name";
    $sq_branch = mysql_query($query);
    while($row_branch = mysql_fetch_assoc($sq_branch)){

      ?>
      <option value="<?=  $row_branch['branch_id'] ?>"><?= $row_branch['branch_name'] ?></option>
      <?php
    } 
   
?>