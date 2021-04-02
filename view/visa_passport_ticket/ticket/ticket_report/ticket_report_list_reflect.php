<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$ticket_id = $_POST['ticket_id'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

$query = "select * from ticket_trip_entries where 1 ";
if($ticket_id!=""){
	$query .=" and ticket_id='$ticket_id'";	
}
if($customer_id!=""){
	$query .=" and ticket_id in ( select ticket_id from ticket_master where customer_id='$customer_id' )";	
}
if($cust_type != ""){
	$query .= " and ticket_id in (select ticket_id from ticket_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($company_name != ""){
	$query .= " and ticket_id in (select ticket_id from ticket_master where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and ticket_id in (select ticket_id from ticket_master where emp_id='$emp_id') and ticket_id in (select ticket_id from ticket_master where branch_admin_id = '$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and ticket_id in (select ticket_id from ticket_master where emp_id='$emp_id' ))";
}

if($financial_year_id != ""){
	$query .= " and ticket_id in (select ticket_id from ticket_master where financial_year_id='$financial_year_id')";
}
$query .= " order by ticket_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_ticket_report" style="margin: 20px 0 !important;">
	<thead> 
	    <tr class="table-heading-row">
	    	<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>Departure_Date&Time</th>
			<th>Arrival_Date&Time</th>
			<th>Airline</th>
			<th>Class</th>
			<th>Flight_No.</th>
			<th>Airline_PNR</th>
			<th>Sector(From_To)</th>
	    </tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		
		$sq_trip = mysql_query($query);	
		while($row_trip = mysql_fetch_assoc($sq_trip)){

			$sq_ticket = mysql_fetch_assoc(mysql_query("select * from ticket_master where ticket_id='$row_trip[ticket_id]'"));
			$date = $sq_ticket['created_at'];
	            $yr = explode("-", $date);
	           	$year =$yr[0];

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_ticket[customer_id]'"));
			if($sq_customer_info['type'] == 'Corporate'){
				$cust_name = $sq_customer_info['company_name'];
			}else{
				$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
			}
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= get_ticket_booking_id($row_trip['ticket_id'],$year) ?></td>
				<td><?= $cust_name ?></td>
				<td><?=  date('d/m/Y H:i:s', strtotime($row_trip['departure_datetime'])) ?></td>
				<td><?= date('d/m/Y H:i:s', strtotime($row_trip['arrival_datetime'])) ?></td>
				<td><?= $row_trip['airlines_name'] ?></td>
				<td><?= $row_trip['class'] ?></td>
				<td><?= $row_trip['flight_no'] ?></td>
				<td><?= $row_trip['airlin_pnr'] ?></td>
				<td><?= $row_trip['departure_city'].' -- '.$row_trip['arrival_city'] ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
	$('#tbl_ticket_report').dataTable({
		"pagingType": "full_numbers"
	});
</script>