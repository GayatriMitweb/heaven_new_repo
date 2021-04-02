<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="profile_box main_block">
				<legend>Summary</legend>
				<div class="table-responsive">
					<table class="table table-bordered no-marg">
						<thead>
							<tr class="table-heading-row">
								<th>S_No</th>
								<th>Date</th>
								<th class="text-right">Amount</th>
								<th>Mode</th>
								<th>Payment_ID</th>
								<th>Order_ID</th>
								<th>Bank_Name</th>
								<th>Cheque_No/ID</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 0;
							$sq_payment = mysql_query("SELECT * from b2b_payment_master where booking_id='$booking_id'");

							while($row_payment = mysql_fetch_assoc($sq_payment)){
								if($row_payment['payment_amount'] != '0'){
									$count++;
									$bg='';
									if($row_payment['clearance_status']=="Pending"){ 
										$bg='warning';
									}
									else if($row_payment['clearance_status']=="Cancelled"){ 
										$bg='danger';
									}

									?>
									<tr class="<?= $bg;?>">				
										<td><?= $count ?></td>
										<td><?= date('m-d-Y', strtotime($row_payment['payment_date'])); ?></td>
										<td class="text-right"><?= $row_payment['payment_amount'] ?></td>
										<td><?= $row_payment['payment_mode'] ?></td>
										<td><?= $row_payment['payment_id'] ?></td>
										<td><?php echo ($row_payment['order_id']=='')?'NA':$row_payment['order_id'];  ?></td>
										<td><?php echo ($row_payment['bank_name']=="")?'NA': $row_payment['bank_name']; ?></td>
										<td><?php echo ($row_payment['transaction_id']=='')?'NA': $row_payment['transaction_id']; ?></td>
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
</div>