<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table trable-hover" style="margin: 20px 0 !important;">
<?php

$role = $_SESSION['role'];

//Main If start************************
if($role!='Booker')
{
?>
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
$count = 1;
$bg;
$sq1 =mysql_query("select *  from tourwise_traveler_details where tour_group_status!='Cancel' order by emp_id");
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
	if($row_booker_name['first_name']==""){
		$booker_name ='Admin';
	}else{
	$booker_name = $row_booker_name['first_name']." ".$row_booker_name['last_name'];
    }
	$sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id = '$row1[customer_id]'"));

	$sq2 = mysql_query("select * from travelers_details where traveler_group_id = '$row1[traveler_group_id]'");
	while($row2 = mysql_fetch_assoc($sq2))
	{
		($row2['status']=='Cancel')?$bg='danger':$bg='';
?>
	  <tr class="<?= $bg?>">
	  	<td><?php echo $count; ?></td>
	  	<td><?php echo $booker_name; ?></td>
	  	<td><?php echo $tour_name; ?></td>
	  	<td><?php echo $tour_group_from; ?></td>
	  	<td><?php echo $tour_group_to; ?></td>
	  	<td><?php echo $row2['first_name']." ".$row2['last_name']; ?></td>
	  	<td><?php echo date("d/m/Y", strtotime($row1['form_date'])); ?></td>
	  </tr>	
<?php		
	 $count++;
	}	
}
?>
</tbody>
<?php
}//Main If end************************
?>
</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>