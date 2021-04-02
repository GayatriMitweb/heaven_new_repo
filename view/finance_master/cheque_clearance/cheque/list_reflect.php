<?php
include "../../../../model/model.php";

$status = $_POST['status'];
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from bank_cash_book_master where 1 and payment_mode='Cheque' ";
if($status!="All"){
	$query .= " and clearance_status='$status'";
}
include "../../../../model/app_settings/branchwise_filteration.php";
$query .= " and payment_amount!='0' and payment_type='Bank' order by register_id desc";
?>
<div class="row mg_tp_20" style="padding-bottom: 100px;"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-bordered" id="tbl_list" style="margin: 20px 0 !important;">
 	<thead>
 		<tr class="table-heading-row" >
 			<th>S_No.</th>
 			<th>Booking_Type</th>
 			<th>Payment_ID</th>
 			<th>Amount</th>
 			<th>Cheque_No.</th>
 			<th>Narration</th>
 			<th>Cleared_Date</th>
 			<th>Clear</th>
 			<th>Cancel</th>
 		</tr>
 	</thead>
 	<tbody>
 		<?php 
 		$count = 0;
 		$sq_transaction = mysql_query($query);
 		while($row_transaction = mysql_fetch_assoc($sq_transaction)){
			$date = $row_transaction['payment_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
			if($status=='Cleared'){
				$date = $row_transaction['payment_date'];
			}else{
				$date = date('d-m-Y');
			}
 			if($row_transaction['module_name']=="Employee Salary"){ $payment_id = get_emp_salary_id($row_transaction['module_entry_id'],$year); }

 		  if($row_transaction['module_name']=="Visa Booking"){ $payment_id = get_visa_booking_payment_id($row_transaction['module_entry_id'],$year); }
 		  if($row_transaction['module_name']=="Visa Booking Refund Paid"){ $payment_id = get_visa_booking_refund_id($row_transaction['module_entry_id'],$year); }

			 if($row_transaction['module_name']=="Excursion Booking"){ $payment_id = get_exc_booking_payment_id($row_transaction['module_entry_id'],$year); }
			 if($row_transaction['module_name']=="Excursion Booking Refund Paid"){ $payment_id = get_exc_booking_refund_id($row_transaction['module_entry_id'],$year); }
			 
 		  if($row_transaction['module_name']=="Passport Booking"){ $payment_id = get_passport_booking_payment_id($row_transaction['module_entry_id'],$year); }
 		  if($row_transaction['module_name']=="Passport Booking Refund Paid"){ $payment_id = get_passport_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Air Ticket Booking"){ $payment_id = get_ticket_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Air Ticket Booking Refund Paid"){ $payment_id = get_ticket_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Train Ticket Booking"){ $payment_id = get_train_ticket_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Train Ticket Booking Refund Paid"){ $payment_id = get_train_ticket_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Hotel Booking"){ $payment_id = get_hotel_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Hotel Booking Refund Paid"){ $payment_id = get_hotel_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Car Rental Booking"){ $payment_id = get_car_rental_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Car Rental Booking Refund Paid"){ $payment_id = get_car_rental_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Group Booking"){ $payment_id = get_group_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Group Booking Refund Paid"){ $payment_id = get_group_booking_group_refund_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Group Booking Traveller Refund Paid"){ $payment_id = get_group_booking_traveler_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Package Booking"){ $payment_id = get_package_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Package Booking Traveller Refund Paid"){ $payment_id = get_package_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Other Expense Booking"){ $payment_id = get_other_expense_payment_id($row_transaction['module_entry_id'],$year); }
			if($row_transaction['module_name']=="Other Income Payment"){ $payment_id = get_other_income_payment_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Vendor Payment"){ $payment_id = get_vendor_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Vendor Advance Payment"){ $payment_id = get_vendor_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Vendor Refund Paid"){ $payment_id = get_vendor_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="TDS Payment"){ $payment_id = get_tds_payment_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Miscellaneous Booking"){ $payment_id = get_misc_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Miscellaneous Booking Refund Paid"){ $payment_id = get_misc_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Bus Booking"){ $payment_id = get_bus_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Bus Booking Refund Paid"){ $payment_id = get_bus_booking_refund_id($row_transaction['module_entry_id'],$year); }

 			if($row_transaction['module_name']=="Forex Booking"){ $payment_id = get_forex_booking_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="GST Monthly Payment"){ $payment_id = get_gst_payment_id($row_transaction['module_entry_id'],$year); }
 			if($row_transaction['module_name']=="Airline Supplier Payment"){ $payment_id = get_flight_supplier_payment_id($row_transaction['module_entry_id'],$year); }
			
			if($row_transaction['module_name']=="Corporate Advance Payment"){ $payment_id = get_custadv_payment_id($row_transaction['module_entry_id'],$year); }
			if($row_transaction['module_name']=="B2B Booking"){ 
				$sq_payment = mysql_fetch_assoc(mysql_query("select * from b2b_payment_master where entry_id='$row_transaction[module_entry_id]'"));
				$payment_id = $sq_payment['payment_id']; }

			if($row_transaction['module_name']=="Hotel Vendor" ||$row_transaction['module_name']=="Transport Vendor" ||$row_transaction['module_name']=="Car Rental Vendor" ||$row_transaction['module_name']=="DMC Vendor" ||$row_transaction['module_name']=="Visa Vendor" ||$row_transaction['module_name']=="Passport Vendor" ||$row_transaction['module_name']=="Ticket Vendor" ||$row_transaction['module_name']=="Excursion Vendor" ||$row_transaction['module_name']=="Insurance Vendor" ||$row_transaction['module_name']=="Train Ticket Vendor" ||$row_transaction['module_name']=="Other Vendor" ||$row_transaction['module_name']=="Cruise Vendor"){ 
				$payment_id = get_vendor_payment_id($row_transaction['module_entry_id'],$year); }
			if($row_transaction['module_name']=="B2b Deposit"){ $payment_id = $row_transaction['module_entry_id']; }

			if($row_transaction['clearance_status']=="Pending"){ $bg = ""; }
			else if($row_transaction['clearance_status']=="Cancelled"){ $bg = "danger"; }
			else if($row_transaction['clearance_status']=="Cleared"){ $bg = "success"; }
			else if($row_transaction['clearance_status']==""){ $bg = ""; }
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_transaction['module_name'] ?></td>
				<td><?= $payment_id ?></td>
				<td><?= $row_transaction['payment_amount'] ?></td>
				<td><?= $row_transaction['transaction_id'] ?></td>
				<td><?= $row_transaction['particular'] ?></td>
				<td>
					<input type="text" name="status_date<?= $count ?>" id="status_date<?= $count ?>" placeholder="Date" value="<?= $date ?>" class="form-control">
				</td>
				<td>
					<?php if($row_transaction['clearance_status']!="Cleared" && $row_transaction['payment_mode'] == 'Cheque'){ ?>
					<button class="btn btn-info btn-sm" onclick="clearance_status_change(this, <?= $row_transaction['register_id'] ?>, 'Cleared', 'status_date<?= $count ?>','<?= $row_transaction['module_name'] ?>',<?= $row_transaction['module_entry_id'] ?>,<?= $row_transaction['transaction_id'] ?>,<?= $row_transaction['payment_amount']?>,'','cheque')" title="Clear"><i class="fa fa-check-square-o"></i></button>
					<?php } ?>
				</td>
				<td>
					<?php if($row_transaction['clearance_status']!="Cancelled" && $row_transaction['payment_mode'] == 'Cheque'){ ?>
					<button class="btn btn-danger btn-sm" onclick="clearance_status_change(this, <?= $row_transaction['register_id'] ?>, 'Cancelled', 'status_date<?= $count ?>','<?= $row_transaction['module_name'] ?>',<?= $row_transaction['module_entry_id'] ?>,<?= $row_transaction['transaction_id'] ?>,<?= $row_transaction['payment_amount']?>,'','cheque')" title="Cancel cheque"><i class="fa fa-times"></i></button>
					<?php } ?>
				</td>
			</tr>
			<script>
				$('#status_date<?= $count ?>').datetimepicker({ timepicker:false, format:'d-m-Y' });
			</script>
			<?php } ?>
	</tbody>
</table>
</div> </div> </div>

<script>
$('#tbl_list').dataTable({
		"pagingType": "full_numbers"
	});
function clearance_status_change(ele, register_id, status, status_date_id,module_name,module_entry_id,transaction_id,payment_amount,particular,type){
	
	var status_date = $('#'+status_date_id).val();
	$('#vi_confirm_box').vi_confirm_box({
	callback: function(data1){
		if(data1=="yes"){
			$(ele).button('loading');
			$.ajax({
				type:'post',
				url:base_url()+'controller/finance_master/cheque_clearance/status_update.php',
				data:{ register_id : register_id, status : status, status_date : status_date,module_name:module_name,module_entry_id:module_entry_id,transaction_id:transaction_id,payment_amount:payment_amount,type1 : type,particular : particular },
				success:function(result){
					msg_alert(result);
					list_reflect();
				}
			});
		}
	}
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>