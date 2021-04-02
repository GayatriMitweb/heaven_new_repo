<?php include "../../../../../model/model.php"; 

$supplier_id = $_GET['supplier_id']?>

<div class="panel panel-default panel-body mg_bt_10">

<div class="row"> 

	<div class="col-md-6">

		<h3 class="editor_title">Purchase Details</h3>
		<div class="table-responsive">
		<table class="table trable-hover table-bordered no-marg" id="supplier_info2">
		<thead>
		<tr class="table-heading-row">
			<th style="padding-left: 5px !important;">S_No.</th>
			<th>Purchase_type</th>
			<th>Purchase_Date</th>
			<th>Debit_amount</th>
		</tr>
		</thead>
			<tbody>
				<?php 
				$total_amount=0;
				$booking_amt=0;
				$count = 0;

				$sq_query = mysql_query("select * from vendor_estimate where vendor_type_id='$supplier_id' and vendor_type='Visa Vendor' ");

				 while($row_query = mysql_fetch_assoc($sq_query))
			        {       	                      	
			            $count++;
			            $booking_amt = $row_query['net_total'] - $row_query['refund_net_total'];
			            $total_amount = $total_amount + $booking_amt; ?>
			        	<tr>
			            	<td style="padding-left: 5px !important;"><?= $count ?></td>
			            	<td><?php echo $row_query['estimate_type']; ?></td>
			            	<td><?php echo get_date_user($row_query['purchase_date']); ?></td>
			            	<td><?php echo number_format($booking_amt,2); ?></td>   
			            </tr>     
			    <?php }   ?>            
			</tbody>
		<tfoot>
			<tr class="active">
				<th colspan="4" class="text-right">Total Debit Amount : <?= number_format($total_amount,2) ?></th>
			</tr>
		</tfoot>
		</table>

</div>

	</div>

	<div class="col-md-6">

		<h3 class="editor_title">Top-Up Details</h3>
		<div class="table-responsive">

<!-- Topup table -->

<table class="table trable-hover table-bordered no-marg" id="supplier_info1">

<thead>

<tr class="table-heading-row">

	<th>S_No.</th>

	<th>Payment_Date</th>

	<th>Credit_amount</th>

</tr>

</thead>

<tbody>

	<?php 

	$total_amount=0;    	            
	$count = 0;
  	$sq_supp = mysql_query("select * from visa_supplier_payment where supplier_id='$supplier_id' and payment_amount !='0' and (clearance_status!='Pending' and clearance_status!='Cancelled')");  

  	while($row_supp = mysql_fetch_assoc($sq_supp))

    {

    $count++;

    $total_amount = $total_amount + $row_supp['payment_amount']; ?>

	<tr>

    	<td><?= $count ?></td>

    	<td><?php echo get_date_user($row_supp['payment_date']); ?></td>

    	<td><?php echo number_format($row_supp['payment_amount'],2); ?></td>   

    </tr>     

    <?php }   ?> 

    

</tbody>

<tfoot>

	<tr class="active">

		<th colspan="3" class="text-right">Total Credit Amount : <?= number_format($total_amount,2) ?></th>

	</tr>

</tfoot>



</table>

</div>

	</div>

<!-- Booking Table -->

</div>

</div>