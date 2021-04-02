 <?php
 //sale 
 $sale_total_amount=$sq_hotel_info['total_fee'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

//Cancel
$cancel_amount=$sq_hotel_info['cancel_amount'];
$pass_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$sq_hotel_info[booking_id]'"));
$cancel_count = mysql_num_rows(mysql_query("select * from hotel_booking_entries where booking_id='$sq_hotel_info[booking_id]' and status='Cancel'"));

//Paid
$query = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum ,sum(credit_charges) as sumc from hotel_booking_payment where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum']+ $query['sumc'];
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
						<th>Amount</th>
				    </tr>
				</thead>
				<tbody>
				<?php 
					$count = 0;
					$query = "select * from hotel_booking_payment where booking_id='$booking_id' ";
					$sq_payment = mysql_query($query);
					while($row_payment = mysql_fetch_assoc($sq_payment))
					{
						if($row_payment['payment_amount'] != '0'){
						    $count++;
							$sq_booking = mysql_fetch_assoc(mysql_query("select * from hotel_booking_master where booking_id='$row_payment[booking_id]'"));
			                $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
			                
			                $bg="";

							if($row_payment['clearance_status']=="Pending"){ 
								$bg='warning';
							}
							else if($row_payment['clearance_status']=="Cancelled"){ 
								$bg='danger';
							}
							else{ $bg = 'success';}
				

						?>
						<tr class="<?= $bg;?>">				
							<td><?= $count ?></td>
							<td><?= get_date_user($row_payment['payment_date']) ?></td>
							<td><?= $row_payment['payment_mode'] ?></td>
							<td><?= $row_payment['bank_name'] ?></td>
							<td><?= $row_payment['transaction_id'] ?></td>
							<td><?= number_format($row_payment['payment_amount'] + $row_payment['credit_charges'] , 2) ?></td>
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
