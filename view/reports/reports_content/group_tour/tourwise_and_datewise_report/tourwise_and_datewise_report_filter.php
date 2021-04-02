<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table trable-hover">

<?php
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];
$traveler_group_id = $_GET['traveler_group_id'];

$status = true;

$query = "select * from tourwise_traveler_details where ";
if($tour_id!="")
{
	$query = $query." tour_id='$tour_id' ";
}
else
{
	$query = $query." 1 ";	
}
if($tour_group_id!="")
{
	$query = $query." and tour_group_id='$tour_group_id' ";
}
else
{
	$query = $query." and 1 ";	
} 

$query = $query." and tour_group_status!='Cancel' ";	
?>
<thead>
<tr class="table-heading12">
    <th>S.N.</th>
    <th>Tour Name</th>
    <th>Tour Group</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Status</th>
    <th>M/F</th>
    <th>Address</th>
    <th>Mobile Number</th>
</tr>
</thead>
<tbody>
<?php
$count = 0;
$sq1 =mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{
	$tourwise_id = $row1['id']; 
	$sq_travler_personal_info = mysql_fetch_assoc(mysql_query("select * from traveler_personal_info where tourwise_traveler_id='$tourwise_id'"));
	
	$sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'");
	$row_tour_name = mysql_fetch_assoc($sq_tour_name);
	$tour_name = $row_tour_name['tour_name'];

	$sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$row1[tour_group_id]'");
	$row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
	$tour_group_from = date("d-m-Y", strtotime($row_tour_group_name['from_date']));
	$tour_group_to = date("d-m-Y", strtotime($row_tour_group_name['to_date']));

	if($traveler_group_id!="")
	{
		$state = 0;
		$query1 = "select * from travelers_details where traveler_group_id = '$traveler_group_id' and status = 'Active' ";
	}
	else
	{
		$state = 1;
		$query1 = "select * from travelers_details where traveler_group_id = '$row1[traveler_group_id]' and status = 'Active' ";
	}
	if($status == true)
	{ 
		$sq2 = mysql_query($query1);
		while($row2 = mysql_fetch_assoc($sq2))
		{
		  $count++;

		  	if($row2['gender']=="male") { $gender="M"; }
			if($row2['gender']=="female") { $gender="F"; }
			if($row2['status']=="Cancel") {	$text_color = "red"; }	
			else { $text_color="#000";	}	
			if($row2['birth_date']=="") { $birth_date=""; }
			else { $birth_date=date("d-m-Y",strtotime($row2['birth_date'])); }
	?>
		  <tr>
		  	<td><?php echo $count ?></td>
		  	<td><?php echo $tour_name ?></td>
		  	<td><?php echo $tour_group_from." to ".$tour_group_to ?></td>
		  	<td><?php echo $row2['first_name'] ?></td>
		  	<td><?php echo $row2['last_name'] ?></td>
		  	<td><?php echo $row2['adolescence'] ?></td>
		  	<td><?php echo $gender ?></td>
		  	<td><?php echo $sq_travler_personal_info['address'] ?></td>
		  	<td><?php echo $sq_travler_personal_info['mobile_no'] ?></td>
		  </tr>	
	<?php				 
		}
	      if($state == 0)
	      {
	      	$status = false;
	      }	
	}	
}
?>
</tbody>
</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>