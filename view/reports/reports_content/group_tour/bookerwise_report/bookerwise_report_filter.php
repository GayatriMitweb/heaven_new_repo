<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table trable-hover" style="margin: 20px 0 !important;">
<thead>
<tr class="table-heading-row">
   <th>S_No.</th>
    <th>Booker_Name</th>
    <th>Tour</th>
    <th>Date_rom</th>
    <th>Date_To</th>
    <th>Passenger_Name</th>
    <th>Booking_Date</th>
</tr>
</thead>
<tbody>
<?php

$booker_id = $_GET['booker_id'];
$tour_id = $_GET['tour_id'];
$tour_group_id = $_GET['tour_group_id'];

$count = 1;

$query= "select *  from tourwise_traveler_details where ";

if($booker_id!="")
{
	$query = $query. " emp_id = '$booker_id' ";
}	
else
{
    $query = $query." 1 ";
}

if($tour_id!="")
{
	$query = $query. " and tour_id='$tour_id' ";
}	
else
{
	$query = $query." and 1 ";
}

if($tour_group_id!="")
{
	$query = $query. " and tour_group_id='$tour_group_id' ";
}	
else
{
	$query = $query." and 1 ";
}

$query = $query." and tour_group_status!='Cancel'  order by emp_id";


$sq1 =mysql_query($query);
while($row1 = mysql_fetch_assoc($sq1))
{

	$sq_tour_name = mysql_query("select tour_name from tour_master where tour_id='$row1[tour_id]'");
	$row_tour_name = mysql_fetch_assoc($sq_tour_name);
	$tour_name = $row_tour_name['tour_name'];


	$sq_tour_group_name = mysql_query("select from_date,to_date from tour_groups where group_id='$row1[tour_group_id]'");
	$row_tour_group_name = mysql_fetch_assoc($sq_tour_group_name);
	$tour_group_from = date("d/m/Y", strtotime($row_tour_group_name['from_date']));
	$tour_group_to = date("d/m/Y", strtotime($row_tour_group_name['to_date']));	
	


	$sq_booker_name = mysql_query("select first_name, last_name from emp_master where emp_id='$row1[emp_id]'");
	$row_booker_name = mysql_fetch_assoc($sq_booker_name);
	$booker_name = $row_booker_name['first_name']." ".$row_booker_name['last_name'];


	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row1[customer_id]'"));

	$sq2 = mysql_query("select * from travelers_details where traveler_group_id = '$row1[traveler_group_id]' and status = 'Active'");
	while($row2 = mysql_fetch_assoc($sq2))
	{
?>

	  <tr>
	  	<td><?php echo $count ?></td>
	  	<td><?php echo $booker_name ?></td>
	  	<td><?php echo $tour_name ?></td>
	  	<td><?php echo $tour_group_from ?></td>
	  	<td><?php echo $tour_group_to ?></td>
	  	<td><?php echo $row2['first_name']." ".$row2['last_name'] ?></td>
	  	<td><?php echo date("d/m/Y", strtotime($row1['form_date'])) ?></td>
	  </tr>	

<?php		
	 $count++;

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