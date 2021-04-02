<?php 
//Sale
$sale_total_amount=$sq_visa_info['misc_total_cost'] + $credit_card_charges;
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

//Cancel
$cancel_amount=$sq_visa_info['cancel_amount'];
$pass_count = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$sq_visa_info[misc_id]'"));
$cancel_count = mysql_num_rows(mysql_query("select * from miscellaneous_master_entries where misc_id='$sq_visa_info[misc_id]' and status='Cancel'"));

//Paid
$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from miscellaneous_payment_master where misc_id='$misc_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum']+$credit_card_charges;
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

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

include "../../../../../../../model/app_settings/generic_sale_widget.php";
?>

<div class="row">
<div class="col-xs-12">
    <div class="profile_box main_block" style="margin-top: 25px">
	    <h3 class="editor_title">Summary</h3>
	    <div class="table-responsive">
	        <table id="tbl_dynamic_visa_update1" name="tbl_dynamic_visa_update1" class="table table-bordered no-marg">
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
				$query = "SELECT * from miscellaneous_payment_master where misc_id='$misc_id' and payment_amount!='0'";		
				$sq_visa_payment = mysql_query($query);	
				$bg="";

				while($row_visa_payment = mysql_fetch_assoc($sq_visa_payment)){
						$count++;
						$bg = '';
						if($row_visa_payment['clearance_status']=="Pending"){ $bg="warning";}
					    else if($row_visa_payment['clearance_status']=="Cancelled"){ $bg="danger";} 
					    else { $bg = 'success';}
						?>

						<tr class="<?php echo $bg; ?>">
					        <td><?php echo $count; ?></td>
					        <td><?php echo get_date_user($row_visa_payment['payment_date']); ?></td>
					        <td><?php echo $row_visa_payment['payment_mode']; ?></td>
					        <td><?php echo $row_visa_payment['bank_name']; ?></td>
					        <td><?php echo $row_visa_payment['transaction_id']; ?></td>
					        <td class="text-right"><?php echo number_format($row_visa_payment['payment_amount']+$row_visa_payment['credit_charges'],2); ?></td>
					    </tr>
				    <?php
				    } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
