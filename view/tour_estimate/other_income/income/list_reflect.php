<?php
include "../../../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$income_type_id = $_POST['income_type_id'];
$financial_year_id = $_POST['financial_year_id'];

$query = "select * from other_income_master where 1 ";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and payment_date between '$from_date' and '$to_date'";
}
if($income_type_id!=""){
	$query .= " and income_type_id='$income_type_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="income_table" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Income_Type</th>
			<th>Date</th>
			<th>Mode</th>
			<th>Narration</th>
			<th class="text-right">Amount</th>
			<th class="text-center">Edit</th>
		</tr>	
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
		$sq_income = mysql_query($query);
		while($row_income = mysql_fetch_assoc($sq_income)){

			$sq_income_type_info = mysql_fetch_assoc(mysql_query("select * from other_income_type_master where income_type_id='$row_income[income_type_id]'"));

			$sq_paid_amount = $sq_paid_amount + $row_income['payment_amount'];
			if($row_income['clearance_status']=="Pending"){ 
				$bg = 'warning';
				$sq_pending_amount = $sq_pending_amount + $row_income['payment_amount'];
			}
			else if($row_income['clearance_status']=="Cancelled"){ 
				$bg = 'danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_income['payment_amount'];
			}
			else{
				$bg = '';
			}

			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_income_type_info['income_type'] ?></td>
				<td><?= get_date_user($row_income['payment_date']) ?></td>
				<td><?= $row_income['payment_mode'] ?></td>
				<td><?= $row_income['particular'] ?></td>
				<td class="text-right success"><?= $row_income['payment_amount'] ?></td>
				<td class="text-center">
					<button class="btn btn-info btn-sm" onclick="update_income_modal(<?= $row_income['income_id'] ?>)"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="1">Payment : <?= number_format((($sq_paid_amount=="") ? 0 : $sq_paid_amount), 2); ?></th>
			<th class="text-right warning" colspan="2">Pending : <?= number_format((($sq_pending_amount=="") ? 0 : $sq_pending_amount), 2); ?></th>
			<th class="text-right danger" colspan="2">Cancelled : <?= number_format((($sq_cancel_amount=="") ? 0 : $sq_cancel_amount), 2); ?></th>
			<th class="text-right success" colspan="2">Total : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount), 2); ?></th>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
	$('#income_table').dataTable({
		"pagingType": "full_numbers"
	});
</script>

</div> </div> </div>