<?php
include_once('../../../model/model.php');

$supplier_type = $_POST['supplier_type'];
$expense_type = $_POST['expense_type'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id'];
$financial_year_id = $_SESSION['financial_year_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$query = "select * from other_expense_master where 1 ";
if($supplier_type!=""){
	$query .= "and supplier_id='$supplier_type'";
}
if($expense_type!=""){
	$query .= "and expense_type_id='$expense_type'";
}
if($financial_year_id != ''){
	$query .= "and financial_year_id='$financial_year_id'";
}
if($branch_status=='yes'){
	$query .= " and branch_admin_id = '$branch_admin_id'";
}

if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
		$query .= " and branch_admin_id = '$branch_admin_id'";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
		$query .= " and branch_admin_id = '$branch_admin_id'";
	}
}

$query .= " order by expense_id desc";
?>
<div class="row mg_tp_20"> 
	<div class="col-md-12 no-pad"> 
	 <div class="table-responsive">
		<table class="table table-hover" id="tbl_expense_list" style="margin: 20px 0 !important;">
				<thead>
					<tr class="active table-heading-row">
						<th>S_No.</th>
						<th>Expense_ID</th>
						<th>Expense_Date</th>
						<th>Expense_Type</th>
						<th>Supplier_Name</th>
						<th>Invoice</th>
						<th class="info">Total</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$total_expense_amt = 0;
					$count = 0;
					$sq_expense = mysql_query($query);
					while($row_expense = mysql_fetch_assoc($sq_expense)){
						$date = $row_expense['expense_date'];
						$yr = explode("-", $date);
						$year =$yr[0];
						$sq_supp = mysql_fetch_assoc(mysql_query("select * from other_vendors where vendor_id='$row_expense[supplier_id]'"));
						$sq_ledger = mysql_fetch_assoc(mysql_query("select * from ledger_master where ledger_id='$row_expense[expense_type_id]'"));

						$sq_paid = mysql_fetch_assoc(mysql_query("select payment_amount as sum from other_expense_payment_master where expense_type_id='$row_expense[expense_type_id]' and supplier_id='$row_expense[supplier_id]'"));

						$balance_amt = $row_expense['total_fee'] - $sq_paid['sum'];
						$total_expense_amt = $total_expense_amt + $row_expense['total_fee'];
						$total_paid_amt = $total_paid_amt + $sq_paid['sum'];

						$newUrl = $row_expense['invoice_url'];
						if($newUrl!=""){
							$newUrl = preg_replace('/(\/+)/','/',$newUrl); 
							$newUrl_arr = explode('uploads/', $newUrl);
							$newUrl = BASE_URL.'uploads/'.$newUrl_arr[1];	
						}
						
						
						?>
						<tr class="<?= $bg ?>">
							<td><?= ++$count ?></td>
							<td><?= get_other_expense_booking_id($row_expense['expense_id'],$year) ?></td>
							<td><?= get_date_user($row_expense['expense_date']) ?></td>
							<td><?= $sq_ledger['ledger_name'] ?></td>
							<td><?= ($sq_supp['vendor_name'] == '') ? 'NA' : $sq_supp['vendor_name'] ?></td>							
							<?php if($newUrl != ''){ ?>
							<td>
							   <a class="btn btn-info btn-sm" href="<?php echo $newUrl; ?>" download  title="Download Invoice"><i class="fa fa-download"></i></a>
							</td> <?php } 
							   else{?>
								<td></td>
								<?php } ?>
							<td class="info text-right"><?= $row_expense['total_fee'] ?></td>
							<td>
								<button class="btn btn-info btn-sm" onclick="expense_update_modal(<?= $row_expense['expense_id'] ?>)" title="Edit Entry"><i class="fa fa-pencil-square-o"></i></button>
							</td>			
						</tr>
						<?php
					}
					?>
				</tbody>
				<tfoot>
					<tr class="active">
						<th colspan="6"  class="text-right">Total : </th>
						<th colspan="1" class="text-right info"><?= number_format($total_expense_amt, 2); ?></th>
						<th colspan="1"></th>						
					</tr>
				</tfoot>	
			</table>	
	 </div>
    </div>
</div>
<script>
$('#tbl_expense_list').dataTable({
		"pagingType": "full_numbers"
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>