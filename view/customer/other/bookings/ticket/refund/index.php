<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="ticket_id" id="ticket_id" style="width:100%" onchange="refund_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_ticket = mysql_query("select * from ticket_master where customer_id='$customer_id' and ticket_id in ( select ticket_id from ticket_master_entries where status='Cancel' ) order by ticket_id desc");
			        while($row_ticket = mysql_fetch_assoc($sq_ticket)){
						$date = $row_ticket['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			        $sq_entry = mysql_query("select * from ticket_master_entries where ticket_id='$row_ticket[ticket_id]' and status='Cancel'");
					while($row_entry = mysql_fetch_assoc($sq_entry)){
			          
			          ?>
			          <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$row_entry['first_name'].' '.$row_entry['last_name'] ?></option>
			          <?php
			      		}
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_report_refund" class="main_block"></div>


<script>
$('#ticket_id').select2();
function refund_report_reflect()
{
	var ticket_id = $('#ticket_id').val();
	$.post('bookings/ticket/refund/refund_report_reflect.php', { ticket_id : ticket_id }, function(data){
		$('#div_report_refund').html(data);
	});
}
refund_report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>