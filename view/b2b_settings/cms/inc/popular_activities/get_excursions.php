<?php
include "../../../../../model/model.php";
$city_id = $_POST['city_id'];
?>
<option value="">*Select Excursion</option>
<?php if($city_id != 0){
$sq_exc = mysql_query("select * from excursion_master_tariff where city_id = '$city_id' and active_flag!='Inactive'");
    while($row_exc = mysql_fetch_assoc($sq_exc)){ ?>
      <option value="<?php echo $row_exc['excursion_name']; ?>"><?php echo  $row_exc['excursion_name']; ?></option>
  <?php } 
} ?>
