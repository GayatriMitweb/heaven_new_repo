<?php 
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$estimate_id = $_POST['estimate_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];

$query = "select * from vendor_refund_master where 1 ";
if($estimate_id!=""){
	$query .= " and estimate_id='$estimate_id'";
}
if($from_date!='' && $to_date!=''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and payment_date between '$from_date' and '$to_date'";
}
$query .= 'order by refund_id desc';
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Cost_ID</th>
			<th>Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/Id</th>
			<th class="text-right">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$total_estimate_amt = 0;
		$cancelled_amount=0;
		$pending_amount=0;
		$total_amount=0;
		$sq_estimate = mysql_query($query);
		while($row_refund = mysql_fetch_assoc($sq_estimate)){
			$query = mysql_fetch_assoc(mysql_query("select * from vendor_estimate where estimate_id='$row_refund[estimate_id]'"));
			$date = $query['purchase_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$estimate_type_val = get_estimate_type_name($row_refund['estimate_type'], $row_refund['estimate_type_id']);
			$vendor_type_val = get_vendor_name($row_refund['vendor_type'], $row_refund['vendor_type_id']);

			$total_amount=$total_amount+$row_refund['payment_amount'];
			if($row_refund['clearance_status']=="Pending"){ 
				$bg = "warning";
				$pending_amount = $pending_amount + $row_refund['payment_amount'];
			}
			else if($row_refund['clearance_status']=="Cancelled"){
				$bg = "danger"; 
				$cancelled_amount = $cancelled_amount + $row_refund['payment_amount'];
			}
			else{
			    $bg = ""; 
			}
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= get_vendor_estimate_id($row_refund['estimate_id'],$year) ?></td>
				<td><?= date('d/m/Y', strtotime($row_refund['payment_date'])) ?></td>
				<td><?= $row_refund['payment_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= number_format($row_refund['payment_amount'],2) ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th></th>
			<th colspan="2" class="text-right info">Refund : <?= ($total_amount=="") ? number_format(0,2) : number_format($total_amount,2) ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($pending_amount=="") ? number_format(0,2) : number_format($pending_amount,2) ?></th>
			<th class="text-right danger">Cancelled : <?= ($cancelled_amount=="") ? number_format(0,2) : number_format($cancelled_amount,2) ?></th>
			<th class="text-right success">Total : <?= number_format(($total_amount - $pending_amount - $cancelled_amount),2) ?></th>
		</tr>
	</tfoot>	
</table>

</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>