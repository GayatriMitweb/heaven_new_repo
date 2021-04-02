<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
?>
    <!-- Filter-panel -->

    <div class="app_panel_content Filter-panel">
		<div class="row">		
			<div class="col-md-3">
				<select name="ticket_id_filterp" id="ticket_id_filterp" style="width:100%" onchange="ticket_report_list_reflect()">
			        <option value="">Select Booking</option>
			        <?php 
			        $sq_ticket = mysql_query("select * from ticket_master where customer_id='$customer_id'");
			        while($row_ticket = mysql_fetch_assoc($sq_ticket)){
						$date = $row_ticket['created_at'];
						$yr = explode("-", $date);
						$year =$yr[0];

			          $sq_customer = mysql_fetch_assoc(mysql_query("select * from customer_master where customer_id='$row_ticket[customer_id]'"));
			          ?>
			          <option value="<?= $row_ticket['ticket_id'] ?>"><?= get_ticket_booking_id($row_ticket['ticket_id'],$year).' : '.$sq_customer['first_name'].' '.$sq_customer['last_name'] ?></option>
			          <?php
			        }
			        ?>
			    </select>
			</div>
		</div>
	</div>

<div id="div_ticket_report_list" class="main_block"></div>

<script>
$('#ticket_id_filterp').select2();
	function ticket_report_list_reflect()
	{
		var ticket_id = $('#ticket_id_filterp').val();

		$.post('bookings/ticket/report/ticket_report_list_reflect.php', { ticket_id : ticket_id }, function(data){
			$('#div_ticket_report_list').html(data);
		});
	}
	ticket_report_list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>