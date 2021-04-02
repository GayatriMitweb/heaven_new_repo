<?php
include_once('../../../../model/model.php');

include_once('vendor_generic_functions.php');

$user_id = $_SESSION['user_id'];
$vendor_type = $_SESSION['vendor_type'];
$query = "select * from vendor_estimate where 1 ";
$query .= " and vendor_type='$vendor_type'";
$query .= " and vendor_type_id='$user_id'";
?>
<div class="row mg_tp_20"> 
	<div class="col-md-12"> 
	 <div class="table-responsive">
			<table class="table table-hover" id="tbl_estimate_list" style="margin: 20px 0 !important;">
				<thead>
					<tr class="active table-heading-row">
						<th>S_No.</th>
						<th>Purchase_Type</th>
						<th>Purchase_ID</th>
						<th>Amount</th>
						<th>Remark</th>
						<th>Invoice</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total_estimate_amt = 0;
					$count = 0;
					$sq_estimate = mysql_query($query);
					while($row_estimate = mysql_fetch_assoc($sq_estimate)){

						$total_estimate_amt = $total_estimate_amt + $row_estimate['net_total'];

						$estimate_type_val = get_estimate_type_name($row_estimate['estimate_type'], $row_estimate['estimate_type_id']);
						$vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);

						$purchase_amount=$row_estimate['net_total']-$row_estimate['refund_net_total'];

						$bg = ($row_estimate['status']=="Cancel") ? "danger" : "";

						$newUrl = $row_estimate['invoice_proof_url'];
						if($newUrl!=""){
							$newUrl = preg_replace('/(\/+)/','/',$row_estimate['invoice_proof_url']); 
							$newUrl_arr = explode('uploads/', $newUrl);
							$newUrl = BASE_URL.'uploads/'.$newUrl_arr[1];	
						}
						?>
						<tr class="<?= $bg ?>">
							<td><?= ++$count ?></td>
							<td><?= $row_estimate['estimate_type'] ?></td>
							<td><?= $estimate_type_val ?></td>
							<td><?= $row_estimate['net_total'] ?></td>
							<td><?= $row_estimate['remark'] ?></td>
							<td>
								<?php if($newUrl!=""){ ?>
									<a class="btn btn-info btn-sm" href="<?php echo $newUrl; ?>" download  title="Download Invoice"><i class="fa fa-download"></i></a>
								<?php } ?>								
							</td>		
						</tr>
						<?php
					}
					?>
				</tbody>	
			</table>
		</div>
		</div>
</div>
<script>
$('#tbl_estimate_list').dataTable({
		"pagingType": "full_numbers"
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>