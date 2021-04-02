<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$train_ticket_id = $_POST['train_ticket_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

$query = "select * from train_ticket_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($train_ticket_id!=""){
	$query .=" and train_ticket_id='$train_ticket_id'";
}
if($from_date!="" && $to_date!=""){
			$from_date = date('Y-m-d', strtotime($from_date));
			$to_date = date('Y-m-d', strtotime($to_date));
			$query .= " and date(created_at) between '$from_date' and '$to_date'";
		}
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
include "../../../../model/app_settings/branchwise_filteration.php";	
$query .= " order by train_ticket_id desc";	
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_train_trip_report" style="margin: 20px 0 !important;">
	<thead>
		<tr class="active table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_name</th>
			<th>From_Location</th>
			<th>To_Location</th>
			<th>Train_Name</th> 
			<th>Train_No.</th>
			<th>Class</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_ticket = mysql_query($query);
		while($row_ticket =mysql_fetch_assoc($sq_ticket)){

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			$sq_entry1 = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_trip_entries where train_ticket_id='$row_ticket[train_ticket_id]'"));
			$date = $row_ticket['created_at'];
	        $yr = explode("-", $date);
	        $year =$yr[0];
					?>
					<tr class="<?= $bg ?>">
						<td><?= ++$count ?></td>
						<td><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year) ?></td>
						<td><?= $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'] ?></td>
						<td><?= $sq_entry1['travel_from'] ?></td>
						<td><?= $sq_entry1['travel_to'] ?></td>
						<td><?= $sq_entry1['train_name'] ?></td>
						<td><?= $sq_entry1['train_no'] ?></td>
						<td><?= $sq_entry1['class'] ?></td>

					</tr>
					<?php
				}
			
		?>
	</tbody>
</table>
</div> </div> </div>
<script>
	$('#tbl_train_trip_report').dataTable({
		"pagingType": "full_numbers"
	});
</script>