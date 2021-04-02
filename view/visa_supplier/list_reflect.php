<?php
include "../../model/model.php";

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$supp_id = $_POST['supp_id'];
$financial_year_id = $_POST['financial_year_id'];

$query = "select * from  visa_supplier_payment where 1 ";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and payment_date between '$from_date' and '$to_date'";
}
if($supp_id!=""){
	$query .= " and supplier_id='$supp_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="supplier_table" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th style="width: 10%">S_No.</th>
			<th>Supplier</th>
			<th>Date</th>
			<th>Mode</th>		
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
		while($row_sup = mysql_fetch_assoc($sq_income)){

			$sq_sup = mysql_fetch_assoc(mysql_query("select * from visa_vendor where vendor_id='$row_sup[supplier_id]'"));

			$sq_paid_amount = $sq_paid_amount + $row_sup['payment_amount'];
			if($row_sup['clearance_status']=="Pending"){ 
				$bg = 'warning';
				$sq_pending_amount = $sq_pending_amount + $row_sup['payment_amount'];
			}
			else if($row_sup['clearance_status']=="Cancelled"){ 
				$bg = 'danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_sup['payment_amount'];
			}
			else{
				$bg = '';
			}

			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_sup['vendor_name'] ?></td>
				<td><?= get_date_user($row_sup['payment_date']) ?></td>
				<td><?= $row_sup['payment_mode'] ?></td>				
				<td class="text-right success"><?= $row_sup['payment_amount'] ?></td>
				<td class="text-center">
					<button class="btn btn-info btn-sm" onclick="update_income_modal(<?= $row_sup['id'] ?>)"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="2">Payment : <?= number_format((($sq_paid_amount=="") ? 0 : $sq_paid_amount), 2); ?></th>
			<th class="text-right warning" colspan="2">Pending : <?= number_format((($sq_pending_amount=="") ? 0 : $sq_pending_amount), 2); ?></th>
			<th class="text-right danger" colspan="1">Cancelled : <?= number_format((($sq_cancel_amount=="") ? 0 : $sq_cancel_amount), 2); ?></th>
			<th class="text-right success" colspan="1">Total : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_cancel_amount), 2); ?></th>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
	$('#supplier_table').dataTable({
		"pagingType": "full_numbers"
	});
</script>

</div> </div> </div>