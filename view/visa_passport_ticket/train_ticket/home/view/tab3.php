<?php 
//sale
$sale_total_amount=$sq_booking['net_total']+$charge;
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }
//Cancel
$cancel_amount=$sq_booking['cancel_amount'];
$pass_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$sq_booking[train_ticket_id]'"));
$cancel_count = mysql_num_rows(mysql_query("select * from  train_ticket_master_entries where train_ticket_id='$sq_booking[train_ticket_id]' and status='Cancel'"));


//Paid
$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from train_ticket_payment_master where train_ticket_id='$train_ticket_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum']+$query['sumc'];
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
include "../../../../../model/app_settings/generic_sale_widget.php";
?>
	<div class="row">
		<div class="col-xs-12">
			<div class="profile_box main_block" style="margin-top: 25px">
				<h3 class="editor_title">Summary</h3>
				<div class="table-responsive">
				<table class="table table-bordered no-marg">
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
						$query = "select * from train_ticket_payment_master where 1";
						if($financial_year_id!=""){
							$query .= " and financial_year_id='$financial_year_id'";
						}
						if($train_ticket_id!=""){
							$query .= " and train_ticket_id='$train_ticket_id'";
						}
						if($payment_mode!=""){
							$query .= " and payment_mode='$payment_mode'";
						}
						if($customer_id!=""){
							$query .= " and train_ticket_id_id in (select train_ticket_id from train_ticket_master where customer_id='$customer_id')";
						}
						if($payment_from_date!='' && $payment_to_date!=''){
							$payment_from_date = get_date_db($payment_from_date);
							$payment_to_date = get_date_db($payment_to_date);
							$query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
						}

					 
						$bg;

						$sq_train_ticket_payment = mysql_query($query);
						$sq_pending_amount = 0;
						$sq_cancel_amount = 0;
						$sq_paid_amount = 0;
						$count = 0;

						while($row_train_ticket_payment = mysql_fetch_assoc($sq_train_ticket_payment)){
							if($row_train_ticket_payment['payment_amount'] != '0'){
								$count++;

								if($row_train_ticket_payment['clearance_status']=="Pending"){ $bg="warning";}
					    		else if($row_train_ticket_payment['clearance_status']=="Cancelled"){ $bg="danger";}

								$sq_train_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$row_train_ticket_payment[train_ticket_id]'"));

								if($row_train_ticket_payment['clearance_status']=="Pending"){ 
									$bg='warning';
								}
								else if($row_train_ticket_payment['clearance_status']=="Cancelled"){ 
									$bg='danger';
								}			
								else{  
									$bg='';				
								}

								?>
								<tr class="<?= $bg;?>">				
									<td><?= $count ?></td>
									<td><?= get_date_user($row_train_ticket_payment['payment_date']) ?></td>
									<td><?= $row_train_ticket_payment['payment_mode'] ?></td>
									<td><?= $row_train_ticket_payment['bank_name'] ?></td>
									<td><?= $row_train_ticket_payment['transaction_id'] ?></td>
									<td class="text-right"><?= number_format($row_train_ticket_payment['payment_amount']+$row_train_ticket_payment['credit_charges'],2) ?></td>
								</tr>
							<?php
						 }	
						}
						?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>	