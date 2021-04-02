<?php
include "../../../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from train_ticket_refund_master where 1 ";
if($ticket_id!=""){
	$query .=" and train_ticket_id='$ticket_id'";
}
$query .=" and train_ticket_id in ( select train_ticket_id from train_ticket_master where customer_id='$customer_id' )";

$sq_ticket_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master where train_ticket_id='$ticket_id'"));

$sq_paid_amount = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from train_ticket_payment_master where train_ticket_id='$ticket_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_refund_amount = mysql_fetch_assoc(mysql_query("select sum(refund_amount)as sum from train_ticket_refund_master where train_ticket_id='$ticket_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_refund_pen_amount = mysql_fetch_assoc(mysql_query("select sum(refund_amount)as sum from train_ticket_refund_master where train_ticket_id='$ticket_id' and clearance_status='Pending'"));

$sale_amount = $sq_ticket_info['net_total'] - $sq_ticket_info['refund_net_total'];

$bal_amount= $sq_paid_amount['sum'] - $sale_amount;


?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered table-hover cust_table" id="tbl_refund" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right success">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_paid_amount=0;
		$sq_refund = mysql_query($query);
		while($row_refund = mysql_fetch_assoc($sq_refund)){

			$date = $row_refund['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$traveler_name = "";
			$sq_refund_entries = mysql_query("select * from train_ticket_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){

				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			 
			$traveler_name = "";
			$sq_refund_entries = mysql_query("select * from train_ticket_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from train_ticket_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			$traveler_name = trim($traveler_name, ", ");
			
			if($row_train_ticket_refund['clearance_status']=='Pending') { $bg = "warning"; }
			else if($row_train_ticket_refund['clearance_status']=='Cancelled') { $bg = "danger"; }
			else{ $bg = ""; }

			$v_voucher_no = get_train_ticket_booking_refund_id($row_refund['refund_id']);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $traveler_name;
			$v_service_name = "Train Ticket Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";
			$total_refund = $total_refund+$row_refund['refund_amount'];			

			if($row_refund['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cancelled"){ $bg='warning';
				$sq_can_amount = $sq_can_amount + $row_refund['refund_amount'];
			}

			if($row_refund['clearance_status']==""){ $bg='';
			}
			$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];

			?>
			<tr class="<?= $bg?>">
				<td><?= ++$count ?></td>
				<td><?= get_train_ticket_booking_id($row_refund['train_ticket_id'],$year); ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= $row_refund['refund_amount'] ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2" class="text-right success" >Refund : <?= ($sq_paid_amount=='')?number_format(0,2):number_format($sq_paid_amount,2); ?></th>
			<th colspan="2" class="text-right info">Pending : <?= ($sq_pending_amount=='')?number_format(0,2):number_format($sq_pending_amount,2);?></th>
			<th colspan="2" class="text-center danger" >Cancelled : <?= ($sq_can_amount=='')?number_format(0,2):number_format($sq_can_amount,2); ?></th>
			<th colspan="1" class="text-right success">Total Refund : <?= number_format(($sq_paid_amount - $sq_pending_amount - $sq_can_amount),2);?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund').dataTable({
	"pagingType": "full_numbers"
});
</script>