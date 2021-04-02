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

$query = "select * from ticket_master where financial_year_id='$financial_year_id' ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($ticket_id!=""){
	$query .=" and ticket_id='$ticket_id'";
}
if($cust_type != ""){
	$query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($company_name != ""){
	$query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}	
if($role == "B2b"){
	$query .= " and emp_id='$emp_id'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by ticket_id desc ";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_ticket_report" style="margin: 20px 0 !important;">
	<thead>
	    <tr class="table-heading-row">
	    	<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name</th>
			<th>Passenger_Name</th>
			<th>Adolescence</th>
			<th>Ticket_No</th>
			<th>Gds_Pnr</th>
	    </tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_ticket = mysql_query($query);
		while($row_ticket =mysql_fetch_assoc($sq_ticket)){

			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			if($sq_customer_info['type'] == 'Corporate'){
				$cust_name = $sq_customer_info['company_name'];
			}else{
				$cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
			}

			$date = $row_ticket['created_at'];
            $yr = explode("-", $date);
           	$year =$yr[0];

			$sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'");
			while($row_entry = mysql_fetch_assoc($sq_entry)){


				$bg = ($row_entry['status']=='Cancel') ? 'danger' : '';
				?>
				<tr class="<?= $bg ?>">
					<td><?= ++$count ?></td>
					<td><?= get_ticket_booking_id($row_ticket['ticket_id'],$year) ?></td>
					<td><?= $cust_name ?></td>
					<td><?= $row_entry['first_name']." ".$row_entry['last_name'] ?></td>
					<td><?= $row_entry['adolescence'] ?></td>
					<td><?= $row_entry['ticket_no'] ?></td>
					<td><?= $row_entry['gds_pnr'] ?></td>
				</tr>
				<?php
			}

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