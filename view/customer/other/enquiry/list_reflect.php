<?php 
include_once('../../../../model/model.php');

$customer_id = $_SESSION['customer_id'];

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];

$query = "select * from customer_enquiry_master where customer_id='$customer_id' ";
if($from_date!="" and $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and date(created_at) between '$from_date' and '$to_date'";
}
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="min-width:60px">Sr. No</th>
			<th style="min-width:200px">Service Name</th>
			<th>Enquiry Specification</th>
			<th style="min-width:200px">Enquiry Date</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_enq = mysql_query($query);
		while($row_enq = mysql_fetch_assoc($sq_enq)){
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $row_enq['service_name'] ?></td>
				<td><?= $row_enq['enquiry_specification'] ?></td>
				<td><?= get_date_user($row_enq['created_at']) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_enq['enquiry_id'] ?>)"><i class="fa fa-pencil"></i></button>
				</td>
			</tr>
			<?php
		}
		?>	
	</tbody>
</table>

</div> </div> </div>