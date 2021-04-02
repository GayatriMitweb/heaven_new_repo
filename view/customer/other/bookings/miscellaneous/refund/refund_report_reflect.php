<?php
include "../../../../../../model/model.php";

$misc_id = $_POST['misc_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from miscellaneous_refund_master where 1 ";
if($misc_id!=""){
	$query .=" and misc_id='$misc_id'";
}
$query .=" and misc_id in ( select misc_id from miscellaneous_master where customer_id='$customer_id' )";

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered table-hover bg_white cust_table" id="tbl_misc_refund" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>Sr. No</th>
			<th>Booking_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="success text-right">Refund_Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$count = 0;
		$bg;
		$sq_refund = mysql_query($query);
		$pen_amt=0;

		

		while($row_refund = mysql_fetch_assoc($sq_refund)){

			$traveler_name = "";
			$sq_miscellaneous = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master where misc_id='$row_refund[misc_id]'"));
			$date = $sq_miscellaneous['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$sq_refund_entries = mysql_query("select * from miscellaneous_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysql_fetch_assoc($sq_refund_entries)){

				$sq_entry_info = mysql_fetch_assoc(mysql_query("select * from miscellaneous_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			$traveler_name = trim($traveler_name, ", ");

			$total_refund = $total_refund+$row_refund['refund_amount'];

			($row_refund['clearance_status']=='Pending')?$bg='warning':$bg='';

			if($row_refund['clearance_status']=="Pending"){$pen_amt=$pen_amt+$row_refund['refund_amount'];}
			if($row_refund['clearance_status']=="Cancelled"){$can_amt=$can_amt+$row_refund['refund_amount'];}

			$date = $row_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$v_voucher_no = get_misc_booking_refund_id($row_refund['refund_id'],$year);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $traveler_name;
			$v_service_name = "miscellaneous Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";	

			?>
			<tr class="<?= $bg;?>">
				<td><?= ++$count ?></td>
				<td><?= get_misc_booking_id($row_refund['misc_id'],$year1); ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="success text-right"><?= $row_refund['refund_amount'] ?></td>
			</tr>
			<?php

		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2"  class="text-right info">Refund : <?= ($total_refund=='')?number_format(0,2):number_format($total_refund,2);?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($pen_amt=='')?number_format(0,2):number_format($pen_amt,2);?></th>	
			<th colspan="2" class="text-right danger">Cancelled : <?= number_format($can_amt,2); ?></th>
			<th colspan="1" class="text-right success">Total Refund : <?= number_format(($total_refund-$pen_amt-$can_amt),2)?></th>						
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#tbl_misc_refund').dataTable({
	"pagingType": "full_numbers"
});
</script>