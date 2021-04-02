<?php
include_once('../../../../model/model.php');
include_once('../../inc/vendor_generic_functions.php');

$estimate_id = $_POST['estimate_id'];

$query = "select * from vendor_estimate where status='Cancel' ";
if($estimate_id!=""){
	$query .=" and estimate_id='$estimate_id'";
}
$query .=" order by estimate_id desc ";
?>


<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Cost_ID</th>
			<th>Purchase_Type</th>
			<th>Purchase_ID</th>
			<th>Supplier_Type</th>
			<th>Supplier_Name</th>
			<th>Total_Refund</th>
			<th>Refund</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_estimate = mysql_query($query);
		while($row_estimate = mysql_fetch_assoc($sq_estimate)){
			$date = $row_estimate['purchase_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$estimate_type_val = get_estimate_type_name($row_estimate['estimate_type'], $row_estimate['estimate_type_id']);
			$vendor_type_val = get_vendor_name($row_estimate['vendor_type'], $row_estimate['vendor_type_id']);

			$bg = ($row_estimate['cancel_amount']!="0") ? "success" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= get_vendor_estimate_id($row_estimate['estimate_id'],$year) ?></td>
				<td><?= $row_estimate['estimate_type'] ?></td>
				<td><?= $estimate_type_val ?></td>
				<td><?= $row_estimate['vendor_type'] ?></td>
				<td><?= $vendor_type_val ?></td>
				<td><?= $row_estimate['total_refund_amount'] ?></td>		
				<?php if($bg!='success'){ ?>				
					<td>
						<button class="btn btn-info btn-sm" onclick="save_modal(<?= $row_estimate['estimate_id'] ?>)"><i class="fa fa-pencil-square-o"></i></button>
					</td>
				<?php }else{ ?>
					<td>
						<button class="btn btn-info btn-sm" onclick="save_modal(<?= $row_estimate['estimate_id'] ?>)"><i class="fa fa-eye"></i></button>
					</td>
				<?php } ?>			
			</tr>
			<?php
		}
		?>
	</tbody>	
</table>



</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>