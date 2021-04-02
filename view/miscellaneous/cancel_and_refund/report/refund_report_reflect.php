<?php
include "../../../../model/model.php";

$misc_id = $_POST['misc_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];

$query = "select * from miscellaneous_refund_master where 1 ";
if($misc_id!=""){
	$query .=" and misc_id='$misc_id'";
}
if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and refund_date between '$from_date' and '$to_date'";
}
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_refund" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right">Refund_Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
		$sq_refund = mysql_query($query);
		while($row_refund = mysql_fetch_assoc($sq_refund)){

			$traveler_name = "";
			$sq_refund_entries = mysql_query("select * from miscellaneous_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master_entries where entry_id='$row_refund_entry[entry_id]'"));

				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';

			$sq_entry_year = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$row_refund[misc_id]'"));
			$date = $sq_entry_year['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			}
			$traveler_name = trim($traveler_name, ", "); 
			$total_refund = $total_refund+$row_refund['refund_amount']; 
			
 			if($row_refund['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cleared"){ $bg='success';
				$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']==""){ $bg='';
				$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];
			}
			?>
			<tr class="<?= $bg;?>">
				<td><?= ++$count ?></td>
				<td><?= get_misc_booking_id($row_refund['misc_id'],$year); ?></td>
				<td><?= $traveler_name ?></td>
				<td><?= date('d/m/Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= number_format($row_refund['refund_amount'],2) ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="2">Refund Amount: <?= ($total_refund=="") ? number_format(0,2) : number_format($total_refund,2) ?></th>
			<th colspan="2" class="text-right warning">Total Pending : <?= ($sq_pending_amount=='')?number_format(0,2):number_format($sq_pending_amount,2);?></th>
			<th colspan="2" class="text-right danger">Total Cancel: <?= ($sq_cancel_amount=='')?number_format(0,2):number_format($sq_cancel_amount,2);?> </th>
			<th colspan="2" class="text-right success">Total Paid : <?= ($sq_paid_amount=='')?number_format(0,2):number_format($sq_paid_amount,2); ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund').dataTable({
		"pagingType": "full_numbers"
	});
</script>