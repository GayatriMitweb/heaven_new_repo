<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table trable-hover" style="margin: 20px 0 !important;">
<thead>
<tr class="table-heading-row">
    <th>S_No.</th>
    <th>Tour_Name</th>
    <th>Tour_Date</th>    
    <th>Passenger_Name</th>
    <th>Handover_Itinerary</th>
    <th>Handover_Gift</th>
</tr>
</thead>
<tbody>
<?php
$count = 1;
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];

$query = "select * from tourwise_traveler_details where 1";

if($role=='Sales'){
 $query .=" and emp_id='$emp_id'";
} 
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .=" and branch_admin_id = '$branch_admin_id'";
}
$query .=" and tour_group_status!='Cancel'";
 
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
	

	$sq2 = mysql_query("select * from travelers_details where traveler_group_id = '$row1[traveler_group_id]' and status = 'Active'");
	while($row2 = mysql_fetch_assoc($sq2))
	{
		if($row2['handover_adnary']=="yes")
		{
			$adnary_status = "disabled";
			$class1 = "btn btn-danger table-danger-btn";
		}
		else
		{
			$adnary_status = "";
			$class1 = "btn btn-success";
		}	
		if($row2['handover_gift']=="yes")
		{
			$gift_status = "disabled";
			$class2 = "btn btn-danger table-danger-btn";
		}
		else
		{
			$gift_status = "";
			$class2 = "btn btn-success";
		}	
?>
	  <tr>
	  	<td><?php echo $count ?></td>
	  	<td><?php echo $tour_name ?></td>
	  	<td><?php echo $tour_group_from." to ".$tour_group_to ?></td>
	  	<td><?php echo $row2['first_name']." ".$row2['last_name'] ?></td>
	  	<td>
	  		<button class="<?php echo $class1; ?> btn-sm ico_left" id="<?php echo 'handover_adnary'.$count; ?>" value="<?php echo $row2['traveler_id'] ?>" onclick="hanover_adnary(this.id)" <?php echo $adnary_status ?> ><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Handover</button>
	  	</td>
	  	<td>
	  		<button class="<?php echo $class2; ?> btn-sm ico_left" id="<?php echo 'handover_gift'.$count; ?>" value="<?php echo $row2['traveler_id'] ?>" onclick="hanover_gift(this.id)" <?php echo $gift_status ?> ><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Handover</button>
	  	</td>
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
<script src="js/adnary.js"></script>