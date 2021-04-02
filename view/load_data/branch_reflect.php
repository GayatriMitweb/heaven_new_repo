<?php
include "../../model/model.php";

$emp_id = $_POST['emp_id'];

$sq_user = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
 
$query = "select * from branches where 1";
     /* if($branch_status=='yes' && $role!='Admin'){
    $query .= " and branch_id = '$branch_admin_id'";
    } */
    $query .= " and branch_id = '$sq_user[branch_id]'";
    $query .= " order by branch_name";
    $sq_branch = mysql_query($query);
    while($row_branch = mysql_fetch_assoc($sq_branch)){

      ?>
      <option value="<?=  $row_branch['branch_id'] ?>"><?= $row_branch['branch_name'] ?></option>
      <?php
    } 
   
?>
 