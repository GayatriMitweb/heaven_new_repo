<?php
include "../../../../../../model/model.php";

$passport_id = $_POST['passport_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from passport_refund_master where 1 ";
if($passport_id!=""){
	$query .=" and passport_id='$passport_id'";
}
$query .=" and passport_id in ( select passport_id from passport_master where customer_id='$customer_id' )";

$sq_passport_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$passport_id'"));

$sq_payment_info = mysql_fetch_assoc(mysql_query("select sum(payment_amount) as sum from passport_payment_master where passport_id='$passport_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_refund_info = mysql_fetch_assoc(mysql_query("SELECT sum(refund_amount) as sum from passport_refund_master where passport_id='$passport_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_pend_ref= mysql_fetch_assoc(mysql_query("select sum(refund_amount) as sum from passport_refund_master where passport_id='$passport_id' and clearance_status='Pending'"));


$sale_Amount=$sq_passport_info['passport_total_cost']-$sq_passport_info['total_refund_amount'];

$paid_amount = $sq_payment_info['sum'];

$refund_amount = $paid_amount-$sale_Amount;

$total_refund1=$refund_amount-$sq_refund_info['sum'];

?>

<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered table-hover bg_white cust_table" id="tbl_refund" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right success">Refund_Amount</th>
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

			$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from passport_master where passport_id='$row_refund[passport_id]'"));
			$date = $row_refund['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$traveler_name = "";
			$sq_refund_entries = mysql_query("select * from passport_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from passport_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			$traveler_name = trim($traveler_name, ", ");

			$total_refund = $total_refund+$row_refund['refund_amount'];
			($row_refund['clearance_status']=="Pending")?$bg = "warning":$bg='';

			if($row_refund['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cancelled"){ $bg='warning';
				$sq_can_amount = $sq_can_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cleared" || $row_refund['clearance_status']==""){ $bg=''; }

			$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];

			$sq_refund_entries = mysql_query("select * from passport_refund_entries where refund_id='$row_refund[refund_id]'");

			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){
				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from passport_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			$traveler_name = trim($traveler_name, ", ");

			if($row_refund['clearance_status']=="Pending"){ $bg = "warning"; }
			else if($row_refund['clearance_status']=="Cancelled"){ $bg = "danger"; }
			else{ $bg = ""; }
			$v_voucher_no = get_passport_booking_refund_id($row_refund['refund_id'],$year1);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $traveler_name;
			$v_service_name = "Passport Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";
			?>
			<tr class="<?= $bg?>">
				<td><?= ++$count ?></td>
				<td><?= get_passport_booking_id($row_refund['passport_id'],$year1); ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td  class="text-right success"><?= $row_refund['refund_amount'] ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="3"></th>
			<th class="text-right info" >Refund : <?= ($sq_paid_amount=='')?number_format(0,2): number_format($sq_paid_amount,2); ?></th>
			<th class="text-right warning">Pending : <?= ($sq_pending_amount=='')?number_format(0,2): number_format($sq_pending_amount,2);?></th>
			<th class="text-right danger">Cancelled : <?= ($sq_can_amount=='')?number_format(0,2): number_format($sq_can_amount,2); ?></th>
			<th class="text-right success">Total Refund: <?=  number_format(($sq_paid_amount - $sq_pending_amount - $sq_can_amount),2);?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
	
$('#tbl_refund').dataTable({
	"pagingType": "full_numbers"
});
</script>