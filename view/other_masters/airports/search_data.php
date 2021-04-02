<?php include "../../../model/model.php";

$search = $_POST['search'];
$limit = $_POST['limit'];
$start = $_POST['start'];

if($search!=''){
	$query = "SELECT * FROM `airport_master` where airport_id like '%$search%' or airport_name like '%$search%' or airport_code like '%$search%'";
}
else{
	$query = "SELECT * FROM `airport_master` where 1";
}
$sq_airport = mysql_query($query);
while($row_airport = mysql_fetch_assoc($sq_airport)){
	$bg = ($row_airport['flag']=="Inactive") ? "danger" : "";
	$sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$row_airport[city_id]'")); ?>
	<tr class="<?= $bg ?>">
		<td><?php echo $row_airport['airport_id'] ?></td>
		<td><?= $sq_city['city_name'] ?></td>
		<?php $row_airport_nam = clean($row_airport['airport_name']); ?>
		<td><?= $row_airport_nam ?></td>
		<td><?= strtoupper($row_airport['airport_code']) ?></td>
		<td>
			<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_airport['airport_id'] ?>)" title="Edit Airport"><i class="fa fa-pencil-square-o"></i></button>
		</td>
	</tr>
<?php } ?>