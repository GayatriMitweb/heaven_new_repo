<?php include "../../../../../model/model.php"; ?>
<div class="panel panel-default panel-body mg_bt_10">
<div class="row"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table trable-hover" style="margin: 20px 0 !important;">
<?php
$count=0;
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];
?>
<thead>
<tr class="table-heading-row">
	<th>S_No.</th>
	<th>Passenger_Name</th>
	<th>Refund_mode</th>
	<th>Refund_Amount</th>
	<th>Cheque_No/ID</th>
	<th>Bank_Name</th>	
</tr>
</thead>
<tbody>
<?php
$bg;
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;

$sq1="select * from refund_traveler_cancelation where 1";
if($branch_id!=""){

	$query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_admin_id')";
}
$sq1_q = mysql_query($sq1);
while($row1 = mysql_fetch_assoc($sq1_q))
{
	$row_span_count = mysql_num_rows(mysql_query(" select * from refund_traveler_cancalation_entries where refund_id='$row1[refund_id]' "));

	$first_time=true;



	$sq2 = mysql_query(" select * from refund_traveler_cancalation_entries where refund_id='$row1[refund_id]' ");
	while($row2 = mysql_fetch_assoc($sq2))
	{
		$count++;

		$sq_traveler_name= mysql_fetch_assoc(mysql_query("select first_name, last_name from travelers_details where traveler_id='$row2[traveler_id]' "));
		$traveler_name = $sq_traveler_name['first_name']." ".$sq_traveler_name['last_name'];

			if($row1['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row1['total_refund'];
			}

			if($row1['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row1['total_refund'];
			}

			if($row1['clearance_status']=="Cleared"){ $bg='success';
				$sq_paid_amount = $sq_paid_amount + $row1['total_refund'];
			}

			if($row1['clearance_status']==""){ $bg='';
				$sq_paid_amount = $sq_paid_amount + $row1['total_refund'];
			}

	?>
	<tr class="<?= $bg?>">
		<td><?php echo $count; ?></td>
		<td><?php echo $traveler_name ?></td>
		<?php 
		if($first_time==true)
		{	
		?>
		<td rowspan="<?php echo $row_span_count ?>"><?php echo $row1['refund_mode'] ?></td>
		<td rowspan="<?php echo $row_span_count ?>"><?php echo $row1['total_refund'] ?></td>		
		<td rowspan="<?php echo $row_span_count ?>"><?php echo $row1['transaction_id'] ?></td>
		<td rowspan="<?php echo $row_span_count ?>"><?php echo $row1['bank_name'] ?></td>
		<?php
		 $first_time=false;
		}
		?>
	</tr>	
	<?php	
	}	
}

?>	
</tbody>
<tfoot>
	<tr class="active">
		<th colspan="2" class="text-right">Total Paid : <?= number_format((($sq_paid_amount=='')?0:$sq_paid_amount), 2); ?></th>
		<th colspan="2" class="text-right">Total Pending : <?= number_format(($sq_pending_amount=='')?0:$sq_pending_amount), 2);?></th>
		<th colspan="2" class="text-right">Total Cancel: <?= number_format(($sq_cancel_amount=='')?0:$sq_cancel_amount), 2); ?> </th>
	</tr>
</tfoot>

</table>
</div>	</div> </div>
</div>
<script>
paginate_table();
</script>