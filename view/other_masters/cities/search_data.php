<?php include "../../../model/model.php";

$search = $_POST['search'];
$limit = $_POST['limit'];
$start = $_POST['start'];

$count = 1;
if($search!=''){
	$query = "SELECT * FROM `city_master` where city_id like '%$search%' or city_name like '%$search'";
}
else{
	$query = "SELECT * FROM `city_master` where 1";
}
$sq = mysql_query($query);
while($row=mysql_fetch_assoc($sq)){
  $count++;
  $bg = ($row['active_flag']=="Inactive") ? "danger" : "";
  ?>
  <tr class="<?= $bg ?>">
    <td><?php echo $row['city_id'] ?></td>
    <td><?php echo $row['city_name'] ?></td>
    <td>
      <a href="javascript:void(0)" onclick="city_master_update_modal(<?php echo $row['city_id'] ?>)" class="btn btn-info btn-sm" title="Edit city"><i class="fa fa-pencil-square-o"></i></a>
    </td>
  </tr>
<?php } ?>