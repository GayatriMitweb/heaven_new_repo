<?php 
$sq_payment_sum = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from bus_booking_payment_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
$sq_refund_sum = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from bus_booking_refund_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_pay = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from bus_booking_refund_master where booking_id='$booking_id'"));
$sq_ref_pen_total = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from bus_booking_refund_master where booking_id='$booking_id' and clearance_status='Pending'"));
$sq_ref_can_total = mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from bus_booking_refund_master where booking_id='$booking_id' and clearance_status='Cancelled'"));

$toal_refund_sum=$sq_pay['sum'] - $sq_ref_can_total['sum'];
$net_total = $sq_booking['net_total'];
$paid_amount = $sq_payment_sum['sum'];
$cancel_amount = $sq_booking['cancel_amount'];
$refund_amount = $sq_booking['refund_net_total'];
$remaining=$refund_amount-$toal_refund_sum;
?>
<input type="hidden" id="refund_amount_tobe" name="refund_amount_tobe" value="<?php echo $refund_amount ?>">
<div class="row mg_tp_20 mg_bt_10">
	<div class="col-md-4 col-md-offset-4 col-sm-6 col-xs-12 mg_bt_10_xs">
		<div class="widget_parent-bg-img bg-green">
			<div class="widget_parent">
				<div class="stat_content main_block">
			        <span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Total Sale</span>
						<span class="stat_content-amount pull-right" data-original-title="" title=""><?= ($net_total=='')?'0.00': number_format($net_total,2) ?></span>
			        </span>
			        <span class="main_block content_span" data-original-title="" title="">
			         	<span class="stat_content-tilte pull-left" data-original-title="" title="">Paid Amount</span>
			        	<span class="stat_content-amount pull-right" data-original-title="" title=""> <?= ($paid_amount=='')?'0.00': $paid_amount?></span>
			        </span>	
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Cancellation Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?= number_format($cancel_amount, 2); ?></span>
			        </span>	        
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Refund Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($refund_amount, 2); ?></span>
			        </span>
					
					<span class="main_block content_span" data-original-title="" title="">
			            <span class="stat_content-tilte pull-left" data-original-title="" title="">Pending Refund Amount</span>
			            <span class="stat_content-amount pull-right" data-original-title="" title=""><?php echo number_format($remaining, 2); ?></span>
			        </span>
			    </div>	 
			</div>
		</div>		
	</div>
</div>
<hr>
<div class="row text-right mg_bt_20">
	<div class="col-xs-12">
		<button class="btn btn-info btn-sm ico_left" onclick="refund_save_modal()"><i class="fa fa-plus"></i>New Refund</button>
	</div>
</div>
<div id="div_refund_modal"></div>

<div class="row"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-bordered" id="tbl_busrefund_list">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Refund_Date</th>
			<th>Amount</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th>Voucher</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = $pending_amt = $cancelled_amt = 0;		
		$query = "select * from bus_booking_refund_master where booking_id='$booking_id' and refund_amount!='0'";
		$count = 0;
		$sq_refund = mysql_query($query);
		while($row_refund = mysql_fetch_assoc($sq_refund)){

			$count++;
			$sq_bus_info = mysql_fetch_assoc(mysql_query("select * from bus_booking_master where booking_id='$row_refund[booking_id]'"));
			$date = $sq_bus_info['created_at'];
		          $yr = explode("-", $date);
				  $year =$yr[0];
				  
			$total_refund = $total_refund+$row_refund['refund_amount'];

			if($row_refund['clearance_status']=="Pending"){
				$pending_amt = $pending_amt + $row_refund['refund_amount'];
				$bg = "warning";
			}
			else if($row_refund['clearance_status']=="Cancelled"){
				$cancelled_amt = $cancelled_amt + $row_refund['refund_amount'];
				$bg = "danger";
			}
			else{ $bg = "";}
			$sq_entries = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$sq_bus_info[customer_id]'"));
			$customer_name = ($sq_entries['type'] == 'Corporate') ? $sq_entries['company_name'] : $sq_entries['first_name'].' '.$sq_entries['last_name'];

			$date = $row_refund['refund_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			$v_voucher_no = get_bus_booking_refund_id($row_refund['refund_id'],$year1);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $customer_name;
			$v_service_name = "Bus Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$customer_id = $sq_bus_info['customer_id'];
			$refund_id = $row_refund['refund_id'];

			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id";

			?>
			<tr class="<?= $bg ?>">			
				<td><?= $count ?></td>
				<td><?= get_date_user($row_refund['refund_date']) ?></td>	
				<td class="text-right"><?= $row_refund['refund_amount'] ?></td>			
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td><a href="<?= $url ?>" class="btn btn-danger btn-sm" target="_blank" title="Voucher"><i class="fa fa-file-pdf-o"></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>	
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="2">Total Refund : <?= number_format($total_refund,2); ?></th>
			<th class="text-right warning" colspan="2">Pending Amount : <?= number_format($pending_amt, 2); ?></th>
			<th class="text-right danger" colspan="1">Cancelled Amount : <?= number_format($cancelled_amt, 2); ?></th>
			<th class="text-right success" colspan="2">Actual Refund : <?= number_format(($total_refund - $pending_amt - $cancelled_amt), 2); ?>
			<input type="hidden" name="total_refund_val" id="total_refund_val" value="<?php echo $total_refund - $cancelled_amt;?>">
			<input type="hidden" name="refund_amount_val" id="refund_amount_val" value="<?php echo $refund_amount;?>">

		</th>
		</tr>
	</tfoot>
</table>
<input type="hidden" id="ref_amt" value="<?= ($total_refund=="") ? 0 : $total_refund ?>">


</div> </div> </div>

<script>
$('#tbl_busrefund_list').dataTable({
        "pagingType": "full_numbers"
});
function refund_save_modal()
{
	var booking_id = $('#booking_id').val();
	var total_refund_val= $('#total_refund_val').val();
	var refund_amount_val= $('#refund_amount_val').val();
	var remaining_val=Number(refund_amount_val)-Number(total_refund_val);
	$.post('refund/refund_save_modal.php', { booking_id : booking_id , remaining_val : remaining_val}, function(data){
		$('#div_refund_modal').html(data);
	});
}
</script>