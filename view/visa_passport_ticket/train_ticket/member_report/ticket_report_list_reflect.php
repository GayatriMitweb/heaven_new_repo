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

$query = "select * from train_ticket_master_entries where 1 ";
if($customer_id!=""){
	$query .=" and train_ticket_id in ( select train_ticket_id from train_ticket_master where customer_id='$customer_id' )";
}
if($train_ticket_id!=""){
	$query .=" and train_ticket_id='$train_ticket_id'";
}
if($from_date!="" && $to_date!=""){
			$from_date = date('Y-m-d', strtotime($from_date));
			$to_date = date('Y-m-d', strtotime($to_date));
			$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where created_at between '$from_date' and '$to_date')";
		}
if($cust_type != ""){
	$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id in ( select customer_id from customer_master where type='$cust_type' ))";
}
if($company_name != ""){
	$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id in ( select customer_id from customer_master where company_name='$company_name' ))";
}

if($financial_year_id != ""){
	$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where financial_year_id='$financial_year_id')";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where branch_admin_id='$branch_admin_id') ";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where emp_id='$emp_id' and branch_admin_id = '$branch_admin_id')";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
	$query .= " and train_ticket_id in (select train_ticket_id from train_ticket_master where emp_id='$emp_id' )";
}
$query .= " order by train_ticket_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_train_ticket_report" style="margin: 20px 0 !important;">
	<thead>
		<tr class="active table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>Passenger_Name</th>
			<th>Birth_Date</th>
			<th>Adolescence</th>
			<th>Coach_No.</th>
			<th>Seat_No.</th>
			<th>Ticket_No.</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_ticket = mysql_query($query);
		while($row_ticket = mysql_fetch_assoc($sq_ticket)){

			 $sq_train_ticket = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$row_ticket[train_ticket_id]'"));

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_train_ticket[customer_id]'"));


				$date = $sq_train_ticket['created_at'];
	            $yr = explode("-", $date);
	           	$year =$yr[0];

				$bg = ($row_ticket['status']=='Cancel') ? 'danger' : '';
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year) ?></td>
					<td><?= $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'] ?></td>
					<td><?= $row_ticket['first_name']." ".$row_ticket['last_name'] ?></td>
					<td><?= get_date_user($row_ticket['birth_date']) ?></td>
					<td><?= $row_ticket['adolescence'] ?></td>
					<td><?= $row_ticket['coach_number'] ?></td>
					<td><?= $row_ticket['seat_number'] ?></td>
					<td><?= $row_ticket['ticket_number'] ?></td>
				</tr>
				<?php
			}

		?>
	</tbody>
</table>
</div> </div> </div>
<script>
	$('#tbl_train_ticket_report').dataTable({
		"pagingType": "full_numbers"
	});
</script>