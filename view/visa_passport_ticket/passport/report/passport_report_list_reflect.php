<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_status = $_POST['branch_status'];
$customer_id = $_POST['customer_id'];
$passport_id = $_POST['passport_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$cust_type = $_POST['cust_type'];
$company_name = $_POST['company_name'];

$query = "select * from passport_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($passport_id!=""){
	$query .=" and passport_id='$passport_id'";
}
if($from_date!="" && $to_date!=""){
			$from_date = date('Y-m-d', strtotime($from_date));
			$to_date = date('Y-m-d', strtotime($to_date));
			$query .= " and created_at between '$from_date' and '$to_date'";
}

if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by passport_id desc ";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-bordered" id="tbl_passport_report" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>customer_name</th>
			<th>Passenger_Name</th>
			<th>Birth_Date</th>
			<th>Received_Documents</th>
		</tr>
		
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_passport = mysql_query($query);
		while($row_passport =mysql_fetch_assoc($sq_passport)){

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_passport[customer_id]'"));

			$sq_entry = mysql_query("select * from passport_master_entries where passport_id='$row_passport[passport_id]'");

			$date = $row_passport['created_at'];
            $yr = explode("-", $date);
           	$year =$yr[0];
			while($row_entry = mysql_fetch_assoc($sq_entry)){

				$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_passport_booking_id($row_passport['passport_id'],$year) ?></td>
					<td><?= $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'] ?></td>
					<td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
					<td><?= date('d/m/Y', strtotime($row_entry['birth_date'])) ?></td>
					<td><?= $row_entry['received_documents'] ?></td>
				</tr>
				<?php
			}

		}
		?>
	</tbody>
</table>
</div> </div> </div>
<script>
	$('#tbl_passport_report').dataTable({
		"pagingType": "full_numbers"
	});
</script>