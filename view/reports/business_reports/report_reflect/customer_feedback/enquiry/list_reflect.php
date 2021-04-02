<?php 
include_once('../../../../model/model.php');


$customer_id = $_POST['customer_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$query = "select * from customer_enquiry_master where 1 ";
if($customer_id!=""){
	$query .=" and customer_id='$customer_id'";
}
if($from_date!="" and $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and date(created_at) between '$from_date' and '$to_date'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-bordered" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Customer_Name</th>
			<th>Mobile</th>
			<th>Email_ID</th>
			<th>Service_Name</th>
			<th>Specification</th>
			<th>Enquiry_Date</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_enq = mysql_query($query);
		while($row_enq = mysql_fetch_assoc($sq_enq)){

			  $sq_query_cust = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id ='$row_enq[customer_id]'")); 
			  
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $sq_query_cust['first_name'].' '.$sq_query_cust['last_name'] ?></td>
				<td><?= $sq_query_cust['contact_no'] ?></td>
				<td><?= $sq_query_cust['email_id'] ?></td>
				<td><?= $row_enq['service_name'] ?></td>
				<td><?= $row_enq['enquiry_specification'] ?></td>
				<td><?= get_date_user($row_enq['created_at']) ?></td>
			</tr>
			<?php
		}
		?>	
	</tbody>
</table>

</div> </div> </div>
<script>
$('#tbl_list').dataTable({"pagingType": "full_numbers"});
</script>