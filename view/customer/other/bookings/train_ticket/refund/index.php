<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">
			<div class="col-md-3">
				<select name="ticket_idr" id="ticket_idr" style="width:100%" onchange="traion_refund_report_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_ticket = mysql_query("select * from train_ticket_master where customer_id='$customer_id' and train_ticket_id in ( select train_ticket_id from train_ticket_master_entries where status='Cancel' ) order by train_ticket_id desc");
			        while($row_ticket = mysql_fetch_assoc($sq_ticket)){

						$date = $row_ticket['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];
			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			          ?>
			          <option value="<?= $row_ticket['train_ticket_id'] ?>"><?= get_train_ticket_booking_id($row_ticket['train_ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_report_refund" class="main_block"></div>


<script>
$('#ticket_idr').select2();
function traion_refund_report_reflect()
{
	var ticket_id = $('#ticket_idr').val();
	$.post('bookings/train_ticket/refund/refund_report_reflect.php', { ticket_id : ticket_id }, function(data){
		$('#div_report_refund').html(data);
	});
}
traion_refund_report_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>