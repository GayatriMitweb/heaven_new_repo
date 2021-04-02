<?php
include "../../../model/model.php";
$dest_id = $_POST['dest_id'];
?>
<option value="">*Select Package</option>
<?php if($dest_id != 0){
$sq_tours = mysql_query("select * from custom_package_master where dest_id = '$dest_id' and status!='Inactive'");
    while($row_tours = mysql_fetch_assoc($sq_tours)){ ?>
      <option value="<?php echo $row_tours['package_id']; ?>"><?php echo  $row_tours['package_name']; ?></option>
  <?php } 
} ?>
