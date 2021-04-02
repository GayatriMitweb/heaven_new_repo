<?php
include "../../../../model/model.php";
include_once('../../inc/vendor_generic_functions.php');
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$financial_year_id = $_SESSION['financial_year_id'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status']; 
$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];
$estimate_type = $_POST['estimate_type'];
$estimate_type_id = $_POST['estimate_type_id'];

$query = "select * from vendor_payment_master where payment_amount!='0' ";
if($financial_year_id!=""){
	$query .= " and financial_year_id='$financial_year_id'";
}
if($vendor_type!=""){
	$query .= " and vendor_type='$vendor_type'";
}
if($vendor_type_id!=""){
	$query .= " and vendor_type_id='$vendor_type_id'";
}
if($estimate_type!=""){
	$query .= " and estimate_type='$estimate_type'";
}
if($estimate_type_id!=""){
	$query .= " and estimate_type_id='$estimate_type_id'";
}

include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " order by payment_id desc ";
$total_paid_amt = 0;
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_payment_supplier" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Supplier_Type</th>
			<th>Supplier_ID</th>
			<th>Purchase_Type</th>
			<th>Purchase_ID</th>
			<th>Date</th>
			<th>Amount</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/Id</th>
			<th>Evidence</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;

		$sq_payment = mysql_query($query);		
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$total_payment=0;
		while($row_payment = mysql_fetch_assoc($sq_payment)){
			$vendor_type_val = get_vendor_name($row_payment['vendor_type'], $row_payment['vendor_type_id']);

            $total_payment = $total_payment + $row_payment['payment_amount'];
            $estimate_type_val = get_estimate_type_name($row_payment['estimate_type'], $row_payment['estimate_type_id']);
			if($row_payment['clearance_status']=="Pending"){ 
				$bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount'];
			}
			else if($row_payment['clearance_status']=="Cancelled"){ 
				$bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'];
			}
			else{
				$bg = '';
			}
			

			if($row_payment['payment_evidence_url']!=""){
				$url = explode('uploads', $row_payment['payment_evidence_url']);
				$url = BASE_URL.'uploads'.$url[1];
			}
			else{
				$url = "";
			}
			?>
			<tr class="<?= $bg;?>">
				<td><?= ++$count ?></td>
				<td><?= $row_payment['vendor_type'] ?></td>
				<td><?= $vendor_type_val ?></td>
				<td><?= ($row_payment['estimate_type'] =='')? 'NA': $row_payment['estimate_type'] ?></td>
				<td><?= ($estimate_type_val == '') ? 'NA'  : $estimate_type_val  ?></td>
				<td><?= date('d/m/Y', strtotime($row_payment['payment_date'])) ?></td>
				<td><?= $row_payment['payment_amount'] ?></td>
				<td><?= $row_payment['payment_mode'] ?></td>
				<td><?= $row_payment['bank_name'] ?></td>
				<td><?= $row_payment['transaction_id'] ?></td>
				<td>
					<?php 
					if($url!=""){
						?>
						<a href="<?= $url ?>" class="btn btn-info btn-sm" download title="download"><i class="fa fa-download"></i></a>
						<?php
					}
					?>
				</td>
				<td><button class="btn btn-info btn-sm" onclick="payment_update_modal(<?= $row_payment['payment_id'] ?>)"  title="Edit"><i class="fa fa-pencil-square-o"></i></button></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="3" class="text-right info">Total Paid : <?= number_format($total_payment, 2); ?></th>
			<th colspan="2" class="text-right warning">Total Pending : <?= number_format($sq_pending_amount, 2); ?></th>
			<th colspan="2" class="text-right danger">Total Cancel : <?= number_format($sq_cancel_amount, 2); ?></th>
			<th colspan="3" class="text-right success">Total Payment : <?= number_format(($total_payment - $sq_pending_amount - $sq_cancel_amount), 2); ?></th>
			<th colspan="2"></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>

<div id="div_payment_update_content"></div>
<script>
$('#tbl_payment_supplier').dataTable({
		"pagingType": "full_numbers"
	});
function payment_update_modal(payment_id){
	$.post('payment/payment_update_modal.php', { payment_id : payment_id }, function(data){
		$('#div_payment_update_content').html(data);
	});
}
</script>