<?php 
// sale
$sale_total_amount=$sq_exc_info['exc_total_cost'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

//Cancel
$cancel_amount=$sq_exc_info['cancel_amount'];
$pass_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$sq_exc_info[exc_id]'"));
$cancel_count = mysql_num_rows(mysql_query("select * from excursion_master_entries where exc_id='$sq_exc_info[exc_id]' and status='Cancel'"));

// Paid
$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum ,sum(credit_charges) as sumc from exc_payment_master where exc_id='$exc_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum'] + $query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

$sale_total_amount = $sale_total_amount + $query['sumc'];

if($pass_count == $cancel_count){
	if($paid_amount > 0){
		if($cancel_amount >0){
			if($paid_amount > $cancel_amount){
				$balance_amount = 0;
			}else{
				$balance_amount = $cancel_amount - $paid_amount;
			}
		}else{
		   $balance_amount = 0;
		}
	}
	else{
		$balance_amount = $cancel_amount;
	}
}
else{
	$balance_amount = $sale_total_amount - $paid_amount;
}

include "../../../../model/app_settings/generic_sale_widget.php";
?>
<div class="row">
<div class="col-xs-12">
    <div class="profile_box main_block" style="margin-top: 25px">
	    <h3 class="editor_title">Summary</h3>
	    <div class="table-responsive">
	        <table id="tbl_dynamic_exc_update" name="tbl_dynamic_exc_update" class="table table-bordered no-marg">
	            <thead>
	                <tr class="table-heading-row">
						<th>S_No.</th>
         				<th>Date</th>
				        <th>Mode</th>
				        <th>Bank_Name</th>
				        <th>Cheque_No/ID</th>
				        <th class="text-right">Amount</th>
				    </tr>
				</thead>
				<tbody>
				<?php
				 $count = 0;
				 $query = "SELECT * from exc_payment_master where exc_id='$exc_id'";		
				 $sq_exc_payment = mysql_query($query);	
				 $bg="";

				 while($row_exc_payment = mysql_fetch_assoc($sq_exc_payment)){
				 	if($row_exc_payment['payment_amount'] != '0'){
						$count++;
						$bg = '';
						if($row_exc_payment['clearance_status']=="Pending"){ $bg="warning";}
					    else if($row_exc_payment['clearance_status']=="Cancelled"){ $bg="danger";} 
					    else { $bg = 'success';}
						?>

						<tr class="<?php echo $bg; ?>">
					        <td><?php echo $count; ?></td>
					        <td><?php echo get_date_user($row_exc_payment['payment_date']); ?></td>
					        <td><?php echo $row_exc_payment['payment_mode']; ?></td>
					        <td><?php echo $row_exc_payment['bank_name']; ?></td>
					        <td><?php echo $row_exc_payment['transaction_id']; ?></td>
					        <td class="text-right"><?php echo $row_exc_payment['payment_amount'] + $row_exc_payment['credit_charges']; ?></td>
					    </tr>
				    <?php   } 
				    } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
