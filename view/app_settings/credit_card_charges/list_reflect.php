<?php
include "../../../model/model.php";
$active_flag = $_POST['active_flag'];
?>
<div class="table-responsive mg_tp_20">
	
<table class="table table-hover" id="tbl_list_cr" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Company_Name</th>
			<th>Card_Charges</th>
			<th>Tax_on_charges</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$query = "select * from credit_card_company";
		if($active_flag != ''){
			$query .= " where status = '$active_flag'";
		}
		$sq_credit = mysql_query($query);
		while($row_credit = mysql_fetch_assoc($sq_credit)){
			$temp_str = ($row_credit['charges_in']=='Percentage') ? '%' : '(Flat)';
			$temp_str1 = ($row_credit['tax_charges_in']=='Percentage') ? '%' : '(Flat)';
			$bg = ($row_credit['status']=='Inactive') ? 'danger' : '';
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_credit['company_name'] ?></td>
				<td><?= $row_credit['credit_card_charges'].$temp_str ?></td>
				<td><?= $row_credit['tax_on_credit_card_charges'].$temp_str1 ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_credit['entry_id'] ?>)" title="Edit Detail"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php } ?>
	</tbody>
</table>
</div>
<script>
$('#tbl_list_cr').dataTable({
	"pagingType": "full_numbers"
});
</script>