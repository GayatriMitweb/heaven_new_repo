<?php
//sale 
$sale_total_amount=$sq_booking['net_total'] + $charge;
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

//paid
$cancel_amount=$sq_booking['cancel_amount'];
$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum,sum(credit_charges) as sumc from bus_booking_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum'] + $query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

//Cancel
$cancel_amount=$sq_booking['cancel_amount'];
$pass_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$sq_booking[booking_id]'"));
$cancel_count = mysql_num_rows(mysql_query("select * from bus_booking_entries where booking_id='$sq_booking[booking_id]' and status='Cancel'"));

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
					<table class="table table-bordered no-marg">
						<thead>
							<tr class="table-heading-row">
								<th>S_No</th>
								<th>Date</th>
								<th>Mode</th>
								<th>Bank_Name</th>
								<th>Cheque_No/ID</th>
								<th class="text-right">Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$query = "SELECT * from bus_booking_payment_master where 1";		
							if($financial_year_id!=""){
								$query .= " and financial_year_id='$financial_year_id'";
							}
							if($booking_id!=""){
								$query .= " and booking_id='$booking_id'";
							}
							if($payment_mode!=""){
								$query .= " and payment_mode='$payment_mode'";
							}
							if($customer_id!=""){
								$query .= " and booking_id in (select booking_id from bus_booking_master where customer_id='$customer_id')";
							}
							if($payment_from_date!='' && $payment_to_date!=''){
								$payment_from_date = get_date_db($payment_from_date);
								$payment_to_date = get_date_db($payment_to_date);
								$query .=" and payment_date between '$payment_from_date' and '$payment_to_date'";
							}
							$bg;
							$count = 0;
							$total_paid_amt=0;

							$sq_pending_amount=0;
							$sq_cancel_amount=0;
							$sq_paid_amount=0;
							$Total_payment=0;
						
							$sq_payment = mysql_query($query);

							while($row_payment = mysql_fetch_assoc($sq_payment)){
								if($row_payment['payment_amount'] != '0'){
									$count++;

									$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_payment[booking_id]'"));
									$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_bus_info[customer_id]'"));
									
									$bg='';
									$sq_paid_amount = $sq_paid_amount + $row_payment['payment_amount'];
									if($row_payment['clearance_status']=="Pending"){ 
										$bg='warning';
										$sq_pending_amount = $sq_pending_amount + $row_payment['payment_amount'];
									}
									else if($row_payment['clearance_status']=="Cancelled"){ 
										$bg='danger';
										$sq_cancel_amount = $sq_cancel_amount + $row_payment['payment_amount'];
									}

									?>
									<tr class="<?= $bg;?>">				
										<td><?= $count ?></td>
										<td><?= get_date_user($row_payment['payment_date']) ?></td>
										<td><?= $row_payment['payment_mode'] ?></td>
										<td><?= $row_payment['bank_name'] ?></td>
										<td><?= $row_payment['transaction_id'] ?></td>
										<td class="text-right"><?= number_format($row_payment['payment_amount']+$row_payment['credit_charges'],2) ?></td>
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