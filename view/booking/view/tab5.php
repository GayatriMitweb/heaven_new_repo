<!-- Tour Payment details--> 
<?php
$sale_total_amount=$sq_package_info['tour_cost_total'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

$query = mysql_fetch_assoc(mysql_query("SELECT sum(amount) as sum from package_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

$cancel_est=mysql_fetch_assoc(mysql_query("select * from package_refund_traveler_estimate where booking_id='$sq_package_info[booking_id]'"));
$cancel_amount=$cancel_est['cancel_amount'];
if($cancel_amount != ''){	
	if($cancel_amount <= $paid_amount){
		$balance_amount = 0;
	}
	else{
		$balance_amount =  $cancel_amount - $paid_amount;
	}
}
else{
	$cancel_amount = ($cancel_amount == '') ? '0' : $cancel_amount;
	$balance_amount=$sale_total_amount-$paid_amount;
}
include "../../../../model/app_settings/generic_sale_widget.php";
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

				        <th>Receipt_For</th>

				        <th>Travel_Type</th>

				        <th class="text-right">Amount</th>

				    </tr>

				</thead>

				<tbody>

				<?php

				 $count = 0;

				 $query2 = "SELECT * from package_payment_master where booking_id='$booking_id'";		

				 $sq_package_payment = mysql_query($query2);	

				 $bg="";



				 while($row_package_payment = mysql_fetch_assoc($sq_package_payment)){

				 	if($row_package_payment['amount'] != '0'){

						$count++;

						$bg = '';

						if($row_package_payment['clearance_status']=="Pending"){ $bg="warning";}

					    else if($row_package_payment['clearance_status']=="Cancelled"){ $bg="danger";} 

						?>



						<tr class="<?php echo $bg; ?>">

					        <td><?php echo $count; ?></td>

					        <td><?php echo get_date_user($row_package_payment['date']); ?></td>

					        <td><?php echo $row_package_payment['payment_mode']; ?></td>

					        <td><?php echo $row_package_payment['bank_name']; ?></td>

					        <td><?php echo $row_package_payment['transaction_id']; ?></td>

					        <td><?php echo $row_package_payment['payment_for']; ?></td>

					        <td><?php echo $row_package_payment['travel_type']; ?></td>

					        <td class="text-right"><?php echo $row_package_payment['amount']; ?></td>

					    </tr>

				    <?php   }

				    }  ?>

				</tbody>

			</table>

		</div>

	</div>

</div>

</div>

