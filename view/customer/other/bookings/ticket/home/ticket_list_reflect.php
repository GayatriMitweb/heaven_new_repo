<?php 
include "../../../../../../model/model.php";

$ticket_id = $_POST['ticket_id'];
$customer_id = $_SESSION['customer_id'];
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-bordered bg_white cust_table" id="ticket_list" style="margin:20px 0 !important">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Airline_Name</th>
			<th>Trip_Type</th>
			<th>Travel_Date/Time</th>
			<th>View</th>
			<th class="text-right info">Total_Amount</th>
			<th class="text-right success">Paid_Amount</th>
			<th class="danger text-right">Cncl_amount</th>
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$query = "select * from ticket_master where 1 ";
		$query .= " and customer_id='$customer_id'";
		if($ticket_id!="")
		{
			$query .= " and ticket_id='$ticket_id'";
		}
		if($from_date!="" && $to_date!=""){
			$from_date = date('Y-m-d', strtotime($from_date));
			$to_date = date('Y-m-d', strtotime($to_date));
			$query .= " and created_at between '$from_date' and '$to_date'";
		}
       
		$count = 0;
		$sq_ticket = mysql_query($query);
		while($row_ticket = mysql_fetch_assoc($sq_ticket)){

			$date = $row_ticket['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$pass_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]'"));
			$cancel_count = mysql_num_rows(mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]' and status='Cancel'"));
			if($pass_count==$cancel_count){
				$bg="danger";
			}
			else {
				$bg="#fff";
			}
			$sq_customer_info = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			$sq_ticket_info = mysql_fetch_assoc(mysql_query("select * from ticket_trip_entries where ticket_id='$row_ticket[ticket_id]'"));

			$sq_paid_amount = mysql_fetch_assoc(mysql_query("SELECT sum(payment_amount) as sum from ticket_payment_master where ticket_id='$row_ticket[ticket_id]' and clearance_status!='Pending' and clearance_status!='Cancelled'"));
			
			$sale_total_amount = $row_ticket['ticket_total_cost'];
			$cancel_amount = $row_ticket['cancel_amount'];
			$paid_amount = $sq_paid_amount['sum'];
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;

			if($paid_amount > $cancel_amount && $cancel_amount == '0'){
				$balance_amount = $sale_total_amount - $paid_amount;
			}
			else if($paid_amount > $cancel_amount && $cancel_amount != '0'){
				$balance_amount = 0;
			}
			else{
				$balance_amount = $cancel_amount - $paid_amount;
			}
			//Total
			$total_amount += $sale_total_amount;
			$total_paid += $paid_amount;
			$total_cancel += $cancel_amount;
			$total_balance += $balance_amount;
			?>	
			<tr class="<?=$bg?>">
				<td><?= ++$count ?></td>
				<td><?= get_ticket_booking_id($row_ticket['ticket_id'],$year) ?></td>
				<td><?= $sq_ticket_info['airlines_name'] ?></td>
				<td><?= $row_ticket['type_of_tour'] ?></td>
				<td><?= get_datetime_user($sq_ticket_info['departure_datetime'])  ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="package_view_modal(<?= $row_ticket['ticket_id'] ?>)" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></button>
				</td>
				<td class="info text-right"><?= $sale_total_amount ?></td>
				<td class="text-right success"><?= number_format($paid_amount,2) ?></td>
				<td class="danger text-right"><?= $cancel_amount ?></td>
				<td class="warning text-right"><?= number_format($balance_amount,2) ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="6"></th>
			<th class="text-right info"><?= number_format($total_amount, 2); ?></th>
			<th class="text-right success"><?= number_format($total_paid, 2); ?></th>
			<th class="text-right danger"><?= number_format($total_cancel, 2); ?></th>
			<th class="text-right warning"><?= number_format($total_balance, 2); ?></th>
			 
		</tr>
	</tfoot>
</table>
</div> </div> </div>
<div id="div_ticket_content_display"></div>
<script>
$('#ticket_list').dataTable({
	"pagingType": "full_numbers"
});

function package_view_modal(booking_id)
  {
  	var base_url = $('#base_url').val();
    $.post(base_url+'view/customer/other/bookings/ticket/home/view/index.php', { ticket_id : booking_id }, function(data){
      $('#div_ticket_content_display').html(data);
    });
  }
</script>
