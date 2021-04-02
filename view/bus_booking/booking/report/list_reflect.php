<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];
$booking_id = $_POST['booking_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from bus_booking_entries where 1 ";
if($booking_id!=""){
	$query .= " and booking_id='$booking_id'";
}
if($customer_id!=""){
	$query .= " and booking_id in ( select booking_id from bus_booking_master where customer_id='$customer_id' )";
}
if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and booking_id in ( select booking_id from bus_booking_master where created_at between '$from_date' and '$to_date')";
	}
if($cust_type != ""){
	$query .= " and booking_id in (select booking_id from bus_booking_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($company_name != ""){
	$query .= " and booking_id in (select booking_id from bus_booking_master where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
}
if($financial_year_id != ''){
	$query .= " and booking_id in (select booking_id from bus_booking_master where financial_year_id='$financial_year_id')";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and booking_id in (select booking_id from bus_booking_master where branch_admin_id ='$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and booking_id in (select booking_id from bus_booking_master where emp_id ='$emp_id' and branch_admin_id ='$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and booking_id in (select booking_id from bus_booking_master where emp_id ='$emp_id')";
}

$query .= " order by booking_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>Bus_Operator</th>
			<th>Bus_Type</th>
			<th>Source_Destination</th>
			<th>Journey_Date&Time</th>
			<th>Reporting_Time</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_entry = mysql_query($query);
		while($row_entry = mysql_fetch_assoc($sq_entry)){

			$sq_bus = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_entry[booking_id]'"));
			$date = $sq_bus['created_at'];
	        $yr = explode("-", $date);
	        $year =$yr[0];
			$sq_customer = mysql_fetch_assoc(mysql_query("select first_name, last_name from customer_master where customer_id='$sq_bus[customer_id]'"));

			$bg = ($row_entry['status']=="Cancel") ? "danger" : "";

			$count++;
			?>
			<tr class="<?= $bg ?>">
				<td><?= $count ?></td>
				<td><?= get_bus_booking_id($row_entry['booking_id'],$year) ?></td>
				<td><?= $sq_customer['first_name'].' '.$sq_customer['last_name'] ?></td>
				<td><?= $row_entry['company_name'] ?></td>
				<td><?= $row_entry['bus_type'] ?></td>
				<td><?= $row_entry['origin'].' -- '.$row_entry['destination'] ?></td>
				<td><?= get_datetime_user($row_entry['date_of_journey']) ?></td>
				<td><?= $row_entry['reporting_time'] ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>