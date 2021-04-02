<?php
include "../../../model/model.php";

$entity_for=$_POST['entity_for'];
$emp_id=$_POST['emp_id'];
$branch_status=$_POST['branch_status'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];

if($entity_for=='Group Tour' || $entity_for=='Package Tour'){
?>
<div class="col-sm-4 mg_bt_30">
    <select id="dest_name_s"  name="dest_name_s" title="Select Destination" class="form-control"  style="width:100%"> 
        <option value="">*Destination</option>
        <?php 
        $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
        while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
            <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
            <?php } ?>
    </select>
</div>
<?php } ?>